<?php




defined('BASEPATH') or exit('No direct script access allowed');

class Verify extends Hotel_Controller
{

    public $email;
    public $is_login;
    public $id;
    public $id_role;


    public function __construct()
    {
        parent::__construct();
        $this->email = $this->session->userdata('email');
        $this->is_login  = $this->session->userdata('is_login');
        $this->id    = $this->session->userdata('id');
        $this->id_role = $this->session->userdata('id_role');

        if (!$this->email || $this->is_login == false || !$this->id || !$this->id_role) {
            $this->session->set_flashdata('warning', 'Login terlebih dahulu.');
            redirect(base_url('auth'));
        }
    }


    public function index()
    {
        $query  = "SELECT * FROM costumers WHERE is_approved != 'verified'";
        $data['content'] = $this->db->query($query)->result();
        $data['title'] = 'Verifikasi Costumers';
        $data['admin'] = 'pages/admin/costumers-submission';
        $this->view_admin($data);
    }
}

/* End of file Verify.php */
