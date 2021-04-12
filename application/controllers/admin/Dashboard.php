<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Hotel_Controller
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


        $this->dashboard->table = 'booking_orders';
        $data['bo_unp'] = $this->dashboard->where('status', 'waiting')->count();
        $data['bo_unc'] = $this->dashboard->where('status', 'unconfirmed')->count();
        $data['bo_paid'] = $this->dashboard->where('status', 'paid')->count();

        $this->dashboard->table = 'costumers';
        $data['cost_unv'] = $this->dashboard->where('is_approved !=', 'verified')->count();

        $data['bank'] = $this->db->get('bank')->row();

        $data['title']  = 'Dashboard';
        $data['admin']  = 'pages/admin/dashboard';
        $this->view_admin($data);
    }


    public function edit_bank($id)
    {

        if ($this->id_role != 1) {
            $this->session->set_flashdata('warning', 'akses di tolak!');
            redirect(base_url('admin/dashboard'));
        }

        $bank = $this->db->get_where('bank', ['id' => $id])->row();

        if (!$bank) {
            $this->session->set_flashdata('warning', 'Bank Tidak di temukan');
            redirect(base_url('admin/dashboard'));
        }

        if (!$_POST) {
            $input = (object) $bank;
        } else {
            $input = (object) $this->input->post();
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Atas nama', 'required');
        $this->form_validation->set_rules('bank_name', 'Nama Bank', 'required');
        $this->form_validation->set_rules('bank_id', 'Nomor Rekening Bank', 'required|numeric');

        if (!$this->form_validation->run()) {
            $data['input'] = $input;
            $data['title'] = 'edit bank';
            $data['admin'] = 'pages/admin/bank-form';
            $this->view_admin($data);
            return;
        }


        if ($this->db->where('id', $input->id)->update('bank', $input)) {
            $this->session->set_flashdata('success', 'Berhasil di perbaharui');
        } else {
            $this->session->set_flashdata('error', 'Terjadi suatu kesalahan!');
        }

        redirect(base_url('admin/dashboard'));
    }


    public function report()
    {

        $this->load->library('pdf');

        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL

        $pdf = new FPDF('L', 'mm', 'Letter');

        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 7, 'Report Bulanan Pemesanan', 0, 1, 'C');
        $pdf->Cell(10, 7, '', 0, 1);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Tanggal', 1, 0, 'C');
        $pdf->Cell(90, 6, 'Invoice', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Nama Costumers', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Status', 1, 1, 'C');

        $date = $this->input->get('date', true);
        $status = $this->input->get('status', true);

        if ($status == '') {
            $cond = '!=';
            $status = '';
        } else {
            $cond = '';
            $status = $status;
        }

        if (!$date) {
            $this->session->set_flashdata('warning', 'Masukan tanggal');
            redirect(base_url('admin/dashboard'));
        }

        $bo_or = $this->db->select([
            'booking_orders.invoice',
            'booking_orders.status',
            'booking_orders.date_created',

            'costumers.name',
        ])->from('booking_orders')
            ->join('costumers', 'booking_orders.id_costumers = costumers.id')
            ->where('booking_orders.date_created >=', "$date%")
            ->where("booking_orders.status {$cond}", $status)
            ->get()
            ->result();


        if (!$bo_or) {
            $this->session->set_flashdata('warning', 'Tidak ada report dengan tanggal tersebut');

            redirect(base_url('admin/dashboard'));
        }

        $pdf->SetFont('Arial', '', 10);
        $no = 0;

        foreach ($bo_or as $row) {
            $time = strtotime($row->date_created);
            $format = date('Y-m-d', $time);
            $no++;
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(40, 6, indoDate($format), 1, 0);
            $pdf->Cell(90, 6, $row->invoice, 1, 0);
            $pdf->Cell(40, 6, $row->name, 1, 0);
            $pdf->Cell(40, 6, $row->status, 1, 1);
        }
        $pdf->Output();
    }
}

/* End of file Admin.php */
