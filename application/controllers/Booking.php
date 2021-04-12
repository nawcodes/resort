<?php

use thiagoalessio\TesseractOCR\TesseractOCR;

defined('BASEPATH') or exit('No direct script access allowed');

class Booking extends Hotel_Controller
{


    public function __construct()
    {
        parent::__construct();
    }



    public function index()
    {
        // set childAge 
        $childAge = 13;

        if (isset($_GET['search'])) {
            // set session for serach
            $this->session->set_userdata('adult', $this->input->get('adult', true));
            $this->session->set_userdata('child', $this->input->get('child', true));
            $this->session->set_userdata('age', $this->input->get('age', true));
            $this->session->set_userdata('rooms', $this->input->get('rooms', true));


            // value
            $rooms  = $this->session->userdata('rooms');
            $adult  = $this->session->userdata('adult');
            $child  = $this->session->userdata('child');
            $age    = $this->session->userdata('age');
            $person = $adult + $child;
            $this->session->set_userdata('person', $person ? $person : 0);

            // cond if _GET NULL || EMPTY
            if (!is_numeric($rooms) || !is_numeric($adult) || !is_numeric($child)  || !is_numeric($age)) {
                redirect(base_url('booking'));
            }

            // cond if child not NULL | ! empty
            if ($child != 0 && $age != 0) {
                // if age child <= 13 || age child >= child
                if ($age <= $childAge || $age >= $childAge) {
                    // adult + child
                    $adult += $child;
                    // update person
                    $person = $adult;
                    // count childOld
                    $this->session->set_userdata('childOld', $child);
                } else {
                    // default values 
                    $person = $adult + $child;
                }
                // unset if age child < 13
                if ($age < $childAge) {
                    if ($this->session->userdata('childOld')) {
                        $this->session->unset_userdata('childOld');
                    }
                }
            }

            // update session if rooms 2 , adult must be 2
            if ($rooms > 1 && $adult < $rooms) {
                $this->session->set_userdata('adult', $rooms);
            }
            // if ! empty person
            if ($person) {
                $this->booking->table = 'type_rooms';
                // query  
                $data['class'] = $this->booking->select(
                    [

                        'type_rooms.id',
                        'type_rooms.name',
                        'type_rooms.max_person',
                        'type_rooms.price_pernight',
                        'type_rooms.facilities',
                        'type_rooms.image'

                    ]
                )->where('type_rooms.max_person >=', $person)
                    ->get();



                if (!$data['class']) {
                    $data['class'] = $this->booking->get();
                }
            }
        }



        $data['title']  = 'Booking Page';
        $data['page']   = 'pages/booking/index';
        $this->view($data);
    }


    public function reservation($id)
    {
        $this->session->set_userdata('id_type_rooms', $id);
        $data['title']  = 'Reservasi Kamar';
        $data['page']   = 'pages/booking/reservation';
        $this->view($data);
    }



