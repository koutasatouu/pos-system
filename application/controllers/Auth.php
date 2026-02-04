<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $data['title'] = 'POS-System User Login';
        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/login');
        $this->load->view('templates/auth_footer');
    }
    public function masking()
    {
        $this->_login();
    }
    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            if ($user['is_active'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    $this->session->set_flashdata('msg_type', 'success');
                    $this->session->set_flashdata('msg', '&nbsp;Login success!');
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('msg_type', 'error');
                    $this->session->set_flashdata('msg', '&nbsp;Wrong password!');
                    redirect('');
                }
            } else {
                $this->session->set_flashdata('msg_type', 'warning');
                $this->session->set_flashdata('msg', '&nbsp;This email has not been activated!');
                redirect('');
            }
        } else {
            $this->session->set_flashdata('msg_type', 'warning');
            $this->session->set_flashdata('msg', '&nbsp;Email is not registered!');
            redirect('');
        }
    }
    public function registration()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|matches[confirm_password]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required|trim|matches[password]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'POS-System User Registration';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 1,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Congratulations! Your account has been created. Please login.');
            redirect('');
        }
    }
    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
}
