<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Menu Management';

        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['submenu'] = $this->db->get('user_sub_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            if (validation_errors()) {
                $this->session->set_flashdata('msg_type', 'error');
                $this->session->set_flashdata('msg', '&nbsp;Please fill all required fields!');
                redirect('menu');
            }
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', '&nbsp;New menu added!');
            redirect('menu');
        }
    }

    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            show_error('Method Not Allowed', 405);
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('menu', 'Menu', 'required|trim');

        $id = $this->input->post('id');
        if (!$id || !is_numeric($id)) {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', '&nbsp;Invalid menu!');
            redirect('menu');
            return;
        }
        $id = (int) $id;

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', validation_errors() ?: '&nbsp;Please fill all required fields!');
            redirect('menu');
            return;
        }

        $menuName = $this->input->post('menu', true);
        $exists = $this->db->where('menu', $menuName)->where('id !=', $id)->get('user_menu')->num_rows();
        if ($exists) {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', '&nbsp;This menu already exists!');
            redirect('menu');
            return;
        }

        $this->db->where('id', $id)->update('user_menu', ['menu' => $menuName]);

        $this->session->set_flashdata('msg_type', 'success');
        $this->session->set_flashdata('msg', '&nbsp;Menu updated!');
        redirect('menu');
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            show_error('Method Not Allowed', 405);
            return;
        }

        $id = $this->input->post('id');

        if (!$id || !is_numeric($id)) {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', '&nbsp;Invalid menu!');
            redirect('menu');
            return;
        }

        $id = (int) $id;

        $this->db->trans_start();
        $this->db->delete('user_sub_menu', ['menu_id' => $id]);
        $this->db->delete('user_access_menu', ['menu_id' => $id]);
        $this->db->delete('user_menu', ['id' => $id]);
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', '&nbsp;Failed to delete menu!');
        } else {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', '&nbsp;Menu deleted!');
        }

        redirect('menu');
    }

    public function submenu()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Submenu Management';
        $this->load->model('Menu_model', 'menu');

        $data['submenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if ($this->form_validation->run() == false) {
            // FIX: Only set flashdata and redirect if there was an actual failed attempt
            if (validation_errors()) {
                $this->session->set_flashdata('msg_type', 'error');
                $this->session->set_flashdata('msg', '&nbsp;Please fill all required fields!');
                redirect('menu/submenu');
            }

            // Normal Page Load
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $is_active = $this->input->post('is_active') ? 1 : 0;
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $is_active
            ];
            $this->db->insert('user_sub_menu', $data);

            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', '&nbsp;New submenu added!');
            redirect('menu/submenu');
        }
    }

    public function editsubmenu()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            show_error('Method Not Allowed', 405);
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required|integer');
        $this->form_validation->set_rules('url', 'URL', 'required|trim');
        $this->form_validation->set_rules('icon', 'Icon', 'required|trim');

        $id = $this->input->post('id');
        if (!$id || !is_numeric($id)) {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', '&nbsp;Invalid submenu!');
            redirect('menu/submenu');
            return;
        }
        $id = (int) $id;

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', validation_errors() ?: '&nbsp;Please fill all required fields!');
            redirect('menu/submenu');
            return;
        }

        $data = [
            'title' => $this->input->post('title', true),
            'menu_id' => (int) $this->input->post('menu_id'),
            'url' => $this->input->post('url', true),
            'icon' => $this->input->post('icon', true),
            'is_active' => $this->input->post('is_active') ? 1 : 0
        ];

        $this->db->where('id', $id)->update('user_sub_menu', $data);

        $this->session->set_flashdata('msg_type', 'success');
        $this->session->set_flashdata('msg', '&nbsp;Submenu updated!');
        redirect('menu/submenu');
    }

    public function deletesubmenu()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            show_error('Method Not Allowed', 405);
            return;
        }

        $id = $this->input->post('id');

        if (!$id || !is_numeric($id)) {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', '&nbsp;Invalid submenu!');
            redirect('menu/submenu');
            return;
        }

        $id = (int) $id;

        $this->db->delete('user_sub_menu', ['id' => $id]);

        $this->session->set_flashdata('msg_type', 'success');
        $this->session->set_flashdata('msg', '&nbsp;Submenu deleted!');
        redirect('menu/submenu');
    }
}
