<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Keys extends Hotel_Controller
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
        // master key join re_key
        $data['content'] = $this->keys->select([
            'master_key.id',
            'master_key.name',
            'master_key.author',
            'master_key.id_rooms_key',

            'registered_key.date_registered',
        ])->join('registered_key')
            ->where('registered_key.role_key', 'master')
            ->where('author', $this->email)
            ->get();



        $data['title'] = 'Kunci Master';
        $data['admin'] = 'pages/admin/keys';
        $this->view_admin($data);
    }



    public function create()
    {
        if (!$_POST) {
            // set defautl values
            $input = (object) ['name' => ''];
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->keys->validate()) {
            $this->index();
            return;
        }

        if ($this->keys->create($input)) {
            $this->session->set_flashdata('success', 'Kunci Master telah di buat.');
        } else {
            $this->session->set_flashdata('warning', 'Terjadi suatu kesalahan!');
        }


        redirect(base_url('admin/keys'));
    }

    public function edit($id)
    {
        $data['content'] = $this->keys->select([
            'master_key.id as id_maskey',
            'master_key.name',
            'master_key.author',

            'registered_key.id as id_rekey',
            'registered_key.date_registered',
        ])->join('registered_key')
            ->where('registered_key.role_key', 'master')
            ->where('master_key.id', $id)
            ->first();

        if (!$data['content']) {
            $this->session->set_flashdata('warning', 'Master Key tidak ditemukan');
            redirect(base_url('admin/keys'));
        }

        if (!$_POST) {
            $data['input'] = (object) [
                'id_maskey' => $data['content']->id_maskey,
                'name'      => $data['content']->name,
                'id_rekey'  => $data['content']->id_rekey,
            ];
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }

        if (!$this->keys->validate()) {
            $data['title'] = 'Edit Kunci Master';
            $data['admin'] = 'pages/admin/keys-form';
            $this->view_admin($data);
            return;
        }

        if ($this->keys->edit($data['input'])) {
            $this->session->set_flashdata('success', 'Berhasil Diperbaharui');
        } else {
            $this->session->set_flashdata('warning', 'Terjadi suatu kesalahan!');
        }


        redirect(base_url('admin/keys'));
    }

    public function detail($id)
    {

        // qrcodes
        $this->keys->table = 'rooms_key';
        $data['content'] = $this->keys->select('qrcode_key')->where('rooms_key.id', $id)->first();

        if (!$data['content']) {
            $this->session->set_flashdata('warning', 'Kunci master tidak di temukan.');
            redirect(base_url('admin/keys'));
        }

        $data['title']  = 'Qr-codes Kunci Master';
        $data['admin']  = 'pages/admin/keys-detail';
        $this->view_admin($data);
    }

    public function delete()
    {
        if (!$_POST) {

            redirect(base_url('admin/keys'));
        } else {
            $input = (object) $this->input->post(null, true);

            if ($this->keys->erase($input)) {
                $this->session->set_flashdata('success', 'berhasil dihapus!');
            } else {
                $this->session->set_flashdata('warning', 'Terjadi suatu kesalahan!');
            }

            redirect(base_url('admin/keys'), 'refresh');
        }
    }


    public function send()
    {
        $id =  $this->input->post('id', true);


        $this->keys->table = 'master_key';
        $data['master'] = $this->keys->select([
            'master_key.name',
            'rooms_key.qrcode_key',
        ])->join('rooms_key')->where('master_key.id', $id)->first();

        $this->sendEmails($data, $this->email, 'Kunci Master', $this->email, 'masterkeys', 'admin/keys');
    }
}

/* End of file Keys.php */
