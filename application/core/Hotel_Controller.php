<?php




defined('BASEPATH') or exit('No direct script access allowed');

class Hotel_Controller extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();

        $model = get_class($this);
        if (file_exists(APPPATH . 'models/' . $model . '_model.php')) {
            $this->load->model($model . '_model', strtolower($model), true);
        }
    }


    public function view($data)
    {
        $this->load->view('layouts/app', $data);
    }


    public function view_admin($data)
    {
        $this->load->view('layouts/app-admin', $data);
    }




    public function sendEmails($data, $toEmail, $subject, $fromEmail, $for,  $redirect = '')
    {
        $bank = $this->db->get('bank')->row();

        $config['mail_mailer']          = 'PHPMailer';
        $config['mail_debug']           = 0; // default: 0, debugging: 2, 'local'
        $config['mail_debug_output']    = 'html';
        $config['mail_smtp_auth']       = true;
        $config['mail_smtp_secure']     = 'ssl'; // default: '' | tls | ssl |
        $config['mail_charset']         = 'utf-8';

        $config['mail_smtp']            = 'smtp.gmail.com';
        $config['mail_port']            =  465; // for gmail default 587 with tls
        $config['mail_user']            = 'clubhouse.resort@gmail.com';
        $config['mail_pass']            = 'club2021';

        $config['mail_replyto_mail']    = $fromEmail;
        $config['mail_replyto_name']    = 'admin-resort@clubhouse';


        $config['mail_from_mail']       = $fromEmail;
        $config['mail_from_name']       = 'cikidang@resort';



        $mail = new Mail($config);
        // send costumers booking confirm
        if ($for == 'confirm') {
            $message = '
            <h1>Hello</h1>
        ';
            $mail->setMailBody($message);
            if ($mail->sendMail($subject, $toEmail)) {
            } else {
                redirect(base_url());
            }
        }
        // send costumers keys
        if ($for == 'costumerskeys') {


            $message = '
            <h2>Terimakasih telah memesan kamar di hotel kami "' . $data['costumers']->name . '"</h2> 
            <small>Invoice : #<strong>' . $data['boor']->invoice . '</strong></small>
            <br>
            <small> Mohon Tunggu jikalau Qrcodes Belum Muncul </small>
            
            <p>Kunci Kamar Hotel</p>
            <img src="./assets/images/qrcodes/' . $data['costumers_key']->qrcode_key . '">

            
            <p> No kamar : ' . $data['costumers_key']->number_rooms . ' </p>
            <p> Kelas    : ' . $data['costumers_key']->className . ' </p>
            <p> Estimasi Menginap : ' . $data['estimation'] . ' Malam  </p>
            <p>Tanggal Checkin : ' . indoDate($data['costumers_key']->date_from)  . '</p>
            <p>Tanggal Checkout : ' . indoDate($data['costumers_key']->date_to) .  '</p>
            <p>Waktu kunci habis   : ' . $data['costumers_key']->time_expired . ' </p>
            <p> Silahkan Gunakan Kunci QR-CODES ini sebagai kunci utama kamar kamu </p> 
            <p> Extra Bed : ' . $data['extraBed']->name . ' </p>
            
            ';
            $mail->setMailBody($message);
            if ($mail->sendMail($subject, $toEmail)) {
                $this->session->set_flashdata('success', 'Kunci berhasil dikirim.');
                redirect(base_url($redirect));
            } else {
                $this->session->set_flashdata('error', 'Terjadi suatu kesalahan! Koneksi Terputus, periksa konektivitas!');
                redirect(base_url($redirect));
            }
        }

        if ($for == 'guestkeys') {
            $message = '
            <small> Mohon Tunggu jikalau Qrcodes Belum Muncul </small>
            
            <p>Kunci Kamar Hotel</p>
            <img src="./assets/images/qrcodes/' . $data['rooms_key']->qrcode_key . '">

            
            <p> No kamar : ' . $data['rooms']->number_rooms . ' </p>
            <p> Kelas    : ' . $data['type_rooms']->name . ' </p>
            <p> Estimasi Menginap : ' . $data['estimation'] . ' Malam  </p>
            <p>Tanggal Checkin : ' . indoDate($data['rooms_key']->date_from)  . '</p>
            <p>Tanggal Checkout : ' . indoDate($data['rooms_key']->date_to) .  '</p>
            <p>Waktu kunci habis   : ' . $data['rooms_key']->time_expired . ' </p>
            <p> Silahkan Gunakan Kunci QR-CODES ini sebagai kunci utama kamar kamu </p>             
            ';
            $mail->setMailBody($message);
            if ($mail->sendMail($subject, $toEmail)) {
                $this->session->set_flashdata('success', 'Kunci berhasil dikirim.');
                redirect(base_url($redirect));
            } else {
                $this->session->set_flashdata('error', 'Terjadi suatu kesalahan! Koneksi Terputus, periksa konektivitas');
                redirect(base_url($redirect));
            }
        }

        if ($for == 'masterkeys') {
            $message = '      
            <p>Kunci Master</p>
            <img src="./assets/images/qrcodes/' . $data['master']->qrcode_key . '">
            <p> Mohon Tunggu jikalau Qrcodes belum muncul </p>
            <p> Atas Nama : ' . $data['master']->name . ' </p>
            ';
            $mail->setMailBody($message);
            if ($mail->sendMail($subject, $toEmail)) {
                $this->session->set_flashdata('success', 'Kunci berhasil dikirim.');
                redirect(base_url($redirect));
            } else {
                $this->session->set_flashdata('error', 'Terjadi suatu kesalahan! Koneksi Terputus, periksa konektivitas');
                redirect(base_url($redirect));
            }
        }

        if ($for == 'reservation') {
            $message = '<h2>Terimakasih sudah memesan. "' . $data['boor']->name . '"</h2> 
            <br>
            <p>Invoice : #<strong>' . $data['boor']->invoice . '</strong></p>
            <p>Silahkan Melakukan Pembayaran Ke </p>
            <li>' . $bank->bank_name . ' ' . $bank->bank_id . ' A/N ' . $bank->name  .  '</li>
            <li>total yang harus di bayarkan: ' . price($data['boor']->amount) . ' </li>
            <li>link konfirmasi orders : <a href="' . base_url('checkout/confirm/' . $data['boor']->boorId) . '">disini</a></li>
            <li>Catatan : Kunci akan kamar akan dikirim melalui E-mail setelah melakukan pembayaran dan dinyatakan di bayar</li>


            <div>
            <h4>Detail Pemesanan</h4>        
            <li>Kelas : ' . $data['type_rooms']->name . '</li>
            <li>Estimasi Menginap : (' . $data['estimation'] .  ' Malam) x ' . price($data['type_rooms']->price_pernight)  . '</li>
            <li>Tanggal Checkin : ' . indoDate($data['boor']->date_from)  . '</li>
            <li>Tanggal Checkout : ' . indoDate($data['boor']->date_to) .  '</li>
            <li>Extra Bed: ' . $data['extraBed'] . '</li>
            <p>Catatan: <i>Minimal checkin pada Tanggal ' .  indoDate($data['boor']->date_from) .  '" Pukul 10:00 Pagi s/d 24:00 Malam</i></p>
            <p>Catatan: <i>Minimal checkout pada Tanggal ' . indoDate($data['boor']->date_to) . '" Pukul 10:00 Pagi s/d 12:00 Siang  </i></p>
            </div>

            <a href="' . base_url('checkout/confirm/' . $data['boor']->boorId) . '" role="button" type="button"> Konfirmasi Pembayaran </a>
';
            $mail->setMailBody($message);
            if ($mail->sendMail($subject, $toEmail)) {
                $this->session->set_flashdata('success', 'Order berhasil di kirim');
                redirect(base_url($redirect));
            } else {
                $this->session->set_flashdata('error', 'Terjadi suatu kesalahan! Koneksi Terputus, periksa konektivitas');
                redirect(base_url($redirect));
            }
        }
    }
}

/* End of file Hotel_Controller.php */
