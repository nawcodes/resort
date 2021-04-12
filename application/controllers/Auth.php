<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends Hotel_Controller
{

    protected $is_login;

    public function __construct()
    {
        parent::__construct();
        $this->is_login  = $this->session->userdata('is_login');
        if ($this->is_login == true) {
            redirect(base_url('admin/dashboard'));
        }
    }

    public function index()
    {

        if (!$_POST) {
            $data['input'] = (object) ['email'  => ''];
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'E-mail', 'valid_email|trim|required');
        $this->form_validation->set_rules('password', 'password', 'required');

        if (!$this->form_validation->run()) {
            $data['title']  = 'Login Page';
            $data['page']   = 'pages/admin/login';
            $this->load->view('pages/admin/login', $data);
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $email      = $this->input->post('email', true);
        $password   = $this->input->post('password', true);
        $user       = $this->db->get_where('user', ['email' => $email])->row();

        if ($user) {
            if ($user->is_active == 1) {
                if ($password == password_verify($password, $user->password)) {
                    $sess_data = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'image' => $user->image,
                        'email' => $user->email,
                        'id_role' => $user->id_role,
                        'is_login' => true,
                    ];

                    $this->session->set_userdata($sess_data);
                    redirect(base_url('admin/dashboard'));
                } else {
                    $this->session->set_flashdata('error', 'Password Salah');
                    redirect(base_url('auth'));
                }
            } else {
                $this->session->set_flashdata('error', 'Akun tidak aktif');
                redirect(base_url('auth'));
            }
        } else {
            $this->session->set_flashdata('error', 'Akun tidak terdaftar');
            redirect(base_url('auth'));
        }
    }
}

/* End of file Login.php */
