<?php



defined('BASEPATH') or exit('No direct script access allowed');

class Keys_model extends Hotel_Model
{

    public $table = 'master_key';

    public function setRules()
    {
        $rules = [
            [
                'field' => 'name',
                'label' => 'Nama',
                'rules' => 'required|trim',
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

        $image_name =  $data . '-master.png';
        $params['data'] = "$data \r\n type:master";
        //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/qrcodes
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        return $image_name;
    }


    public function create($input)
    {
        if ($input == '') {
            return false;
        } else {
            // first input re_key && overide
            $this->table = 'registered_key';
            $re_key = [
                'title'     => $input->name,
                'role_key'  => 'master',
                'date_from' => '0000-00-00',
                'date_to' => '0000-00-00',
                'id_rooms' => '0',
                'id_type_rooms' => '0',
            ];
            // insert re_key and get last Id
            $id_rekey = $this->insert($re_key);

            // seccond overide master_key

            $this->table = 'rooms_key';
            $qrcode = $this->makeQrCodes($input->name);
            $rk = [
                'id_registered_key' => $id_rekey,
                'qrcode_key'        =>  $qrcode,
                'time_expired'      => '0000-00-00 00:00:00',
                'is_active'         => 1,
            ];

            $id_rooms_key = $this->insert($rk);

            // third overide master_key
            $this->table = 'master_key';

            $mas_key = [
                'name' => $input->name,
                'id_registered_key' => $id_rekey,
                'author' => $this->session->userdata('email'),
                'id_rooms_key' => $id_rooms_key
            ];

            // insert to mas_key
            $this->insert($mas_key);

            return true;
        }

        return true;
    }

    public function edit($input)
    {
        if ($input->name != '') {
            // first update name master key
            $this->table = 'master_key';
            $this->where('id', $input->id_maskey)->update(['name' => $input->name, 'author' => $this->session->userdata('id')]);

            // seccond update name on re_key
            $this->table = 'registered_key';
            $this->where('id', $input->id_rekey)->update(['title' => $input->name]);
            return true;
        } else {
            return false;
        }
        return true;
    }


    public function erase($input)
    {
        $this->table = 'master_key';
        $mk = $this->where('id', $input->id)->first();

        if (!$mk) {
            return false;
        } else {
            // first delete registered key
            $this->table = 'registered_key';
            $this->where('id', $mk->id_registered_key)->delete();

            // get image qrocdes
            $this->table = 'rooms_key';
            $rk = $this->select('qrcode_key')->where('id', $mk->id_rooms_key)->first();
            // delete image first
            deleteImage($rk->qrcode_key, 'qrcodes');
            // now delete rooms_key
            $this->where('id', $mk->id_rooms_key)->delete();

            // last delete master_key
            $this->table = 'master_key';
            $this->where('id', $input->id)->delete();
            return true;
        }

        return true;
    }
}

/* End of file Keys_model.php */
