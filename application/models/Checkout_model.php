<?php



defined('BASEPATH') or exit('No direct script access allowed');

class Checkout_model extends Hotel_Model
{

    public $table = 'booking_orders';


    public function setDefaultValues()
    {
        return [
            'account_number'    => '',
            'account_name'      => '',
            'nominal'           => '',
            'from_bank'         => ''
        ];
    }


    public function setRules()
    {
        $rules = [
            [
                'label' => 'Nama akun Rekening',
                'field' => 'account_name',
                'rules' => 'required|trim',
            ],
            [
                'label' => 'Nama akun Rekening',
                'field' => 'account_number',
                'rules' => 'required|numeric',
            ],
            [
                'label' => 'Nominal Pembayaran',
                'field' => 'nominal',
                'rules' => 'required|numeric',
            ],
            [
                'label' => 'Pengirim Bank Asal',
                'field' => 'from_bank',
                'rules' => 'required',
            ]

        ];

        return $rules;
    }


    public function uploadImage($field, $imageName)
    {
        $config = [
            'upload_path'        => './assets/images/payment/',
            'allowed_types'      => 'gif|jpg|png|JPG|jpeg|JPEG',
            'max_size'           => 2048,
            'max_width'          => 0,
            'max_height'         => 0,
            'file_name'          => $imageName,
            'overwrite'          => true,
            'file_ext_tolower'   => true
        ];

        $this->load->library('upload', $config);

        if ($this->upload->do_upload($field)) {
            return $this->upload->data();
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            return false;
        }
    }
}

/* End of file Checkout.php */
