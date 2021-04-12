<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Booking_model extends Hotel_Model
{

    public $table = 'booking';


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
                'field' => 'address',
                'label' => 'Alamat Lengkap',
                'rules' => 'required|trim|max_length[255]'
            ],
            // [
            //     'field' => 'is_healthy',
            //     'label' => 'Apakah kamu sehat ?',
            //     'rules' => 'required'
            // ],

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
            // [
            //     'field' => 'account_id',
            //     'label' => 'No. KTP',
            //     'rules' => 'required|numeric|min_length[16]|max_length[16]|callback_unique_accountId'
            // ],
            [
                'field' => 'phone',
                'label' => 'No. Telepon',
                'rules' => 'required|numeric|max_length[50]'
            ]

        ];

        return $rules;
    }






    public function uploadImage($field, $imageName)
    {
        $config = [
            'upload_path'        => './assets/images/account/',
            'allowed_types'      => 'jpg|png|jpeg|gif|JPG|JPEG|',
            'max_size'           => 10048,
            'max_width'          => 0,
            'max_height'         => 0,
            'file_name'          => $imageName,
            'overwrite'          => true,
            'file_ext_tolower'   => true,
        ];

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload($field)) {
            $image = $this->upload->data();

            // load library image GD2
            $this->load->library('image_lib');
            // config resize
            $image_config["image_library"] = "gd2";
            $image_config["source_image"] = $image["full_path"];
            $image_config['create_thumb'] = FALSE;
            $image_config['maintain_ratio'] = TRUE;
            $image_config['new_image'] = './assets/images/account';
            $image_config['quality'] = "100%";
            $image_config['width'] = 640;
            $image_config['height'] = 382;
            $image_config['file_name'] = $imageName;
            $dim = (intval($image["image_width"]) / intval($image["image_height"])) - ($image_config['width'] / $image_config['height']);
            $image_config['master_dim'] = ($dim > 0) ? "height" : "width";
            $this->image_lib->initialize($image_config);

            // check when errors
            if (!$this->image_lib->resize()) {
                $this->session->set_flashdata('error', $this->image_lib->display_errors('', ''));
            } else {
                // if success next croping
                // delete first on full image account
                // if (file_exists('./assets/images/account/' . $image['full_path'])) {
                //     unlink('./assets/images/account/' . $image['full_path']);
                // }
                // config croping
                $image_config['image_library'] = 'gd2';
                // $image_config['library_path'] = '/usr/bin/convert';
                $image_config['source_image'] = './assets/images/account/' . $image['file_name'];
                $image_config['new_image'] = './assets/images/ktp/';
                $image_config['quality'] = "100%";
                $image_config['x_axis'] = '0';
                $image_config['y_axis'] = '-285';
                $image_config['file_name'] = $imageName;
                $this->image_lib->clear();
                $this->image_lib->initialize($image_config);
                if (!$this->image_lib->crop()) {
                    $this->session->set_flashdata('error', $this->image_lib->display_errors('', ''));
                }
                return $image;
            }
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
        }
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
            'is_approved'   => 'unverified',
            'account_image' => $data->account_image,
            'account_image_user' => $data->account_image,
            'passport'      => $data->passport,
            'visa'          => $data->visa,
        ];



        $this->table = 'costumers';

        $last_id = $this->insert($costumers);


        $this->table = 'type_rooms';

        $rooms = $this->where('id', $data->id_rooms)->first();

        $this->table = 'extra';

        $extra_bed = $this->where('id', $data->extra)->first();


        if (!$extra_bed) {
            $extra_bed = (object) ['price' => 0];
        }

        $subtotal = (calculateDiffDate($data->date_from, $data->date_to) *  ($data->rooms * $rooms->price_pernight)) + ($data->extra * $extra_bed->price);


        // var_dump(calculateDiffDate($data->date_from, $data->date_to) . ' * ' . $rooms->price_pernight . '(+' . $data->extra . ' * ' . $extra_bed->price . ' = ' . $subtotal);die;

        $booking = [
            'id_costumers'  => $last_id,
            'id_type_rooms' => $data->id_rooms,
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

    public function deleteImage($data)
    {
        if (file_exists('./assets/images/account/' . $data)) {
            unlink('./assets/images/account/' . $data);
        }
    }


    public function getNik($nik)
    {
        $result = [];
        $regex  = "/\d{16}/";
        if (preg_match($regex, $nik, $result)) {
            return $result[0];
        }
        return null;
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






    // public function multiple_upload($upload ,  $imageName) {


    //     $this->load->library('upload');


    //     $number_of_files_uploaded = count($upload['image']['name']);

    //     // Faking upload calls to $_FILE
    //     for ($i = 0; $i < $number_of_files_uploaded; $i++) :
    //       $upload['userfile']['name']     = $upload['image']['name'][$i];
    //       $upload['userfile']['type']     = $upload['image']['type'][$i];
    //       $upload['userfile']['tmp_name'] = $upload['image']['tmp_name'][$i];
    //       $upload['userfile']['error']    = $upload['image']['error'][$i];
    //       $upload['userfile']['size']     = $upload['image']['size'][$i];

    //       $config = array(
    //         'file_name'     => $imageName,
    //         'allowed_types' => 'jpg|jpeg|png|gif',
    //         'max_size'      => 3000,
    //         'overwrite'     => FALSE,

    //         /* real path to upload folder ALWAYS */
    //         'upload_path'
    //             => './assets/images/account/'
    //       );

    //       $this->upload->initialize($config);

    //       if ( ! $this->upload->do_upload()) :
    //         $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
    //       else :
    //         $data[] =  $this->upload->data();
    //         // Continue processing the uploaded data
    //       endif;
    //     endfor;



    // }



}



/* End of file Booking_model.php */
