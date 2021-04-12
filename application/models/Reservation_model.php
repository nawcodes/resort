<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Reservation_model extends Hotel_Model
{

    public $table = '';


    public function setDefaultValues()
    {
        return  [
            'name'          => '',
            'email'         => '',
            'address'       => '',
            'extra'         => 0,
            'date_from'     => '',
            'date_to'       => '',
            'phone'         => '',
            'account_id'    => '',
            'person'        => 0,
            'adult'         => 0,
            'rooms'         => '',
        ];
    }

    public function setRules()
    {
        $rules = [
            [
                'field' => 'name',
                'label' => 'Nama Lengkap',
                'rules' => 'required|trim|max_length[255]'
            ],
            [
                'field' => 'email',
                'label' => 'Email Aktif',
                'rules' => 'required|trim|valid_email|max_length[255]'
            ],
            [
                'field' => 'date_to',
                'label' => 'Dari Tanggal Kapan?',
                'rules' => 'required'
            ],
            [
                'field' => 'date_from',
                'label' => 'Sampai Tanggal kapan?',
                'rules' => 'required'
            ],
            [
                'field' => 'account_id',
                'label' => 'No. KTP',
                'rules' => 'required|numeric|min_length[16]|max_length[16]'
            ],
            [
                'field' => 'phone',
                'label' => 'No. Telepon',
                'rules' => 'required|numeric|max_length[50]'
            ],
            [
                'field' => 'person',
                'label' => 'Berapa Orang',
                'rules' => 'required|numeric'
            ],
            [
                'field' => 'adult',
                'label' => 'Berapa Orang Dewasa',
                'rules' => 'required|numeric'
            ],
            [
                'field' => 'rooms',
                'label' => 'Berapa Kamar',
                'rules' => 'required|numeric'
            ]

        ];

        return $rules;
    }


    public function create($data)
    {

        $costumers = [
            'name'      => $data->name,
            'email'     => $data->email,
            'phone'     => $data->phone,
            'address'   => $data->address,
            'account_id'    => $data->account_id,
            'is_healthy'    => 1,
            'is_approved'   => 'verified',
            'account_image' => $data->account_image,
            'account_image_user' => $data->account_image,
            'passport'      => $data->passport,
            'visa'          => $data->visa,
        ];



        $this->table = 'costumers';

        $last_id = $this->insert($costumers);


        $this->table = 'type_rooms';

        $rooms = $this->where('id', $data->type_rooms)->first();

        $this->table = 'extra';

        $extra_bed = $this->where('id', $data->extra)->first();


        if (!$extra_bed) {
            $extra_bed = (object) ['price' => 0];
        }

        $subtotal = (calculateDiffDate($data->date_from, $data->date_to) * ($data->rooms *  $rooms->price_pernight)) + ($data->extra * $extra_bed->price);



        $booking = [
            'id_costumers'  => $last_id,
            'id_type_rooms' => $data->type_rooms,
            'rooms'         => $data->rooms,
            'id_extra'      => $data->extra,
            'date_from'     => $data->date_from,
            'date_to'       => $data->date_to,
            'person'        => $data->person,
            'adult'         => $data->adult,
            'child'         => $data->child,
            'age_child'     => $data->age_child,
            'subtotal'      => $subtotal
        ];

        $this->table = 'booking';

        if ($id = $this->insert($booking)) {
            return $id;
        } else {
            return false;
        };
    }

    public function checkout($id)
    {
        $this->table = 'booking';


        $bo = $this->select([
            'booking.id',
            'booking.id_costumers',

            'costumers.account_id'
        ])->join('costumers')->where('booking.id', $id)->first();

        if (!$bo) {
            $this->session->set_flashdata('terjadi suatu kesalahan!');
            redirect(base_url('booking'));
        }

        $total = $this->db->select_sum('subtotal')
            ->where('id_costumers', $bo->id_costumers)
            ->get('booking')
            ->row()
            ->subtotal;


        $data = [
            'id_costumers' => $bo->id_costumers,
            'invoice'      => $bo->account_id . date('His'),
            'amount'       => $total,
            'status'        => 'waiting'
        ];

        $this->table = 'booking_orders';
        if ($booking_orders = $this->insert($data)) {
            $booking = $this->db->where('id_costumers', $bo->id_costumers)->get('booking')->result_array();

            foreach ($booking as $row) {
                // add column
                $row['id_booking_orders'] = $booking_orders;

                unset($row['id'], $row['id_costumers'], $row['date_created']);

                $this->table = 'booking_orders_detail';
                $idboor = $this->insert($row);
            }


            $this->db->delete('booking', ['id_costumers' => $bo->id_costumers]);

            return $idboor;
        } else {
            return false;
        }
    }
}

/* End of file Reservation_model.php */
