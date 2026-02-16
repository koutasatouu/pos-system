<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Management extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
    }

    public function category()
    {
        // $ci = get_instance();
        // $menu = $ci->uri->segment(1);
        // $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        // $menu_id = $queryMenu['id'];
        // $data['menu_id'] = $menu_id;
        // var_dump($data['menu_id']);
        // exit;
        $data['title'] = 'Categories';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['categories'] = $this->db->get('product_categories')->result_array();

        $this->form_validation->set_rules('name', 'Category Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('management/category', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('product_categories', ['name' => $this->input->post('name')]);
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'New category added!');
            redirect('management/category');
        }
    }

    public function category_edit()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id)->update('product_categories', ['name' => $this->input->post('name')]);
        $this->session->set_flashdata('msg_type', 'success');
        $this->session->set_flashdata('msg', 'Category updated!');
        redirect('management/category');
    }

    public function category_delete()
    {
        $id = $this->input->post('id');
        $this->db->delete('product_categories', ['id' => $id]);
        $this->session->set_flashdata('msg_type', 'success');
        $this->session->set_flashdata('msg', 'Category deleted!');
        redirect('management/category');
    }

    public function supplier()
    {
        $data['title'] = 'Suppliers';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['suppliers'] = $this->db->get('suppliers')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('management/supplier', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'description' => $this->input->post('description')
            ];
            $this->db->insert('suppliers', $data);
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'New supplier added!');
            redirect('management/supplier');
        }
    }

    public function supplier_edit()
    {
        $id = $this->input->post('id');
        $data = [
            'name' => $this->input->post('name'),
            'phone' => $this->input->post('phone'),
            'address' => $this->input->post('address'),
            'description' => $this->input->post('description')
        ];
        $this->db->where('id', $id)->update('suppliers', $data);
        $this->session->set_flashdata('msg_type', 'success');
        $this->session->set_flashdata('msg', 'Supplier updated!');
        redirect('management/supplier');
    }

    public function supplier_delete()
    {
        $this->db->delete('suppliers', ['id' => $this->input->post('id')]);
        $this->session->set_flashdata('msg_type', 'success');
        $this->session->set_flashdata('msg', 'Supplier deleted!');
        redirect('management/supplier');
    }

    public function ingredient()
    {
        $data['title'] = 'Ingredients';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['ingredients'] = $this->db->get('ingredients')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('unit', 'Unit', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('management/ingredient', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'unit' => $this->input->post('unit'),
                'min_stock' => $this->input->post('min_stock'),
                'current_stock' => 0
            ];
            $this->db->insert('ingredients', $data);
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'New ingredient added!');
            redirect('management/ingredient');
        }
    }

    public function ingredient_edit()
    {
        $id = $this->input->post('id');
        $data = [
            'name' => $this->input->post('name'),
            'unit' => $this->input->post('unit'),
            'min_stock' => $this->input->post('min_stock')
        ];
        $this->db->where('id', $id)->update('ingredients', $data);
        $this->session->set_flashdata('msg_type', 'success');
        $this->session->set_flashdata('msg', 'Ingredient updated!');
        redirect('management/ingredient');
    }

    public function ingredient_delete()
    {
        $this->db->delete('ingredients', ['id' => $this->input->post('id')]);
        $this->session->set_flashdata('msg_type', 'success');
        $this->session->set_flashdata('msg', 'Ingredient deleted!');
        redirect('management/ingredient');
    }

    public function member()
    {
        $data['title'] = 'Members';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['members'] = $this->db->get('members')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim|is_unique[members.phone]', [
            'is_unique' => 'This phone number is already registered!'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('management/member', $data);
            $this->load->view('templates/footer');
        } else {
            // Generate Member Code automatically (e.g., MEM-001)
            $last_member = $this->db->order_by('id', 'DESC')->get('members')->row_array();
            $new_id = $last_member ? $last_member['id'] + 1 : 1;
            $code = 'MEM-' . sprintf('%03d', $new_id);

            $data = [
                'code' => $code,
                'name' => $this->input->post('name'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
                'is_active' => 1
            ];
            $this->db->insert('members', $data);
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'New member added!');
            redirect('management/member');
        }
    }

    public function member_edit()
    {
        $id = $this->input->post('id');
        $data = [
            'name' => $this->input->post('name'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'is_active' => $this->input->post('is_active')
        ];
        $this->db->where('id', $id)->update('members', $data);
        $this->session->set_flashdata('msg_type', 'success');
        $this->session->set_flashdata('msg', 'Member updated!');
        redirect('management/member');
    }

    public function member_delete()
    {
        $this->db->delete('members', ['id' => $this->input->post('id')]);
        $this->session->set_flashdata('msg_type', 'success');
        $this->session->set_flashdata('msg', 'Member deleted!');
        redirect('management/member');
    }

    public function product()
    {
        $data['title'] = 'Products';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->db->select('products.*, product_categories.name as category_name');
        $this->db->from('products');
        $this->db->join('product_categories', 'product_categories.id = products.category_id');
        $data['products'] = $this->db->get()->result_array();

        $data['categories'] = $this->db->get('product_categories')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
        $this->form_validation->set_rules('category_id', 'Category', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('management/product', $data);
            $this->load->view('templates/footer');
        } else {
            $upload_image = $_FILES['image']['name'];
            $image_name = 'default.png';

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = '2048';
                $config['upload_path']   = './assets/img/product/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $image_name = $this->upload->data('file_name');
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $last_prd = $this->db->order_by('id', 'DESC')->get('products')->row_array();
            $new_id = $last_prd ? $last_prd['id'] + 1 : 1;
            $code = 'PRD-' . sprintf('%03d', $new_id);

            $data = [
                'code' => $code,
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
                'category_id' => $this->input->post('category_id'),
                'image' => $image_name,
                'is_available' => $this->input->post('is_available') ? 1 : 0
            ];

            $this->db->insert('products', $data);
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'New product added!');
            redirect('management/product');
        }
    }

    public function product_edit()
    {
        $id = $this->input->post('id');

        $data = [
            'name' => $this->input->post('name'),
            'price' => $this->input->post('price'),
            'category_id' => $this->input->post('category_id'),
            'is_available' => $this->input->post('is_available')
        ];

        $upload_image = $_FILES['image']['name'];
        if ($upload_image) {
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = '2048';
            $config['upload_path']   = './assets/img/product/';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $old_image = $this->db->get_where('products', ['id' => $id])->row_array()['image'];
                if ($old_image != 'default.png') {
                    unlink(FCPATH . 'assets/img/product/' . $old_image);
                }
                $data['image'] = $this->upload->data('file_name');
            }
        }

        $this->db->where('id', $id)->update('products', $data);
        $this->session->set_flashdata('msg_type', 'success');
        $this->session->set_flashdata('msg', 'Product updated!');
        redirect('management/product');
    }

    public function product_delete()
    {
        $id = $this->input->post('id');
        $old_image = $this->db->get_where('products', ['id' => $id])->row_array()['image'];
        if ($old_image != 'default.png') {
            unlink(FCPATH . 'assets/img/product/' . $old_image);
        }

        $this->db->delete('products', ['id' => $id]);
        $this->session->set_flashdata('msg_type', 'success');
        $this->session->set_flashdata('msg', 'Product deleted!');
        redirect('management/product');
    }
}
