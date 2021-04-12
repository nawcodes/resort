<?php



defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends Hotel_Controller
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



    // index
    public function index()
    {

        $data['bo_orders'] = $this->orders->select(
            [
                'booking_orders.invoice',
                'booking_orders.date_created',
                'booking_orders.amount',
                'booking_orders.status',

                'costumers.id',
                'costumers.name',
                'costumers.email',
                'costumers.phone',
                'costumers.account_id'

            ]
        )
            ->join('costumers')
            ->get();





        $data['title'] = 'Booking Orders';
        $data['admin'] = 'pages/admin/orders';
        $this->view_admin($data);
    }

    // detail views x btn confirm x btn ubah
    public function orders_detail($inv = null)
    {


        $this->orders->table = 'booking_orders_detail';

        $data['bo_orders'] = $this->orders->select(
            [
                'booking_orders_detail.id_booking_orders',
                'booking_orders_detail.id_type_rooms',
                'booking_orders_detail.id_extra',
                'booking_orders_detail.date_from',
                'booking_orders_detail.date_to',
                'booking_orders_detail.subtotal',
                'booking_orders_detail.rooms',
                'booking_orders_detail.person',
                'booking_orders_detail.adult',
                'booking_orders_detail.child',
                'booking_orders_detail.age_child',


                'booking_orders.id',
                'booking_orders.invoice',
                'booking_orders.id_costumers',
                'booking_orders.status',
                'booking_orders.date_created as dateBooking',

                'type_rooms.id as classId',
                'type_rooms.name as classRoom',
                'type_rooms.price_pernight',
                'type_rooms.max_person',
                'type_rooms.twin_bed',

                'extra.id as extraId',
                'extra.name',
                'extra.price'

            ]
        )
            ->join('booking_orders')
            ->join('type_rooms')
            ->join('extra')
            ->where('booking_orders.invoice', $inv)
            ->first();


        if (!$data['bo_orders']->invoice) :
            $this->session->set_flashdata('warning', 'Invoice tidak di temukan!');

            redirect(base_url('admin/orders'));

        endif;
        // overide for costumers key
        // $this->orders->table   = 'costumers_key';

        // costumers key x rooms_key x registered_key

        $data['costumer_key'] = $this->db->select([

            'costumers_key.id',

            'registered_key.date_from',
            'registered_key.date_to',
            'registered_key.id_rooms',
            'registered_key.date_registered',

            'rooms.id as id_rooms',
            'rooms.number_rooms',

            'rooms_key.id as id_key',
            'rooms_key.qrcode_key',
            'rooms_key.time_expired',
            'rooms_key.is_active',

            'type_rooms.name as className'
        ])->from('costumers_key')
            ->join('registered_key', 'costumers_key.id_registered_key = registered_key.id')
            ->join('rooms_key', 'costumers_key.id_rooms_key = rooms_key.id')
            ->join('type_rooms', 'registered_key.id_type_rooms = type_rooms.id')
            ->join('rooms', 'registered_key.id_rooms = rooms.id')
            ->where('costumers_key.id_costumers',  $data['bo_orders']->id_costumers)
            ->where('costumers_key.id_booking_orders', $data['bo_orders']->id)
            ->get()
            ->result();

        // $data['costumer_key']     = $this->orders->select([
        //     'costumers_key.id',

        //     'rooms_key.qrcode_key',
        //     'rooms_key.time_expired',
        //     'rooms_key.is_active',

        //     'registered_key.date_from',
        //     'registered_key.date_to',
        //     'registered_key.id_rooms',
        //     'registered_key.date_registered',

        // ])->join('rooms_key')
        //     ->join('registered_key')
        //     ->where('costumers_key.id_costumers', $data['bo_orders']->id_costumers)
        //     ->where('costumers_key.id_booking_orders', $data['bo_orders']->id)
        //     ->first();

        // overide for get rooms_number
        // $data['rooms'] = $this->db->select(['id', 'number_rooms'])->from('rooms')->where('id', $data['costumer_key']->id_rooms)->get()->row();



        $this->orders->table = 'costumers';
        $data['costumers'] = $this->orders->where('id', $data['bo_orders']->id_costumers)->first();



        $this->orders->table = 'booking_confirm';


        // 1 jika sudah melakukan booking confirm
        $data['bo_confirm'] = $this->orders->where('id_booking_orders', $data['bo_orders']->id_booking_orders)->first();
        // end 1

        $data['title'] = "Booking Orders Detail";
        $data['admin'] = 'pages/admin/orders-detail';
        $this->view_admin($data);
    }


    // fn konfirmasi status
    public function confirm()
    {
        if (!$_POST) {

            redirect(base_url('admin/orders/'));
            $this->session->set_flashdata('warning', 'Terjadi Suatu kesalahan!');
        } else {
            $input = (object)  $this->input->post(null, true);

            if ($input->confirm == 'paid') {

                if ($input->rooms_number != '') {

                    $this->orders->create($input);
                } else {
                    $this->session->set_flashdata('warning', 'berikan nomor kamar terlebih dahulu');
                    redirect(base_url('admin/orders'));
                }

                redirect(base_url('admin/orders'));
            } else {
                if ($this->orders->where('id', $input->id_booking_orders)->update(['status' => $input->confirm])) {
                    $this->session->set_flashdata('success', 'Berhasil di konfirmasi');
                    redirect(base_url('admin/orders'));
                } else {
                    $this->session->set_flashdata('warning', 'Terjadi suatu kesalahan!');
                    redirect(base_url('admin/orders'));
                }
            }
        }
    }

    // edit qr_codes
    public function edit($id)
    {


        $this->orders->table = 'costumers_key';

        $data['content']     = $this->orders->select([
            'costumers_key.id',
            'costumers_key.id_costumers',

            'rooms_key.qrcode_key',
            'rooms_key.time_expired',
            'rooms_key.is_active',

            'registered_key.date_from',
            'registered_key.id as id_re_key',
            'registered_key.date_to',
            'registered_key.id_rooms',
            'registered_key.id_type_rooms as typeId',
            'registered_key.date_registered',

        ])->join('rooms_key')
            ->join('registered_key')
            ->where('costumers_key.id', $id)
            ->first();

        $this->orders->table = 'type_rooms';


        $data['type_rooms'] = $this->orders->select('name')->where('id',  $data['content']->typeId)->first();

        // overide for get number_rooms 
        $data['rooms'] = $this->db->select(['id', 'number_rooms'])->from('rooms')->where('id', $data['content']->id_rooms)->get()->row();

        $data['inv'] = $this->db->select('invoice')->from('booking_orders')->where('id_costumers', $data['content']->id_costumers)->get()->row();


        if (!$data['content'] && !$data['type_rooms'] && !$data['inv']) {
            $this->session->set_flashdata('warning', 'Maaf kunci ruangan tidak di temukan!');
            redirect(base_url('admin/orders'));
        }

        if (!$_POST) {
            $data['input'] = (object) [
                'rooms_number'  => $data['rooms']->id,
                'is_active'     => $data['content']->is_active,
            ];
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('id_key', 'Terjadi suatu kesalahan, Refresh Halaman ini.', 'required|numeric');
        $this->form_validation->set_rules('rooms_number', 'Pilih No Ruangan!', 'required|numeric');
        if (!$this->form_validation->run()) {
            $data['title']  = 'Edit Kunci Ruangan';
            $data['admin']  = 'pages/admin/orders-form';
            $this->view_admin($data);
            return;
        }



        $update = (object) [
            // get id for update status old number => 0
            'old_number_rooms' => $data['rooms']->id,
            'id_costumers' => $data['content']->id_costumers,
            'id_re_key' => $data['input']->id_key,
            // input id number_rooms for insert new rooms
            'rooms_number'  => $data['input']->rooms_number,
            'qrcode_key'  => $data['content']->qrcode_key
        ];



        if ($this->orders->edit($update)) {
            $this->session->set_flashdata('success', 'Berhasil di perbaharui');
        } else {
            $this->session->set_flashdata('warning', 'Terjadi suatu kesalahan');
        }


        redirect(base_url('admin/orders/edit/' .  $id));
    }
    // delete qrcodes
    public function delete($id)
    {

        if (!$_POST) {
            $this->session->set_flashdata('error', 'Orders tidak di temukan.');
            redirect(base_url('admin/orders'));
        } else {


            $this->orders->table = 'costumers_key';
            $cost_key    = $this->orders->select([
                'costumers_key.id as costId',
                'costumers_key.id_rooms_key as rooms_key',
                'costumers_key.id_costumers',

                'registered_key.id as id_re_key',
                'registered_key.id_rooms',


                'rooms_key.qrcode_key'

            ])->join('rooms_key')
                ->join('registered_key')
                ->where('costumers_key.id', $id)
                ->first();


            $inv = $this->db->select('invoice')->from('booking_orders')->where('id_costumers', $cost_key->id_costumers)->get()->row();


            if (!$cost_key) {
                $this->session->set_flashdata('warning', 'kunci tidak ditemukan!');

                redirect(base_url('admin/orders'));
            }


            if ($this->orders->erase($cost_key)) {
                $this->orders->table = 'rooms';
                $this->orders->where('id', $cost_key->id_rooms)->update(['status' => '0']);
                $this->session->set_flashdata('success', 'Kunci berhasil di hapus.');
            } else {
                $this->session->set_flashdata('warning', 'Terjadi suatu kesalahan!');
            }



            redirect(base_url('admin/orders'));
        }
    }

    public function send()
    {
        $idcost = $this->input->post('costId', true);
        $id_key = $this->input->post('id_key', true);

        // join us
        $data['costumers_key'] = $this->db->select([
            'costumers_key.id_booking_orders',

            'registered_key.date_from',
            'registered_key.date_to',


            'rooms.number_rooms',

            'rooms_key.qrcode_key',
            'rooms_key.time_expired',
            'rooms_key.is_active',

            'type_rooms.name as className'
        ])->from('costumers_key')
            ->join('registered_key', 'costumers_key.id_registered_key = registered_key.id')
            ->join('rooms_key', 'costumers_key.id_rooms_key = rooms_key.id')
            ->join('type_rooms', 'registered_key.id_type_rooms = type_rooms.id')
            ->join('rooms', 'registered_key.id_rooms = rooms.id')
            ->where('costumers_key.id_costumers', $idcost)
            ->where('rooms_key.id', $id_key)
            ->get()
            ->row();

        // get id_extra
        $data['boor'] = $this->db->select([
            'booking_orders.invoice',
            'booking_orders.status',

            'booking_orders_detail.id_extra'
        ])->from('booking_orders_detail')->join('booking_orders', 'booking_orders_detail.id_booking_orders = booking_orders.id')->where('id_booking_orders', $data['costumers_key']->id_booking_orders)->get()->row();

        // get extra bed name 
        $extra = $this->db->select('name')->from('extra')->where('id', $data['boor']->id_extra)->get()->row();
        $data['extraBed'] = $extra ? $extra->name : '';

        // get costumers
        $data['costumers'] = $this->db->select(['name', 'email'])->from('costumers')->where('id', $idcost)->get()->row();

        $data['estimation'] = calculateDiffDate($data['costumers_key']->date_from, $data['costumers_key']->date_to);


        $this->sendEmails($data, $data['costumers']->email, 'Kunci Kamar',  $this->email,  'costumerskeys', 'admin/orders/');
    }


    // public function sendKeys()
    // {


    //     $config1['protocol']     = 'smtp';
    //     $config1['smtp_host']    = 'ssl://smtp.gmail.com';
    //     $config1['smtp_port']    = '465';
    //     $config1['smtp_timeout'] = '7';
    //     $config1['smtp_user']    = 'rifal.keksukabumi@gmail.com';
    //     $config1['smtp_pass']    = 'rifalnakbrc207';
    //     $config1['charset']      = 'utf-8';
    //     $config1['newline']      = "\r\n";
    //     $config1['mailtype']     = 'html'; // or html
    //     $config1['validation']   = TRUE; // bool whether to validate email or not  

    //     $this->load->library('email', $config1);
    //     $this->email->initialize($config1);


    //     $this->email->from('cikidang@resort');
    //     $this->email->to('rifalnurchya@gmail.com');
    //     $this->email->subject('Header');

    //     // if ($this->email->send()) {
    //     //     return true;
    //     // } else {
    //     //     $this->email->print_debugger();
    //     //     die;
    //     // }
    // }
}

/* End of file Orders.php */
