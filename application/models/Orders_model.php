<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Orders_model extends Hotel_Model
{

    public $table = 'booking_orders';

    // confirm and give access key to costumers
    public function create($input)
    {


        // get costumers
        $this->table = 'costumers';
        $costumers =  $this->where('id', $input->id_costumers)->first();




        // overide bo_or_det
        // for get inv, date_from , date_to 
        // X booking_orders 
        $this->table = 'booking_orders_detail';
        $inv = $this->select([
            'booking_orders_detail.date_from',
            'booking_orders_detail.date_to',
            'booking_orders_detail.id_type_rooms',

            'booking_orders.invoice',
        ])->join('booking_orders')
            ->where('booking_orders.id_costumers', $input->id_costumers)
            ->first();


        $no_rooms = $this->db->select('number_rooms')->from('rooms')->where('id', $input->rooms_number)->get()->row();

        $dt = new DateTime($inv->date_to . ' 00:00:00+00');
        $dt->modify("+12 hours");


        $dataQrcodes = (object) [
            'account_id'     => $costumers->account_id,
            'number_rooms'   => $no_rooms->number_rooms,
            'costumers_name' => $costumers->name,
            'time_expired'   => $dt->format('Y-m-d H:i:s')
        ];

        // make qrcodes key name: [data.accountId]
        $qrcodes = $this->makeQrCodes($dataQrcodes);


        // overide for update status booking_orders
        $this->table = 'booking_orders';

        if ($this->where('id', $input->id_booking_orders)->update(['status' => 'paid'])) {
            // insert registered key first
            $this->table = 'registered_key';


            $re_key = [
                'title'         => $costumers->name,
                'role_key'      => 'costumer',
                'date_from'     => $inv->date_from,
                'date_to'       => $inv->date_to,
                'id_rooms'      => $input->rooms_number,
                'id_type_rooms' => $inv->id_type_rooms
            ];

            // get id for insert to rooms_key
            $id_re_key = $this->insert($re_key);



            // overide for insert rooms_key
            $this->table = 'rooms_key';
            $rooms_key = [
                'id_registered_key' => $id_re_key,
                'qrcode_key'        => $qrcodes,
                'time_expired'      => $dt->format('Y-m-d H:i:s'),
                'is_active'         => 1
            ];


            // $id_rooms_key = last_insert_id
            // insert to rooms_key
            $id_rooms_key = $this->insert($rooms_key);


            // ovaride for insert costumers_key
            $this->table = 'costumers_key';
            $cost_key = [
                'id_registered_key' => $id_re_key,
                'id_rooms_key'      => $id_rooms_key,
                'id_costumers'      => $input->id_costumers,
                'id_booking_orders' => $input->id_booking_orders
            ];

            $this->insert($cost_key);

            // ovaride for update rooms
            $this->table = 'rooms';
            $this->where('id',  $input->rooms_number)->update(['status' => 1]);

            $this->session->set_flashdata('success', 'Akses Kunci Di Berikan');
            return true;
        } else {
            $this->session->set_flashdata('warning', 'Terjadi suatu kesalahan');
            return false;
        }
        return true;
    }


    public function makeQrCodes($data)
    {

        $this->load->library('ciqrcode');


        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/images/qrcodes/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);


        $image_name = $data->account_id . date('His') . '.png';
        $params['data'] = "nama:$data->costumers_name \r\n no:$data->number_rooms \r\n durasi:$data->time_expired";
        //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/qrcodes
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        return $image_name;
    }


    public function edit($data)
    {
        // make qrcodes new
        // get account_id for name qrcodes 
        $costumers = $this->db->select('account_id')->from('costumers')->where('id', $data->id_costumers)->get()->row();
        if ($data->qrcode_key !== '') {
            // delete qrcodes 
            if (file_exists('./assets/images/qrcodes/' . $data->qrcode_key)) {
                unlink('./assets/images/qrcodes/' . $data->qrcode_key);
            }
        }
        // renew qrcodes
        $new_qrcodes = $this->makeQrCodes($costumers->account_id);
        // fill obj image name to new image name 
        $data->qrcode_key = $new_qrcodes;



        // overide for update rooms_number from re_key
        $this->table = 'registered_key';
        $this->where('id', $data->id_re_key)->update(['id_rooms' => $data->rooms_number]);

        // overide for update new qrcodes on rooms_key
        $this->table = 'rooms_key';
        $this->where('id_registered_key', $data->id_re_key)->update(['qrcode_key' =>  $data->qrcode_key]);

        // overide for update rooms status
        $this->table = 'rooms';
        // old number rooms
        $this->where('id', $data->old_number_rooms)->update(['status' => 0]);
        // new number roomms
        $this->where('id', $data->rooms_number)->update(['status' => 1]);

        return true;
    }


    public function erase($data)
    {

        if (!empty($data->qrcode_key)) {
            if (file_exists('./assets/images/qrcodes/' . $data->qrcode_key)) {
                unlink('./assets/images/qrcodes/' . $data->qrcode_key);
            }
        }

        // overide for delete costumers_key by id
        $this->table = 'costumers_key';
        $this->where('id', $data->costId)->delete();

        // overide for delete registered key by id
        $this->table = 'registered_key';
        $this->where('id', $data->id_re_key)->delete();

        // overide for delete rooms_key by id
        $this->table = 'rooms_key';
        $this->where('id', $data->id_rooms_key)->delete();

        // overide for updates data status rooms
        $this->table = 'rooms';
        $this->where('number_rooms', $data->rooms_number)->update(['status' => 0]);

        return true;
    }
}

/* End of file Orders_model.php */