    public function create($id)
    {

        // if btn btn reserv clicked

        if (isset($_GET['btn-reservation'])) {
            $this->session->set_userdata('date_from', $this->input->get('date_from', true));
            $this->session->set_userdata('date_to', $this->input->get('date_to', true));
            $this->session->set_userdata('estimation', calculateDiffDate($this->input->get('date_from', true), $this->input->get('date_to', true)));
        }



        if ($this->session->userdata('date_from') === $this->session->userdata('date_to')) {
            $this->session->set_flashdata('warning', 'Tanggal Kedatangan dan Tanggal Selesai Tidak Boleh Sama');
            redirect(base_url('booking/reservation/' . $this->session->userdata('id_type_rooms')));
        }

        if ($this->session->userdata('date_to') <= $this->session->userdata('date_from')) {
            $this->session->set_flashdata('warning', 'Tanggal Kedatangan tidak boleh sama atau tidak boleh < dari tanggal kedatangan.');
            redirect(base_url('booking/reservation/' . $this->session->userdata('id_type_rooms')));
        }

        if ($this->session->userdata('date_from') < date('Y-m-d', time()) || $this->session->userdata('date_to') < date('Y-m-d', time())) {
            $this->session->set_flashdata('warning', 'Tanggal tidak boleh lebih kecil dari tanggal sekarang.');
            redirect(base_url('booking/reservation/' . $this->session->userdata('id_type_rooms')));
        }



        if (!validateDate($this->session->userdata('date_from')) || !validateDate($this->session->userdata('date_to'))) {
            $this->session->set_flashdata('warning', 'Format Tanggal Harus Benar!');
            redirect(base_url('booking/reservation/' . $this->session->userdata('id_type_rooms')));
        }

        // if btn btn reserv clicked

        // sess from bokking index !important
        $book_sess = [
            'rooms'     => $this->session->userdata('rooms'),
            'adult'     => $this->session->userdata('adult'),
            'child'     => $this->session->userdata('child'),
            'age'       => $this->session->userdata('age'),
            'person'    => $this->session->userdata('person'),
            'childOld'  => $this->session->userdata('childOld')
        ];


        // validate if no have session from index
        if (!$book_sess) {
            redirect(base_url('booking'));
        }

        $data['extra'] = $this->db->select(['id', 'name', 'price'])->from('extra')->get()->result();

        $this->booking->table = 'type_rooms';

        $data['rooms'] = $this->booking->where('id', $id/*$this->input->post('id_rooms')*/)->first();

        $data['total_rooms'] = totalRooms($data['rooms']->id);

        if (!$data['rooms']) {
            $this->session->set_flashdata('error', 'Masa Sesimu habis.');
            redirect(base_url('booking'));
        }

        if ($data['total_rooms'] < 1) {
            $this->session->set_flashdata('warning', 'Sedang habis');
            redirect(base_url('booking'));
        }


        // set default values
        if (!$_POST) {
            $data['input'] = (object) $this->booking->setDefaultValues();
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }

        // INIT CONFIG IMAGE

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

        if (!empty($_FILES) && $_FILES['account_image']['name'] !== '') {
            // make custom name
            $account_imageName = url_title($data['input']->name, '-', true) . '-ktp-' . $_FILES['account_image']['name'];

            $account_image = $this->booking->uploadImage('account_image', $account_imageName);

            if ($account_image) {
                $data['input']->account_image = $account_image['file_name'];
            } else {
                $this->session->set_flashdata(
                    'error',
                    $this->upload->display_errors('', '')
                );

                redirect(base_url('booking/create/' . $id));
            }
        }


        // foto ktp dengan user

        if (!empty($_FILES) && $_FILES['account_image_user']['name'] !== '') {
            // custom name
            $account_image_userName = url_title($data['input']->name, '-', true) . '-full-' . $_FILES['account_image_user']['name'];
            $config['file_name']    = $account_image_userName;
            $config['upload_path'] = './assets/images/complete/';
            $this->upload->initialize($config);
            // check where image not eligable
            if ($this->upload->do_upload('account_image_user')) {
                // return name
                $account_image_user = $this->upload->data();

                // resize
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


        // validate and return
        if (!$this->booking->validate()) {
            $data['title']  = 'Formulir Booking';
            $data['page']   = 'pages/booking/form';
            $this->view($data);
            return;
        }


        // validate date

        if ($data['input']->date_from === $data['input']->date_to) {
            $this->session->set_flashdata('warning', 'Tanggal Kedatangan dan Tanggal Selesai Tidak Boleh Sama');
            redirect(base_url('booking/create/' . $id));
        }

        if ($data['input']->date_to <= $data['input']->date_from) {
            $this->session->set_flashdata('warning', 'Tanggal Kedatangan tidak boleh sama atau tidak boleh < dari tanggal kedatangan.');
            redirect(base_url('booking/create/' . $id));
        }

        if ($data['input']->date_from < date('Y-m-d', time()) || $data['input']->date_to < date('Y-m-d', time())) {
            $this->session->set_flashdata('warning', 'Tanggal tidak boleh lebih kecil dari tanggal sekarang.');
            redirect(base_url('booking/create/' . $id));
        }


        // end validate date


        // check account image_user != null
        if (!$data['input']->account_image_user) {
            $this->session->set_flashdata('error', 'Foto KTP dengan pengguna harus di isi');
            redirect(base_url('booking/create/' . $id));
        }


        // scan nik automatic
        // check if account image !== null
        if ($data['input']->account_image) {
            // check if exist
            if (file_exists('./assets/images/ktp/' . $data['input']->account_image)) {
                // $scan = new TesseractOCR('./assets/images/ktp/' . $data['input']->account_image);
                // $nik = $scan->lang('ind')->run();

                $run = null;

                if ($run !== null && is_numeric($run)) {
                    $data['input']->account_id = $run;
                } else {
                    $data['input']->account_id = 0;
                }

                if (file_exists('./assets/images/ktp/' . $data['input']->account_image)) {
                    unlink('./assets/images/ktp/' . $data['input']->account_image);
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Foto ktp harus di isi');
            redirect(base_url('booking/create/' . $id));
        }

        // end scan nik

        // Insert 


        if ($lastInput = $this->booking->create($data['input'])) {
            $bo = $this->booking->select(
                [
                    'booking.id',
                    'booking.id_costumers',
                    'costumers.account_id'
                ]
            )->join('costumers')->where('booking.id', $lastInput)->first();
            if ($bo->account_id != 0) {
                $this->session->set_flashdata('success', 'Silahkan lakukan pembayaran untuk proses lebih lanjut.');
                $idBoor = $this->booking->checkout($lastInput);
                $this->_sendEmail($idBoor);
                $this->session->set_flashdata('success', 'Terimakasih sudah memesan , silahkan lakukan pembayaran dan  konfirmasi bahwa kamu telah melakukan pembayaran.');
                redirect(base_url('checkout/confirm/' . $idBoor));
            } else {
                $this->session->set_flashdata('warning', 'Sepertinya NIK KTP kamu tidak terbaca oleh sistem kami, tidak apa, silahkan input manual.');
                redirect(base_url('booking/verification/' . $lastInput));
            }
        } else {
            $this->session->set_flashdata('error', 'Terjadi suatu kesalahan!');
            redirect(base_url('booking/create/' . $id));
        }
    }


    public function verification($idbook)
    {
        // get booking

        if (!$idbook) {
            redirect(base_url('booking'));
        }

        $data['booking'] = $this->booking->select([
            'booking.id',
            'booking.id_costumers',
            'costumers.account_id'
        ])->join('costumers')->where('booking.id', $idbook)->first();

        if (strlen($data['booking']->account_id == 16)) {
            $this->session->set_flashdata('error', '');
            redirect(base_url('booking'));
        }

        if (!$_POST) {
            $data['input'] = (object) [
                'id_costumers'  => $data['booking']->id_costumers,
                'account_id'    => $data['booking']->account_id
            ];
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('account_id', 'NIK KTP', 'required|numeric|min_length[16]|max_length[16]');

        if (!$this->form_validation->run()) {
            $data['title']  = 'Verifikasi NIK';
            $data['page']   = 'pages/booking/verification';
            $this->view($data);
            return;
        }


        $this->booking->table = 'costumers';
        if ($this->booking->where('id', $data['input']->id_costumers)->update(['account_id' => $data['input']->account_id])) {
            $idBoor = $this->booking->checkout($idbook);
            $this->_sendEmail($idBoor);
            $this->session->set_flashdata('success', 'Terimakasih sudah memesan , silahkan lakukan pembayaran dan  konfirmasi bahwa kamu telah melakukan pembayaran.');
            redirect(base_url('checkout/confirm/' . $idBoor));
        } else {
            $this->session->set_flashdata('error', 'Terjadi suatu kesalahan!');
            redirect(base_url('booking'));
        }
    }


    private function _sendEmail($id)
    {

        // $boor = $this->db->get_where('booking_orders', ['id' => $id])->row();
        $boor = $this->db->select([
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
            ->where('booking_orders.id', $id)
            ->get()
            ->row();



        $type_rooms = $this->db->select([
            'name',
            'price_pernight'
        ])->from('type_rooms')
            ->where('id', $boor->id_type_rooms)
            ->get()
            ->row();

        $extra =  $this->db->select([
            'name',
            'price'
        ])->from('extra')
            ->where('id', $boor->id_extra)
            ->get()
            ->row();

        $extraBed = $extra->name ?  $extra->name . ' / ' . price($extra->price) : 'Tidak Memesan';
        $estimation = calculateDiffDate($boor->date_from, $boor->date_to);

        $bank = $this->db->get('bank')->row();




        $config['protocol']     = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'clubhouse.resort@gmail.com';
        $config['smtp_pass']    = 'club2021';
        $config['charset']      = 'utf-8';
        $config['newline']      = "\r\n";
        $config['mailtype']     = 'html'; // or html
        $config['validation']   = TRUE; // bool whether to validate email or not  



        $this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('clubhouse.resort@gmail.com', 'clubhouse.cikidang@resort');
        $this->email->to($boor->email);
        $this->email->subject('Orders Detail');
        $this->email->message('
                            <h2>Terimakasih sudah memesan. "' . $boor->name . '"</h2> 
                            <br>
                            <p>Invoice : #<strong>' . $boor->invoice . '</strong></p>
                            <p>Silahkan Melakukan Pembayaran Ke </p>
                            <li>' . $bank->bank_name . ' ' . $bank->bank_id . ' A/N ' . $bank->name  .  '</li>                            <li>total yang harus di bayarkan: ' . price($boor->amount) . ' </li>
                            <li>link konfirmasi orders : <a href="' . base_url('checkout/confirm/' . $boor->boorId) . '">disini</a></li>
                            <li>Catatan : Kunci kamar akan dikirim melalui E-mail setelah melakukan pembayaran dan dinyatakan di bayar, kunci berupa QR-CODE</li>
                            <div>
                            <h4>Detail Pemesanan</h4>        
                            <li>Kelas : ' . $type_rooms->name . '</li>
                            <li>Estimasi Menginap : (' . $estimation .  ' Malam) x ' . price($type_rooms->price_pernight)  . '</li>
                            <li>Tanggal Checkin : ' . indoDate($boor->date_from)  . '</li>
                            <li>Tanggal Checkout : ' . indoDate($boor->date_to) .  '</li>
                            <li>Extra Bed: ' . $extraBed . '</li>
                            <p>Catatan: <i>Minimal checkin pada Tanggal ' .  indoDate($boor->date_from) .  '" Pukul 10:00 Pagi s/d 24:00 Malam</i></p>
                            <p>Catatan: <i>Minimal checkout pada Tanggal ' . indoDate($boor->date_to) . '" Pukul 10:00 Pagi s/d 12:00 Siang  </i></p>
                            </div>

                            <a href="' . base_url('checkout/confirm/' . $boor->boorId) . '" role="button" type="button"> Konfirmasi Pembayaran </a>
        ');
        if ($this->email->send()) {
            return true;
        } else {
            var_dump($this->email->print_debugger());
            die;
            // $this->session->set_flashdata('warning', 'Koneksi terputus! , coba lagi');
            // redirect(base_url('booking'), 'refresh');
        }
    }


    // public function unique_accountId()
    // {
    //     $this->booking->table = 'costumers';

    //     $accountId  = $this->input->post('account_id', true);
    //     $id     = $this->input->post('id', true);

    //     $costumers = $this->booking->where('account_id', $accountId)->first();

    //     if ($costumers) {
    //         if ($id == $costumers->id) {
    //             return true;
    //         }
    //         $this->load->library('form_validation');
    //         $this->form_validation->set_message('unique_accountId', '%s sudah terdaftar.');
    //         return false;
    //     }

    //     return true;
    // }


    // public function unique_phone()
    // {
    //     $this->booking->table = 'costumers';

    //     $phone  = $this->input->post('phone', true);
    //     $id     = $this->input->post('id', true);

    //     $costumers = $this->booking->where('phone', $phone)->first();

    //     if ($costumers) {
    //         if ($id == $costumers->id) {
    //             return true;
    //         }
    //         $this->load->library('form_validation');
    //         $this->form_validation->set_message('unique_phone', '%s sudah terdaftar.');
    //         return false;
    //     }

    //     return true;
    // }

    // public function unique_email()
    // {
    //     $this->booking->table = 'costumers';

    //     $email  = $this->input->post('email', true);
    //     $id     = $this->input->post('id', true);

    //     $costumers = $this->booking->where('email', $email)->first();

    //     if ($costumers) {
    //         if ($id == $costumers->id) {
    //             return true;
    //         }
    //         $this->load->library('form_validation');
    //         $this->form_validation->set_message('unique_email', '%s sudah terdaftar.');
    //         return false;
    //     }

    //     return true;
    // }
}

/* End of file Booking.php */
