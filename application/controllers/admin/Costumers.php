<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Costumers extends Hotel_Controller
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

        $data['costumers'] = $this->costumers->where('is_approved', 'verified')->get();
        $data['title']  = 'Costumers';
        $data['admin']  =  'pages/admin/costumers';
        $this->view_admin($data);
    }

    public function create()
    {
        if (!$_POST) {
            $data['input'] = (object) $this->costumers->setDefaultValues();
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }


        if (!$this->costumers->validate()) {
            $this->index();
            return;
        }

        $insert = [
            'name'          => $data['input']->name,
            'email'         => $data['input']->email,
            'account_id'    => $data['input']->account_id,
            'phone'         => $data['input']->phone,
            'address'       => $data['input']->address,
            'is_healthy'    => $data['input']->is_healthy,
            'is_approved'   => '',
        ];


        if ($costumers = $this->costumers->insert($insert)) {
            $this->session->set_flashdata('success', 'Costumer telah ditambahkan , Lengkapi data selanjutnya. Foto dan Verifikasi');
            redirect(base_url('admin/costumers/edit/' . $costumers));
        } else {
            $this->session->set_flashdata('error', 'Terjadi suatu kesalahan!');
            $this->index();
        }
    }


    public function edit($id)
    {

        $data['costumers'] = $this->costumers->where('id', $id)->first();

        if (!$data['costumers']) {
            $this->session->set_flashdata('warning', 'Kostumer tidak di temukan.');
            redirect(base_url('admin/costumers'));
        }
        // for get history booking
        $data['bo_orders'] = $this->db->select(
            [
                'booking_orders.invoice',
                'booking_orders.date_created as datePaid',
                'booking_orders.status',
                'booking_orders.amount'
            ]
        )
            ->from('booking_orders')
            ->where(['status' => 'paid'])
            ->where(['id_costumers' => $data['costumers']->id])
            ->get()
            ->result();

        if (!$_POST) {
            $data['input'] = $data['costumers'];
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }


        // image upload 
        $config = [
            'upload_path'           => './assets/images/account/',
            'allowed_types'         => 'jpg|jpeg|png',
            'max_size'              => 2048,
            'max_width'             => 0,
            'max_height'            => 0,
            'file_ext_tolower'      => true,
            'overwrite'             => true,
        ];

        $this->load->library('upload', $config);

        // first image
        if (!empty($_FILES['account_image']['name'])) {
            // make custom name
            $account_imageName = url_title($data['costumers']->account_id, '-', true) . '-' . $_FILES['account_image']['name'];
            $config['file_name'] = $account_imageName;
            $this->upload->initialize($config);
            // check when upload is not eligible
            if ($this->upload->do_upload('account_image')) {
                //return upload
                $account_image = $this->upload->data();
            } else {
                //return upload message error
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            };

            if ($account_image) {
                // delete if ready image
                if ($data['costumers']->account_image !== '') {
                    deleteImage($data['costumers']->account_image, 'account');
                }
                // upload image
                $data['input']->account_image =  $account_image['file_name'];
            }
        } else {
            // upload default image
            $data['input']->account_image = $data['costumers']->account_image;
        }





        if (!empty($_FILES) && $_FILES['account_image_user']['name'] !== null && $_FILES['account_image_user']['name'] !== '') {
            $account_image_userName = url_title($data['costumers']->account_id, '-', true) . '-' . $_FILES['account_image_user']['name'];
            $config['file_name'] = $account_image_userName;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('account_image_user')) {
                $account_image_user = $this->upload->data();
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            }
            if ($account_image_user) {
                if ($data['costumers']->account_image_user !== '') {
                    deleteImage($data['costumers']->account_image_user, 'account');
                }
                $data['input']->account_image_user =  $account_image_user['file_name'];
            }
        } else {
            $data['input']->account_image_user = $data['costumers']->account_image_user;
        }




        // end image upload

        if (!$this->costumers->validate()) {
            $data['title']  = 'Edit Costumers';
            $data['admin']  = 'pages/admin/costumers-form';
            $this->view_admin($data);
            return;
        }


        $update = [
            'name'                  => $data['input']->name,
            'email'                 => $data['input']->email,
            'phone'                 => $data['input']->phone,
            'account_id'            => $data['input']->account_id,
            'address'               => $data['input']->address,
            'is_approved'           => $data['input']->is_approved,
            'account_image'         => $data['input']->account_image,
            'account_image_user'    => $data['input']->account_image_user,
        ];



        if ($this->costumers->where('id', $id)->update($update)) {
            $this->session->set_flashdata('success', 'Berhasil di perbarui');
        } else {
            $this->session->set_flashdata('error', 'Terjadi suatu kesalahan!');
        }


        redirect(base_url('admin/costumers/edit/' . $id));
    }

    public function delete($id)
    {
        if (!$_POST) {
            redirect(base_url('admin/costumers'));
        } else {
            $input = (object) $this->input->post(null, true);

            $costumers = $this->costumers->where('id', $id)->first();

            if (!$costumers) {
                $this->session->set_flashdata('warning', 'Costumers tidak di temukan.');

                redirect(base_url('admin/costumers'));
            }




            if ($this->costumers->erase($input)) {
                $this->session->set_flashdata('success', 'Berhasil dihapus');
            } else {
                $this->session->set_flashdata('warning', 'Terjadi suatu kesalahan!');
            }

            redirect(base_url('admin/costumers'));
        }
    }
}

/* End of file Costumers.php */
