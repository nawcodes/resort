<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Reservation extends Hotel_Controller
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

        if (!$_POST) {
            $data['input'] = (object) $this->reservation->setDefaultValues();
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }

        $data['type_rooms'] = $this->db->select(['type_rooms.name', 'type_rooms.id as classId', 'type_rooms.price_pernight as price'])->from('rooms')->join('type_rooms', 'rooms.id_type_rooms = type_rooms.id')->where('rooms.status', 0)->distinct()->get()->result();

        $data['extra'] = $this->db->select(['id', 'name', 'price'])->from('extra')->get()->result();


        if (!$_POST) {
            $data['input'] = (object) $this->reservation->setDefaultValues();
        } else {
            $data['input'] = (object) $this->input->post();
        }

        $config = [
            'allowed_types'         => 'jpg|jpeg|png',
            'max_size'              => 4048,
            'max_width'             => 0,
            'max_height'            => 0,
            'file_ext_tolower'      => true,
            'overwrite'             => true,
        ];

        $this->load->library('upload', $config);

        // foto ktp


        if (!empty($_FILES) && $_FILES['account_image']['name'] !== null && $_FILES['account_image']['name'] !== '') {
            // custom name
            $account_imageName = url_title($data['input']->name, '-', true) . '-account_image-' . $_FILES['account_image']['name'];
            $config['file_name'] = $account_imageName;
            $config['upload_path'] = './assets/images/visa/';
            $this->upload->initialize($config);
            // check where image not eligable
            if ($this->upload->do_upload('account_image')) {
                // return name
                $account_image = $this->upload->data();

                $this->load->library('image_lib');
                // config resize
                $image_config["image_library"] = "gd2";
                $image_config["source_image"] = $account_image["full_path"];
                $image_config['create_thumb'] = FALSE;
                $image_config['maintain_ratio'] = TRUE;
                $image_config['new_image'] = './assets/images/account';
                $image_config['quality'] = "100%";
                $image_config['width'] = 640;
                $image_config['height'] = 382;
                $image_config['file_name'] = $account_imageName;
                $dim = (intval($account_image["image_width"]) / intval($account_image["image_height"])) - ($image_config['width'] / $image_config['height']);
                $image_config['master_dim'] = ($dim > 0) ? "height" : "width";
                $this->image_lib->initialize($image_config);

                // check when errors
                if (!$this->image_lib->resize()) {
                    $this->session->set_flashdata('error', $this->image_lib->display_errors('', ''));
                }
                $data['input']->account_image =  $account_image['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            }
        } else {
            $data['input']->account_image = '';
        }


        // foto ktp dengan user

        if (!empty($_FILES) && $_FILES['account_image_user']['name'] !== null && $_FILES['account_image_user']['name'] !== '') {
            // custom name
            $account_image_userName = url_title($data['input']->name, '-', true) . '-account_image_user-' . $_FILES['account_image_user']['name'];
            $config['file_name'] = $account_image_userName;
            $config['upload_path'] = './assets/images/visa/';
            $this->upload->initialize($config);
            // check where image not eligable
            if ($this->upload->do_upload('account_image_user')) {
                // return name
                $account_image_user = $this->upload->data();

                $this->load->library('image_lib');
                // config resize
                $image_config["image_library"] = "gd2";
                $image_config["source_image"] = $account_image_user["full_path"];
                $image_config['create_thumb'] = FALSE;
                $image_config['maintain_ratio'] = TRUE;
                $image_config['new_image'] = './assets/images/complete';
                $image_config['quality'] = "100%";
                $image_config['width'] = 640;
                $image_config['height'] = 382;
                $image_config['file_name'] = $account_image_userName;
                $dim = (intval($account_image_user["image_width"]) / intval($account_image_user["image_height"])) - ($image_config['width'] / $image_config['height']);
                $image_config['master_dim'] = ($dim > 0) ? "height" : "width";
                $this->image_lib->initialize($image_config);

                // check when errors
                if (!$this->image_lib->resize()) {
                    $this->session->set_flashdata('error', $this->image_lib->display_errors('', ''));
                }
                $data['input']->account_image_user =  $account_image_user['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            }
        } else {
            $data['input']->account_image_user = '';
        }




        // passport image
        if (!empty($_FILES) && $_FILES['passport']['name'] !== null && $_FILES['passport']['name'] !== '') {
            // custom name
            $passportName = url_title($data['input']->name, '-', true) . '-passport-' . $_FILES['passport']['name'];
            $config['file_name'] = $passportName;
            $config['upload_path'] = './assets/images/visa/';
            $this->upload->initialize($config);
            // check where image not eligable
            if ($this->upload->do_upload('passport')) {
                // return name
                $passport = $this->upload->data();

                $this->load->library('image_lib');
                // config resize
                $image_config["image_library"] = "gd2";
                $image_config["source_image"] = $passport["full_path"];
                $image_config['create_thumb'] = FALSE;
                $image_config['maintain_ratio'] = TRUE;
                $image_config['new_image'] = './assets/images/passport';
                $image_config['quality'] = "100%";
                $image_config['width'] = 640;
                $image_config['height'] = 382;
                $image_config['file_name'] = $passportName;
                $dim = (intval($passport["image_width"]) / intval($passport["image_height"])) - ($image_config['width'] / $image_config['height']);
                $image_config['master_dim'] = ($dim > 0) ? "height" : "width";
                $this->image_lib->initialize($image_config);

                // check when errors
                if (!$this->image_lib->resize()) {
                    $this->session->set_flashdata('error', $this->image_lib->display_errors('', ''));
                }
                $data['input']->passport =  $passport['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            }
        } else {
            $data['input']->passport = '';
        }


        // visa card image

        if (!empty($_FILES) && $_FILES['visa']['name'] !== null && $_FILES['visa']['name'] !== '') {
            // custom name
            $visaName = url_title($data['input']->name, '-', true) . '-visa-' . $_FILES['visa']['name'];
            $config['file_name'] = $visaName;
            $config['upload_path'] = './assets/images/passport/';
            $this->upload->initialize($config);
            // check where image not eligable
            if ($this->upload->do_upload('visa')) {
                // return name
                $visa = $this->upload->data();
                $this->load->library('image_lib');
                // config resize
                $image_config["image_library"] = "gd2";
                $image_config["source_image"] = $visa["full_path"];
                $image_config['create_thumb'] = FALSE;
                $image_config['maintain_ratio'] = TRUE;
                $image_config['new_image'] = './assets/images/visa';
                $image_config['quality'] = "100%";
                $image_config['width'] = 640;
                $image_config['height'] = 382;
                $image_config['file_name'] = $visaName;
                $dim = (intval($visa["image_width"]) / intval($visa["image_height"])) - ($image_config['width'] / $image_config['height']);
                $image_config['master_dim'] = ($dim > 0) ? "height" : "width";
                $this->image_lib->initialize($image_config);

                // check when errors
                if (!$this->image_lib->resize()) {
                    $this->session->set_flashdata('error', $this->image_lib->display_errors('', ''));
                }
                $data['input']->visa =  $visa['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            }
        } else {
            $data['input']->visa = '';
        }


        if (!$this->reservation->validate()) {
            $data['title'] = 'Pemesanan / Reservasi';
            $data['admin'] = 'pages/admin/reservation';
            $this->view_admin($data);
            return;
        }




        if ($data['input']->date_from === $data['input']->date_to) {
            $this->session->set_flashdata('warning', 'Tanggal Kedatangan dan Tanggal Selesai Tidak Boleh Sama');
            redirect(base_url('booking/reservation/'));
        }

        if ($data['input']->date_to <= $data['input']->date_from) {
            $this->session->set_flashdata('warning', 'Tanggal Kedatangan tidak boleh sama atau tidak boleh < dari tanggal kedatangan.');
            redirect(base_url('booking/reservation/'));
        }

        if ($data['input']->date_from < date('Y-m-d', time()) || $data['input']->date_to < date('Y-m-d', time())) {
            $this->session->set_flashdata('warning', 'Tanggal tidak boleh lebih kecil dari tanggal sekarang.');
            redirect(base_url('booking/reservation/'));
        }

        if ($lastInput = $this->reservation->create($data['input'])) {
            $idBoor = $this->reservation->checkout($lastInput);

            $datas['boor'] = $this->db->select([
                'booking_orders_detail.id_type_rooms',
                'booking_orders_detail.id_extra',
                'booking_orders_detail.date_from',
                'booking_orders_detail.date_to',

                'booking_orders.id as boorId',
                'booking_orders.invoice',
                'booking_orders.amount',
                'booking_orders.status',
                'booking_orders.date_created',

                'costumers.name',
                'costumers.email',
            ])->from('booking_orders_detail')
                ->join('booking_orders', 'booking_orders_detail.id_booking_orders = booking_orders.id')
                ->join('costumers', 'booking_orders.id_costumers = costumers.id')
                ->where('booking_orders.id', $idBoor)
                ->get()
                ->row();


            $datas['type_rooms'] = $this->db->select([
                'name',
                'price_pernight'
            ])->from('type_rooms')
                ->where('id', $datas['boor']->id_type_rooms)
                ->get()
                ->row();

            $datas['extra'] =  $this->db->select([
                'name',
                'price'
            ])->from('extra')
                ->where('id', $datas['boor']->id_extra)
                ->get()
                ->row();

            $datas['extraBed'] = $datas['extra']->name ?  $datas['extra']->name . ' / ' . price($datas['extra']->price) : 'Tidak Memesan';
            $datas['estimation'] = calculateDiffDate($datas['boor']->date_from, $datas['boor']->date_to);


            $this->sendEmails($datas, $datas['boor']->email, 'Orders Detail', $this->email, 'reservation', 'admin/reservation');

            $this->session->set_flashdata('success', 'Reservasi Sudah di buat dan detail telah di kirim ke email');
            redirect(base_url('admin/reservation'));
            $this->session->set_flashdata('success', 'Reversevasi di buat!');
        } else {
            $this->session->set_flashdata('error', 'Terjadi suatu kesalahan!');
            redirect(base_url('admin/reservation'));
        }
    }
}

/* End of file Reservation.php */
