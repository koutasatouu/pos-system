<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchase extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Stock In or Purchasing';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['suppliers'] = $this->db->get('suppliers')->result_array();
        $data['ingredients'] = $this->db->get('ingredients')->result_array();
        $today = date('Ymd');
        $query = $this->db->query("SELECT MAX(invoice_no) as last_invoice FROM purchases WHERE invoice_no LIKE 'INV-$today-%'");
        $result = $query->row_array();
        if ($result['last_invoice']) {
            $last_no = substr($result['last_invoice'], -3);
            $next_no = sprintf('%03d', $last_no + 1);
        } else {
            $next_no = '001';
        }
        $data['invoice_no'] = "INV-$today-$next_no";

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('purchase/stock_in', $data);
        $this->load->view('templates/footer');
    }

    public function process()
    {
        // 1. Validate Input
        $this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');

        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            // DATA PREPARATION
            $supplier_id = $this->input->post('supplier_id');
            $invoice_no  = $this->input->post('invoice_no');
            $date        = $this->input->post('date');

            // Arrays from the dynamic form
            $ing_ids     = $this->input->post('ingredient_id'); // Array
            $qtys        = $this->input->post('qty');           // Array
            $prices      = $this->input->post('price');         // Array (Price PER UNIT)

            // Calculate Grand Total
            $grand_total = 0;
            if ($ing_ids) {
                for ($i = 0; $i < count($ing_ids); $i++) {
                    $grand_total += $prices[$i] * $qtys[$i];
                }
            }

            // START TRANSACTION (Ensures all 3 steps happen, or none happen)
            $this->db->trans_start();

            // STEP 1: Insert into 'purchases' (The Header)
            $data_purchase = [
                'supplier_id' => $supplier_id,
                'invoice_no'  => $invoice_no,
                'total_cost'  => $grand_total,
                'date'        => $date
            ];
            $this->db->insert('purchases', $data_purchase);
            $purchase_id = $this->db->insert_id(); // Get the ID we just created

            // STEP 2: Loop through items
            if ($ing_ids) {
                for ($i = 0; $i < count($ing_ids); $i++) {
                    $ing_id = $ing_ids[$i];
                    $qty    = $qtys[$i];
                    $price  = $prices[$i];
                    $total  = $qty * $price;

                    // A. Insert into 'purchase_items' (The History)
                    $data_item = [
                        'purchase_id'   => $purchase_id,
                        'ingredient_id' => $ing_id,
                        'qty'           => $qty,
                        'price'         => $total
                    ];
                    $this->db->insert('purchase_items', $data_item);

                    // B. Update 'ingredients' table (The Stock Increase)
                    // We also update the 'cost_per_unit' to the latest price
                    $this->db->set('current_stock', "current_stock + $qty", FALSE);
                    $this->db->set('cost_per_unit', $price);
                    $this->db->where('id', $ing_id);
                    $this->db->update('ingredients');
                }
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('msg_type', 'error');
                $this->session->set_flashdata('msg', 'Transaction Failed!');
            } else {
                $this->session->set_flashdata('msg_type', 'success');
                $this->session->set_flashdata('msg', 'Stock added successfully!');
            }

            redirect('purchase');
        }
    }

    // 1. Show List of Past Purchases
    public function history()
    {
        // Fix for the Menu Active State logic
        $data['menu_id'] = 5; // Force it to belong to Transaction Menu

        $data['title'] = 'Stock In History';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Get Purchases joined with Supplier Name
        $this->db->select('purchases.*, suppliers.name as supplier_name');
        $this->db->from('purchases');
        $this->db->join('suppliers', 'suppliers.id = purchases.supplier_id');
        $this->db->order_by('date', 'DESC');
        $this->db->order_by('id', 'DESC');
        $data['purchases'] = $this->db->get()->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('purchase/purchase_history', $data);
        $this->load->view('templates/footer');
    }

    // 2. AJAX Handler for View Detail Modal
    public function get_details()
    {
        $purchase_id = $this->input->post('id');

        // Get items for this purchase
        $this->db->select('purchase_items.*, ingredients.name, ingredients.unit');
        $this->db->from('purchase_items');
        $this->db->join('ingredients', 'ingredients.id = purchase_items.ingredient_id');
        $this->db->where('purchase_id', $purchase_id);
        $items = $this->db->get()->result_array();

        // Return as HTML Table Rows
        $html = '';
        foreach ($items as $item) {
            $html .= '<tr>';
            $html .= '<td>' . $item['name'] . '</td>';
            $html .= '<td>' . number_format($item['qty'], 0, ',', '.') . ' ' . $item['unit'] . '</td>';
            $html .= '<td>Rp ' . number_format($item['price'], 0, ',', '.') . '</td>';
            $html .= '</tr>';
        }
        echo $html;
    }
    // ===============================================================
    // CASHIER / POS FUNCTIONS (Selling to Customers)
    // ===============================================================

    public function cashier()
    {
        // Force Menu ID to be the Transaction Menu (ID 5)
        // This prevents the "Block" error you had earlier
        $data['menu_id'] = 5;

        $data['title'] = 'Cashier (POS)';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // 1. Get Categories
        $data['categories'] = $this->db->get('product_categories')->result_array();

        // 2. Get Products (Only Available ones)
        $this->db->select('products.*, product_categories.name as category_name');
        $this->db->from('products');
        $this->db->join('product_categories', 'product_categories.id = products.category_id');
        $this->db->where('is_available', 1);
        $data['products'] = $this->db->get()->result_array();

        // 3. Get Members
        $data['members'] = $this->db->where('is_active', 1)->get('members')->result_array();

        // 4. Generate Sales Invoice (POS-YYMMDD-XXXX)
        $data['invoice'] = 'POS-' . date('ymd') . '-' . strtoupper(substr(uniqid(), -4));

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('purchase/cashier', $data); // View located in purchase folder
        $this->load->view('templates/footer');
    }

    public function process_cashier()
    {
        // 1. Get Data from Form
        $invoice       = $this->input->post('invoice');
        $customer_name = $this->input->post('customer_name');
        $member_id     = $this->input->post('member_id'); // Can be empty
        $total_amount  = $this->input->post('final_amount'); // From Hidden Input
        $cash          = $this->input->post('cash');
        $note          = $this->input->post('note'); // Array

        // Cart Arrays
        $product_ids = $this->input->post('product_id');
        $qtys        = $this->input->post('qty');
        $prices      = $this->input->post('price');

        if (!$product_ids) {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Cart is empty!');
            redirect('purchase/cashier');
        }

        $this->db->trans_start();

        // 2. Insert into ORDERS table
        $data_order = [
            'invoice'        => $invoice,
            'customer_name'  => $customer_name,
            'member_id'      => $member_id ? $member_id : NULL,
            'user_id'        => $data['user']['id'] ?? 1, // Default to Admin if session fails
            'final_amount'   => $total_amount,
            'payment_method' => 'Cash',
            'status'         => 'Paid',
            'created_at'     => date('Y-m-d H:i:s')
        ];
        $this->db->insert('orders', $data_order);
        $order_id = $this->db->insert_id();

        // 3. Insert into ORDER_ITEMS table
        for ($i = 0; $i < count($product_ids); $i++) {
            $data_item = [
                'order_id'   => $order_id,
                'product_id' => $product_ids[$i],
                'qty'        => $qtys[$i],
                'price'      => $prices[$i],
                'note'       => $note[$i] ?? ''
            ];
            $this->db->insert('order_items', $data_item);

            // OPTIONAL: Update Member Points (1 Point per transaction? Or per 10k?)
            if ($member_id) {
                $this->db->set('points', 'points+1', FALSE);
                $this->db->where('id', $member_id);
                $this->db->update('members');
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Transaction Failed!');
            redirect('purchase/cashier');
        } else {
            // Success! Print Receipt?
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Transaction Success!');
            redirect('purchase/cashier'); // Or redirect to print
        }
    }
    // ===============================================================
    // ORDER HISTORY (Sales Report)
    // ===============================================================

    public function order_history()
    {
        // Force Menu ID to be Transaction (5)
        $data['menu_id'] = 5;

        $data['title'] = 'Order History';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Get Sales Data joined with Cashier Name and Member Name
        $this->db->select('orders.*, user.name as cashier_name, members.name as member_name');
        $this->db->from('orders');
        $this->db->join('user', 'user.id = orders.user_id'); // Who sold it?
        $this->db->join('members', 'members.id = orders.member_id', 'left'); // Who bought it?
        $this->db->order_by('created_at', 'DESC');
        $data['orders'] = $this->db->get()->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('purchase/order_history', $data); // View in purchase folder
        $this->load->view('templates/footer');
    }

    // AJAX Handler for Sales Details
    public function get_order_details()
    {
        $order_id = $this->input->post('id');

        // Get items for this specific order
        $this->db->select('order_items.*, products.name, products.code');
        $this->db->from('order_items');
        $this->db->join('products', 'products.id = order_items.product_id');
        $this->db->where('order_id', $order_id);
        $items = $this->db->get()->result_array();

        // Return as HTML Table Rows
        $html = '';
        foreach ($items as $item) {
            $html .= '<tr>';
            $html .= '<td>' . $item['name'] . ' <br><small class="text-muted">' . $item['code'] . '</small></td>';
            $html .= '<td>' . $item['qty'] . '</td>';
            $html .= '<td>Rp ' . number_format($item['price'], 0, ',', '.') . '</td>';
            $html .= '<td class="text-right font-weight-bold">Rp ' . number_format($item['price'] * $item['qty'], 0, ',', '.') . '</td>';
            $html .= '</tr>';

            // Show Note if exists
            if (!empty($item['note'])) {
                $html .= '<tr><td colspan="4" class="text-muted text-sm border-0 pt-0 pb-2"><em>Note: ' . $item['note'] . '</em></td></tr>';
            }
        }
        echo $html;
    }
}
