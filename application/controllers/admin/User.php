<?php


defined('BASEPATH') or exit('No direct script access allowed');

class User extends Hotel_Controller
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

        $data['content'] = $this->user->select(
            [
                'user.id',
                'user.name',
                'user.email',
                'user.image',
                'user.id_role',
                'role.role as role'
            ]
        )->join('role')->get();

        $data['title']  = 'All User';
        $data['admin']  = 'pages/admin/user';
        $this->view_admin($data);
    }


    public function create()
    {
        if (!$_POST) {
            $data['input'] = (object) $this->user->setDefaultValues();
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }

        if (!empty($_FILES) && $_FILES['image']['name'] !== '') {
            // make custom name
            $imageName = url_title($data['input']->name, '-', true) . '-user-' . $_FILES['image']['name'];

            $image = $this->user->uploadImage('image', $imageName);

            if ($image) {
                $data['input']->image = $image['file_name'];
            } else {
                $this->session->set_flashdata('warning', 'photo di butuhkan.');
                redirect(base_url('admin/user/create'));
            }
        }

        $data['role'] = $this->db->select('*')->from('role')->get()->result();


        if (!$this->user->validate()) {
            $data['form']   = base_url('admin/user/create');
            $data['title']  = 'Tambah user';
            $data['admin']  = 'pages/admin/user-form';
            $this->view_admin($data);
            return;
        }



        $insert = [
            'name'          => $data['input']->name,
            'email'         => $data['input']->email,
            'password'      => password_hash($data['input']->password, PASSWORD_DEFAULT),
            'id_role'       => $data['input']->id_role,
            'is_active'     => $data['input']->is_active,
            'image'         => $data['input']->image ? $data['input']->image : '',
        ];


        if ($this->id_role == 1) {
            if ($this->user->insert($insert)) {
                $this->session->set_flashdata('success', 'Pengguna telah di buat.');
            } else {
                $this->session->set_flashdata('error', 'Terjadi suatu kesalaahan!');
            }
        } else {
            $this->session->set_flashdata('error', 'Hanya atasan yang bisa melakukan aksi ini!');
        }

        redirect(base_url('admin/user'));
    }


    public function edit($id)
    {
        if ($this->id != $id && $this->id_role != 1) {
            $this->session->set_flashdata('warning', 'Akses di tolak');
            redirect(base_url('admin/user'));
        }




        $data['content'] = $this->user->where('id', $id)->first();

        if (!$data['content']) {
            $this->session->set_flashdata('warning', 'User tidak di temukan.');
            redirect(base_url('admin/user'));
        }

        $data['role'] = $this->db->select('*')->from('role')->get()->result();

        if (!$_POST) {
            $data['input'] = (object) $data['content'];
        } else {
            $data['input'] = (object) $this->input->post(null, true);
            if ($data['input']->password == '') {
                $data['input']->password = $data['content']->password;
            } else {
                $data['input']->password = password_hash($data['input']->password, PASSWORD_DEFAULT);
            }
        }


        if (!empty($_FILES) && $_FILES['image']['name'] !== '') {
            // make custom name
            $imageName = url_title($data['input']->name, '-', true) . '-user-' . $_FILES['image']['name'];

            $image = $this->user->uploadImage('image', $imageName);

            if ($image) {
                $data['input']->image = $image['file_name'];
            } else {
                $this->session->set_flashdata('warning', 'photo di butuhkan.');
                redirect(base_url('admin/user'));
            }
        }




        if (!$this->user->validate()) {
            $data['form']   = base_url('admin/user/edit/' . $id);
            $data['title']  = 'Tambah user';
            $data['admin']  = 'pages/admin/user-form';
            $this->view_admin($data);
            return;
        }

        if ($this->id_role != $data['input']->id_role || $this->id_role == $data['input']->id_role) {
            if ($this->id_role == 1) {
                if ($this->user->where('id', $data['input']->id)->update($data['input'])) {
                    $this->session->set_flashdata('success', 'User diperbaharui');
                    redirect(base_url('admin/user'));
                } else {
                    $this->session->set_flashdata('success', 'User diperbaharui');
                    redirect(base_url('admin/user'));
                }
            } else {
                $this->session->set_flashdata('warning', 'hanya atasan yang bisa mengubah role');
                redirect(base_url('admin/user'));
            }
        }
    }


    public function delete($id)
    {
        $user = $this->user->where('id', $id)->first();

        if (!$user) {
            $this->session->set_flashdata('warning', 'User tidak di temukan!');
            redirect(base_url('admin/user'));
        }

        if (!$_POST) {
            redirect(base_url('admin/user'));
        }

        if ($this->id_role == 1) {
            if ($this->user->where('id', $this->input->post('id', true))->delete()) {
                $this->session->set_flashdata('success', 'Berhasil menghapus user');
            } else {
                $this->session->set_flashdata('warning', 'Terjadi suatu kesalahan!');
            }
        } else {
            $this->session->set_flashdata('warning', 'Aksi tidak di perbolehkan!');
        }


        redirect(base_url('admin/user'));
    }


    public function unique_email()
    {

        $email  = $this->input->post('email', true);
        $id     = $this->input->post('id', true);

        $user = $this->user->where('email', $email)->first();

        if ($user) {
            if ($id == $user->id) {
                return true;
            }
            $this->load->library('form_validation');
            $this->form_validation->set_message('unique_email', '%s sudah terdaftar.');
            return false;
        }
        return true;
    }
}

/* End of file User.php */
