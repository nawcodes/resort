<?php




defined('BASEPATH') or exit('No direct script access allowed');

class Checkout extends Hotel_Controller
{

    private $id;
    private $account_id;

    public function __construct()
    {
        parent::__construct();
        $this->id = $this->session->userdata('id');
        $this->account_id = $this->session->userdata('user');
    }


    public function index($id)
    {
    }


    public function confirm($id)
    {
        $this->checkout->table = 'booking_orders';
        $data['bo_orders'] = $this->checkout->where('id', $id)->first();



        if (!$data['bo_orders']) {
            $this->session->set_flashdata('warning', 'maaf no invoice tidak ditemukan');
            redirect(base_url('booking'));
        }

        $this->checkout->table = 'booking_confirm';

        $data['bo_confirm'] = $this->checkout->where('id_booking_orders', $id)->first();


        $this->checkout->table      = 'costumers_key';
        $data['costumers_key']      = $this->checkout->where('id_costumers', $data['bo_orders']->id_costumers)->where('id_booking_orders', $data['bo_orders']->id)->first();


        if (!$_POST) {
            $data['input'] = (object) $this->checkout->setDefaultvalues();
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }


        if (!empty($_FILES) && $_FILES['image']['name'] !== '') {
            $imageName = url_title($data['bo_orders']->invoice, '-', true) .  '-payment';
            $uploadUser = $this->checkout->uploadImage('image', $imageName);

            if ($uploadUser) {
                $data['input']->image = $uploadUser['file_name'];
            } else {
                redirect(base_url('checkout/confirm/' . $id));
            }
        }




        if (!$this->checkout->validate()) {
            $data['title'] = 'Konfirmasi Pembayaran';
            $data['page'] = 'pages/checkout/index';
            $this->view($data);
            return;
        }

        $change = $data['input']->nominal - $data['bo_orders']->amount;




        if ($change < 0) {
            $this->session->set_flashdata('warning', 'Nominal pembayaran harus minimal atau lebih dari nominal');
        }




        $confirm = [
            'id_booking_orders' => $id,
            'account_name'      => $data['input']->account_name,
            'account_number'    => $data['input']->account_number,
            'from_bank'         => $data['input']->from_bank,
            'nominal'           => $data['input']->nominal,
            'change'            => $change,
            'image'             => $data['input']->image
        ];



        $this->checkout->table = 'booking_confirm';
        if ($this->checkout->insert($confirm)) {
            $this->checkout->table = 'booking_orders';
            $this->checkout->where('id', $data['bo_orders']->id)->where('invoice', $data['bo_orders']->invoice)->update(['status' => 'unconfirmed']);
            $this->session->set_flashdata('success', 'Konfirmasi Pembayaran Berhasil Di kirim , Di tunggu ya.. ');
        } else {
            $this->session->set_flashdata('danger', 'Terjadi suatu kesalahan!');
        }


        redirect(base_url('checkout/confirm/' . $id));
    }
}

/* End of file Checkout.php */
