<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Dashboard';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('admin/index');
        $this->load->view('templates/footer');
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('msg_type', 'success');
        $this->session->set_flashdata('msg', '&nbsp;You have been logged out!');
        redirect('');
    }
    public function role()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ((int)$this->session->userdata('role_id') === 1) {
            $data['role'] = $this->db->get('user_role')->result_array();
        } else {
            $data['role'] = $this->db->where('id !=', 1)->get('user_role')->result_array();
        }
        $data['title'] = 'POS-System Admin Dashboard';

        $this->load->library('form_validation');
        $this->form_validation->set_rules('role', 'Role', 'required|trim|is_unique[user_role.role]', [
            'required'  => '&nbsp;Role name cannot be empty!',
            'is_unique' => '&nbsp;This role already exists!'
        ]);

        if ($this->form_validation->run() === true) {
            $roleName = $this->input->post('role', true);
            $this->db->insert('user_role', ['role' => $roleName]);

            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', '&nbsp;New role added!');
            redirect('admin/role');
            return;
        } elseif ($this->input->post()) {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', validation_errors());
            redirect('admin/role');
            return;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }
    public function updaterole()
    {
        $role_id = $this->input->post('role_id');
        $role = trim($this->input->post('role'));

        if ((int)$role_id === 1) {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', '&nbsp;Role Admin cannot be edited!');
            redirect('admin/role');
            return;
        }

        if ($role === '') {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', '&nbsp;Role name cannot be empty!');
            redirect('admin/role');
            return;
        }

        $this->db->where('id', $role_id)->update('user_role', ['role' => $role]);

        $this->session->set_flashdata('msg_type', 'success');
        $this->session->set_flashdata('msg', '&nbsp;Role updated!');
        redirect('admin/role');
    }
    public function roleaccess($role_id)
    {
        if ((int)$role_id === 1 && (int)$this->session->userdata('role_id') !== 1) {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', '&nbsp;Access to this role is restricted!');
            redirect('admin/role');
            return;
        }

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['title'] = 'POS-System Admin Dashboard';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }
    public function changeaccess()
    {
        $menu_id = (int)$this->input->post('menuId');
        $role_id = (int)$this->input->post('roleId');

        if ($role_id === 1 && (int)$this->session->userdata('role_id') !== 1) {
            $this->output
                ->set_status_header(403)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status'    => 'error',
                    'message'   => 'Forbidden'
                ]));
            return;
        }

        if (!$menu_id || !$role_id) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status'    => 'error',
                    'message'   => 'Invalid input'
                ]));
            return;
        }

        $data = ['role_id' => $role_id, 'menu_id' => $menu_id];
        $exists = $this->db->get_where('user_access_menu', $data)->num_rows();

        if ($exists) {
            $this->db->delete('user_access_menu', $data);
            $message = 'Access removed';
        } else {
            $this->db->insert('user_access_menu', $data);
            $message = 'Access granted';
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'    => 'success',
                'message'   => $message
            ]));
    }
    public function deleterole()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            show_error('Method Not Allowed', 405);
            return;
        }

        $role_id = $this->input->post('role_id');

        if (!$role_id || !is_numeric($role_id)) {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', '&nbsp;Invalid role!');
            redirect('admin/role');
            return;
        }

        $role_id = (int) $role_id;

        if ($role_id === 1) {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', '&nbsp;Role Admin cannot be deleted!');
            redirect('admin/role');
            return;
        }

        $this->db->delete('user_role', ['id' => $role_id]);
        $this->db->delete('user_access_menu', ['role_id' => $role_id]);

        $this->session->set_flashdata('msg_type', 'success');
        $this->session->set_flashdata('msg', '&nbsp;Role deleted!');
        redirect('admin/role');
    }
    public function users()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'User Management';

        $this->db->select('id, name, email, image, role_id, is_active, date_created');
        $data['all_users'] = $this->db->get('user')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('admin/users', $data);
        $this->load->view('templates/footer');
    }
    public function edituser()
    {
        if ($this->input->method() != 'post') {
            redirect('admin/users');
        }

        $id = $this->input->post('id');

        $current_user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        if ($id == $current_user['id']) {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', '&nbsp;You cannot change your own role or status!');
            redirect('admin/users');
            return;
        }

        $data = [
            'role_id' => $this->input->post('role_id'),
            'is_active' => $this->input->post('is_active')
        ];

        $this->db->where('id', $id);
        $this->db->update('user', $data);

        $this->session->set_flashdata('msg_type', 'success');
        $this->session->set_flashdata('msg', '&nbsp;User updated successfully!');
        redirect('admin/users');
    }

    public function deleteuser()
    {
        if ($this->input->method() != 'post') {
            redirect('admin/users');
        }

        $id = $this->input->post('id');

        $current_user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($id == $current_user['id']) {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', '&nbsp;You cannot delete yourself!');
            redirect('admin/users');
            return;
        }
        $this->db->delete('user', ['id' => $id]);

        $this->session->set_flashdata('msg_type', 'success');
        $this->session->set_flashdata('msg', '&nbsp;User deleted successfully!');
        redirect('admin/users');
    }
}
