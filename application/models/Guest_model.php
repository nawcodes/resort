<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Guest_model extends Hotel_Model
{

    public $table = '';

    public function setDefaultValues()
    {
        return [
            'title'         => '',
            'date_from'     => '',
            'date_to'       => '',
            'is_active'     => ''
        ];
    }

    public function setRules()
    {
        $rules = [
            [
                'field' => 'title',
                'label' => 'Nama Atau Judul',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'date_from',
                'label' => 'Dari Tanggal',
                'rules' => 'required'
            ],
            [
                'field' => 'date_to',
                'label' => 'Sampai Kapan',
                'rules' => 'required'
            ]

        ];

        return $rules;
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


        $image_name = $data->number_rooms . '-guest' . '.png';
        $params['data'] =  "nama:$data->title \r\n no:$data->number_rooms \r\n durasi:$data->date_to"; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/qrcodes
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        return $image_name;
    }


    public function erase($id, $re_key)
    {

        // delete qrcode image
        if (file_exists('./assets/images/qrcodes/' . $re_key->qrcode_key)) {
            unlink('./assets/images/qrcodes/'  . $re_key->qrcode_key);
        }


        // delete registered_key
        $this->table = 'registered_key';
        $this->where('id', $id)->delete();

        // delete rooms_key
        $this->table = 'rooms_key';
        $this->where('id_registered_key', $id)->delete();

        // update rooms status to clean
        $this->table = 'rooms';
        $this->where('number_rooms', $re_key->id_rooms)->update(['status' => 0]);

        return true;
    }
}

/* End of file Guest_model.php */
