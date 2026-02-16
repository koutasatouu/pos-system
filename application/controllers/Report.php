<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Use your helper or manual check
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
    }

    // ===============================================================
    // 1. SALES REPORT (Money In)
    // ===============================================================
    public function sales()
    {
        $data['title'] = 'Sales Report';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Filter Logic: Default to THIS MONTH
        $start_date = $this->input->get('start_date') ?? date('Y-m-01');
        $end_date   = $this->input->get('end_date') ?? date('Y-m-d');

        // Query: Get Sum of Sales per Day
        $query = "
            SELECT 
                DATE(created_at) as date, 
                COUNT(id) as total_transactions, 
                SUM(final_amount) as total_revenue 
            FROM orders 
            WHERE DATE(created_at) BETWEEN '$start_date' AND '$end_date'
            GROUP BY DATE(created_at)
            ORDER BY date ASC
        ";
        $data['daily_sales'] = $this->db->query($query)->result_array();

        // Calculate Grand Total for the filtered period
        $data['grand_total'] = 0;
        foreach ($data['daily_sales'] as $day) {
            $data['grand_total'] += $day['total_revenue'];
        }

        // Pass dates back to view for the input fields
        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('report/sales_report', $data);
        $this->load->view('templates/footer');
    }

    // ===============================================================
    // 2. STOCK REPORT (Inventory Assets)
    // ===============================================================
    public function stock()
    {
        $data['title'] = 'Stock Report';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Get all ingredients and calculate asset value (Stock * Cost)
        $this->db->select('*');
        $this->db->from('ingredients');
        $this->db->order_by('current_stock', 'ASC'); // Show low stock first
        $data['stocks'] = $this->db->get()->result_array();

        // Calculate Total Asset Value
        $data['total_asset_value'] = 0;
        foreach ($data['stocks'] as $s) {
            $data['total_asset_value'] += ($s['current_stock'] * $s['cost_per_unit']);
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('report/stock_report', $data);
        $this->load->view('templates/footer');
    }
}
