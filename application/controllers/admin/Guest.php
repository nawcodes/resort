<?php



defined('BASEPATH') or exit('No direct script access allowed');

class Guest extends Hotel_Controller
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

        $this->guest->table = 'rooms';


        $data['content'] = $this->guest->select(
            [
                'rooms.id',
                'rooms.number_rooms',
                'rooms.status',


                'type_rooms.name',
            ]
        )
            ->join('type_rooms')
            ->get();





        $data['title'] = 'Kamar Tamu';
        $data['admin'] = 'pages/admin/guest';
        $this->view_admin($data);
    }


    public function create($id)
    {
        $this->guest->table = 'rooms';

        $data['content'] = $this->guest->select(
            [
                'rooms.id as id_rooms',
                'rooms.number_rooms',
                'rooms.status',

                'type_rooms.id as typeId',
                'type_rooms.name as className',
            ]
        )
            ->join('type_rooms')
            ->where('rooms.id', $id)
            ->first();



        if (!$data['content']) {

            $this->session->set_flashdata('warning', 'Ruangan tidak ditemukan.');
            redirect(base_url('admin/guest'));
        }

        if (!$_POST) {
            $data['input'] = (object) $this->guest->setDefaultValues();
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }

        if (!$this->guest->validate()) {
            $data['title']  = 'Buat Kamar Tamu';
            $data['form']   = base_url('admin/guest/create/' . $id);
            $data['admin']  = 'pages/admin/guest-form';
            $this->view_admin($data);
            return;
        }


        // validation date()

        if ($data['input']->date_from === $data['input']->date_to) {
            $this->session->set_flashdata('warning', 'Tanggal Kedatangan dan Tanggal Selesai Tidak Boleh Sama');
            redirect(base_url('admin/guest/create/' . $id));
        }

        if ($data['input']->date_to <= $data['input']->date_from) {
            $this->session->set_flashdata('warning', 'Tanggal Kedatangan tidak boleh sama atau tidak boleh < dari tanggal kedatangan.');
            redirect(base_url('admin/guest/create/' . $id));
        }


        $insert = [
            'title'         => $data['input']->title,
            'role_key'      => 'guest',
            'date_from'     => $data['input']->date_from,
            'date_to'       => $data['input']->date_to,
            'id_rooms'      => $data['content']->id_rooms,
            'id_type_rooms' => $data['content']->typeId
        ];


        $this->guest->table = 'registered_key';

        if ($lastReId = $this->guest->insert($insert)) {

            $re_data = $this->guest->select(
                [
                    'registered_key.title',
                    'registered_key.date_to',

                    'rooms.number_rooms',
                ]
            )->join('rooms')->where('registered_key.id', $lastReId)->first();

            $this->guest->table = 'rooms';
            $this->guest->where('id', $data['input']->id_rooms)->update(['status' => 1]);

            $this->guest->table = 'rooms_key';

            $dt = new DateTime($re_data->date_to . ' 00:00:00+00');
            $dt->modify("+23 hours");

            $qrcodesData = (object) [
                'number_rooms' => $re_data->number_rooms,
                'date_to'      => $dt->format('Y-m-d H:i:s'),
                'title'        => $re_data->title
            ];

            $qrcodes = $this->guest->makeQrCodes($qrcodesData);

            $key = [
                'id_registered_key' => $lastReId,
                'qrcode_key'        => $qrcodes,
                'time_expired'      => $dt->format('Y-m-d H:i:s'),
                'is_active'         => 1
            ];

            $this->guest->insert($key);

            $this->session->set_flashdata('success', 'Kamar Telah di buat');

            redirect(base_url('admin/guest'));
        } else {
            $this->session->set_flashdata('warning', 'Terjadi suatu kesalahan!');
            redirect(base_url('admin/guest'));
        }
    }


    public function edit($id)
    {

        $this->guest->table = 'rooms_key';



        $data['re_key'] = $this->guest->select(
            [

                'rooms_key.id_registered_key',
                'rooms_key.qrcode_key',
                'rooms_key.time_expired',
                'rooms_key.is_active',

                'registered_key.id as reId',
                'registered_key.title',
                'registered_key.role_key',
                'registered_key.date_from',
                'registered_key.date_to',
                'registered_key.id_rooms',
                'registered_key.date_registered',

            ]
        )->join('registered_key')
            ->where('registered_key.id_rooms', $id)
            ->first();






        $this->guest->table = 'rooms';

        $data['content']  = $this->guest->select(
            [
                'rooms.id as id_rooms',
                'rooms.number_rooms',
                'rooms.status',

                'type_rooms.name as className',
            ]
        )
            ->join('type_rooms')
            ->where('rooms.id', $id)
            ->where('rooms.status', 1)
            ->first();

        if (!$data['re_key']) {

            $this->session->set_flashdata('warning', 'Ganti Status No Kamar Terlebih Dahulu.');
            redirect(base_url('admin/rooms/edit/' . $id));
        }

        if (!$data['content']) {
            $this->session->set_flashdata('warning', 'Ruangan tidak ada.');
            redirect(base_url('admin/guest'));
        }


        if (!$_POST) {
            $data['input'] = (object) [
                'title'      => $data['re_key']->title,
                'date_from' => $data['re_key']->date_from,
                'date_to'   => $data['re_key']->date_to,
                'is_active' => $data['re_key']->is_active
            ];
        } else {
            $data['input'] =  (object) $this->input->post(null, true);
        }

        if (!$this->guest->validate()) {

            $data['title']  = 'Edit Ruangan Tamu';
            $data['form']   = base_url('admin/guest/edit/' . $id);
            $data['admin']  = 'pages/admin/guest-form';
            $this->view_admin($data);
            return;
        }

        // validation date
        if ($data['input']->date_from === $data['input']->date_to) {
            $this->session->set_flashdata('warning', 'Tanggal Kedatangan dan Tanggal Selesai Tidak Boleh Sama');
            redirect(base_url('admin/guest/edit/' . $id));
        }

        if ($data['input']->date_to <= $data['input']->date_from) {
            $this->session->set_flashdata('warning', 'Tanggal Kedatangan tidak boleh sama atau tidak boleh < dari tanggal kedatangan.');
            redirect(base_url('admin/guest/edit/' . $id));
        }
        // end validation date


        $update = [
            'title'      => $data['input']->title,
            'date_from' => $data['input']->date_from,
            'date_to'   => $data['input']->date_to,
        ];

        $this->guest->table = 'registered_key';

        if ($this->guest->where('id', $data['re_key']->reId)->update($update)) {
            $this->guest->table = 'rooms_key';
            $this->guest->where('id_registered_key', $data['re_key']->reId)->update(['is_active' => $data['input']->is_active]);

            $this->session->set_flashdata('success', 'Ruangan di perbaharui.');
        } else {
            $this->session->set_flashdata('error', 'Terjadi suatu kesalahan!');
        }

        redirect(base_url('admin/guest'));
    }


    public function delete($id)
    {
        if (!$_POST) {

            redirect(base_url('admin/guest'));
        } else {

            $input = (object) $this->input->post(null, true);

            // overide  rooms_key for get_key
            $this->guest->table = 'rooms_key';
            $re_key = $this->guest->select([
                'rooms_key.id_registered_key as reId',
                'rooms_key.qrcode_key',
                'registered_key.id_rooms'
            ])->join('registered_key')
                ->where('rooms_key.id_registered_key', $id)->first();

            if ($this->input->post('re_id') != $re_key->reId) {
                $this->session->set_flashdata('warning', 'Terjadi Suatu kesalahan ID');
                redirect(base_url('admin/guest'));
            };

            if (!$re_key) {
                $this->session->set_flashdata('warning', 'Kunci yang terdaftar tidak ada.');
                redirect(base_url('admin/guest'));
            }


            // input to function
            if ($this->guest->erase($input->re_id, $re_key)) {
                $this->session->set_flashdata('success', 'Kunci Kamar & Ruangan Telah di Bersihkan.');
            } else {
                $this->session->set_flashdata('error', 'Terjadi suatu kesalahan!');
            }
            redirect(base_url('admin/guest'));
        }
    }


    public function send()
    {
        $re_id = $this->input->post('re_id', true);
        $email = $this->input->post('email', true);

        $this->guest->table = 'rooms_key';
        $data['rooms_key'] = $this->guest->select([
            'rooms_key.qrcode_key',
            'rooms_key.time_expired',

            'registered_key.title',
            'registered_key.date_from',
            'registered_key.date_to ',
            'registered_key.id_rooms',
            'registered_key.id_type_rooms',

        ])->join('registered_key')
            ->where('registered_key.id', $re_id)
            ->first();


        $data['type_rooms'] = $this->db->select('name')->from('type_rooms')->where('id', $data['rooms_key']->id_type_rooms)->get()->row();



        $data['rooms'] = $this->db->select('number_rooms')->where('id', $data['rooms_key']->id_rooms)->from('rooms')->get()->row();





        $this->sendEmails($data, $email, 'Kunci Tamu', $this->email, 'guestkeys', 'admin/guest');
    }
}

/* End of file Guest.php */
