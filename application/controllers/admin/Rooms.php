<?php



defined('BASEPATH') or exit('No direct script access allowed');

class Rooms extends Hotel_Controller
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


        $data['content'] = $this->rooms->select(
            [
                'rooms.id as roomsId',
                'rooms.number_rooms',
                'rooms.status',

                'type_rooms.name as className',
                'type_rooms.price_pernight',
                'type_rooms.max_person',
                'type_rooms.twin_bed',

            ]
        )
            ->join('type_rooms')
            ->get();



        $data['title']   = 'Ruangan';
        $data['admin']   = 'pages/admin/rooms';
        $this->view_admin($data);
    }




    public function create()
    {

        if (!$_POST) {
            $data['input'] = (object) $this->rooms->setDefaultValues();
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }




        if (!$this->rooms->validate()) {
            $data['form']   =  base_url('admin/rooms/create');
            $data['title']  = 'Tambah Ruangan';
            $data['admin']  = 'pages/admin/rooms-form';
            $this->view_admin($data);
            return;
        }

        $input = [
            'number_rooms'  => $data['input']->number_rooms,
            'status'        => $data['input']->status,
            'id_type_rooms' => $data['input']->id_type_rooms
        ];

        if ($this->rooms->insert($input)) {
            $this->session->set_flashdata('success', 'Nomor kamar telah di tambahkan.');
        } else {
            $this->session->set_flashdata('error', 'Terjadi suatu kesalahan!');
        }


        redirect(base_url('admin/rooms'));
    }


    public function edit($id = null)
    {

        $data['content'] = $this->rooms->where('id', $id)->first();

        if (!$data['content']) {
            $this->session->set_flashdata('warning', 'Ruangan tidak di temukan!');
            redirect(base_url('admin/rooms'));
        }



        if (!$_POST) {
            $data['input'] = $data['content'];
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }



        if (!$this->rooms->validate()) {
            $data['title']  = 'Edit Ruangan';
            $data['form']   = base_url('admin/rooms/edit/' . $id);
            $data['admin']  = 'pages/admin/rooms-form';
            $this->view_admin($data);
            return;
        }


        $update = [
            'number_rooms'  => $data['input']->number_rooms,
            'status'        => $data['input']->status,
            'id_type_rooms' => $data['input']->id_type_rooms
        ];

        if ($this->rooms->where('id', $data['input']->id_rooms)->update($update)) {
            $this->session->set_flashdata('success', 'Di simpan.');
        } else {
            $this->session->set_flashdata('warning', 'Terjadi suatu kesalahan!');
        }


        redirect(base_url('admin/rooms'));
    }


    public function delete($id = null)
    {


        if (!$_POST) {

            redirect(base_url('admin/rooms'), 'refresh');
        } else {
            $rooms = $this->rooms->where('id', $id)->first();

            if (!$rooms) {
                $this->session->set_flashdata('warning', 'Ruangan tidak ditemukan.');

                redirect(base_url('admin/rooms'));
            }


            if ($this->rooms->where('id', $this->input->post('id_rooms', true))->delete()) {
                $this->session->set_flashdata('success', 'Berhasil di hapus.');
            } else {
                $this->session->set_flashdata('warning', 'Terjadi suatu kesalahan!');
            }


            redirect(base_url('admin/rooms'));
        }
    }


    public function unique_numbers()
    {
        $number = $this->input->post('number_rooms', true);
        $id     = $this->input->post('id_rooms', true);

        $rooms  = $this->rooms->where('number_rooms', $number)->first();
        if ($rooms) {
            if ($rooms->id == $id) {
                return true;
            }

            $this->load->library('form_validation');
            $this->form_validation->set_message('unique_numbers', '%s ini sudah ada.');
            return false;
        }

        return true;
    }
}

/* End of file Rooms.php */
