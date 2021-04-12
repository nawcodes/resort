<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends CI_Controller
{

    public function index()
    {

        $this->session->unset_userdata('id');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('is_login');

        session_destroy();

        redirect(base_url('auth'));
    }
}

/* End of file Logout.php */
