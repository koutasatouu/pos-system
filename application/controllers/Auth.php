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
        if ($this->session->userdata('email')) {
            redirect('user');
        }
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
                    if (!empty($this->input->post('remember'))) {
                        setcookie("loginId", $email, time() + (10 * 365 * 24 * 60 * 60));
                        setcookie("loginPass", $password, time() + (10 * 365 * 24 * 60 * 60));
                    } else {
                        setcookie("loginId", "");
                        setcookie("loginPass", "");
                    }
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
    public function terms()
    {
        $data['title'] = 'Terms and Conditions';
        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/terms');
        $this->load->view('templates/auth_footer');
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
            $email = $this->input->post('email', true);
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'date_created' => time()
            ];
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];
            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);
            $this->_sendEmail($token, 'verify');
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Congratulations! Your account has been created. Please activate your account.');
            redirect('');
        }
    }
    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('msg_type', 'success');
                    $this->session->set_flashdata('msg', '&nbsp;' . $email . ' has been activated! Please login.');
                    redirect('');
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('msg_type', 'error');
                    $this->session->set_flashdata('msg', '&nbsp;Account activation failed! Token expired.');
                    redirect('');
                }
            } else {
                $this->session->set_flashdata('msg_type', 'error');
                $this->session->set_flashdata('msg', '&nbsp;Account activation failed! Wrong token.');
                redirect('');
            }
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', '&nbsp;Account activation failed! Wrong email.');
            redirect('');
        }
    }
    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'akuabib25@gmail.com',
            'smtp_pass' => 'tquragzopkbiywql',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->from('akuabib25@gmail.com', 'POS-System');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $email = $this->input->post('email');
            $link = base_url() . 'auth/verify?email=' . $email . '&token=' . urlencode($token);

            $this->email->subject('Activate Your Account - POS System');

            $message = '
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body { font-family: "Source Sans Pro", Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 0; }
                    .wrapper { padding: 20px; }
                    .container { max-width: 500px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-top: 5px solid #007bff; }
                    .header { text-align: center; margin-bottom: 20px; }
                    .header h2 { color: #333; margin: 0; }
                    .content { color: #555; line-height: 1.6; text-align: center; }
                    .btn { display: inline-block; background-color: #007bff; color: #ffffff !important; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 20px; margin-bottom: 20px; }
                    .btn:hover { background-color: #0056b3; }
                    .footer { text-align: center; font-size: 12px; color: #999; margin-top: 20px; }
                    .link-text { font-size: 12px; color: #999; word-break: break-all; margin-top: 10px; }
                </style>
            </head>
            <body>
                <div class="wrapper">
                    <div class="container">
                        <div class="header">
                            <h2>POS System</h2>
                        </div>
                        <div class="content">
                            <h3>Welcome Aboard!</h3>
                            <p>Thank you for registering. To get started, please confirm your email address by clicking the button below.</p>
                            
                            <a href="' . $link . '" class="btn">Verify My Account</a>
                            
                            <p>If the button works, you can ignore this email.</p>
                            
                            <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
                            
                            <p class="link-text">If the button doesn\'t work, copy and paste this link into your browser:<br>
                            ' . $link . '</p>
                        </div>
                    </div>
                    <div class="footer">
                        &copy; ' . date('Y') . ' POS-System. All rights reserved.
                    </div>
                </div>
            </body>
            </html>';

            $this->email->message($message);
        }

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }
    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
}
