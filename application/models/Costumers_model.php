<?php



defined('BASEPATH') or exit('No direct script access allowed');

class Costumers_model extends Hotel_Model
{

    protected $table = '';


    public function setDefaultValues()
    {
        return [
            'name'          => '',
            'email'         => '',
            'phone'         => '',
            'address'       => '',
            'account_id'    => '',
        ];
    }


    public function setRules()
    {
        $rules = [
            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim|max_length[255]'
            ],
            [
                'field' => 'email',
                'label' => 'E-mail',
                'rules' => 'required|valid_email|max_length[255]'
            ],
            [
                'field' => 'phone',
                'label' => 'Telpon',
                'rules' => 'required|numeric'
            ],
            [
                'field' => 'account_id',
                'label' => 'Nomor KTP',
                'rules' => 'required|numeric|max_length[16]|min_length[16]'
            ],
            [
                'field' => 'address',
                'label' => 'Alamat',
                'rules' => 'required|trim|max_length[255]'
            ]
        ];

        return $rules;
    }


    public function erase($input)
    {
        if ($this->session->userdata('id_role') != 1) {
            return false;
        }
        // check costumers
        $costumers = $this->costumers->where('id', $input->id)->first();
        if ($costumers) {
            //  delete image costumers 
            deleteImage($costumers->account_image, 'account');
            //  delete image with user costumers
            deleteImage($costumers->account_image_user, 'account');
            // overide booking if ready costumers
            $this->table = 'booking';
            if ($this->where('id_costumers', $input->id)->get()) {
                $this->where('id_costumers', $input->id)->delete();
            }
            // overide booking orders
            $this->table = 'booking_orders';
            $bor = $this->where('id_costumers', $input->id)->get();
            if ($bor) {
                // first overide bo_or_detail delete first()
                foreach ($bor as $row) {
                    $this->table = 'booking_orders_detail';
                    $this->where('id_booking_orders', $row->id)->delete();
                    // second overide bo_orders_confrim delete seccond
                    $this->table = 'booking_confirm';
                    // get payment image for delete
                    $boc = $this->where('id_booking_orders', $row->id)->get();
                    // foreach for delete image
                    foreach ($boc as $or) {
                        deleteImage($or->image, 'payment');
                    }
                    // delete booking_confirm
                    $this->where('id_booking_orders', $row->id)->delete();
                }
            }

            // last  for delete booking_orders
            $this->table = 'booking_orders';
            $this->where('id_costumers', $input->id)->delete();

            // overide for delete costumers key
            $this->table = 'costumers_key';
            $key = $this->where('id_costumers', $input->id)->get();
            if ($key) {
                foreach ($key as $row) {
                    // overide for delete registered_key
                    $this->table = 'registered_key';
                    $this->where('id', $row->id_registered_key)->delete();

                    // overide for rooms_key
                    $this->table = 'rooms_key';
                    $rooms_key = $this->where('id', $row->id_rooms_key)->get();
                    // delete key from dir
                    foreach ($rooms_key as $rk) {
                        deleteImage($rk->qrcode_key, 'qrcodes');
                        $this->where('id', $rk->id)->delete();
                    }
                }
            }
            // last overide for delete costumers_key
            $this->table = 'costumers_key';
            $this->where('id_costumers', $input->id)->delete();
            // last overide to costumer and deleted
            $this->table = 'costumers';
            $this->where('id', $input->id)->delete();
        }

        return true;
    }
}

/* End of file Costumers_model.php */
