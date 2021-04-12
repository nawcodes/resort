<?php 


defined('BASEPATH') OR exit('No direct script access allowed');

class Type_rooms_model extends Hotel_Model {

    public $table = '';


    public function setDefaultValues() {
        return [
            'name'              => '',
            'price_pernight'    => '',
            'max_person'        => '',
            'facilities'        => '',
            'twin_bed'          => '',
        ];
    }

    public function setRules() {
        $rules = [
            [
                'field' => 'name',
                'label' => 'Nama Kelas',
                'rules' => 'required|trim|max_length[50]',
            ],
            [
                'field' => 'price_pernight',
                'label' => 'Harga Permalam',
                'rules' => 'required|numeric',
            ],
            [
                'field' => 'max_person',
                'label' => 'Maksimal Orang',
                'rules' => 'required|numeric|max_length[2]',
            ],
            [
                'field' => 'facilities',
                'label' => 'Fasilitas',
                'rules' => 'trim',
            ],
            [
                'field' => 'twin_bed',
                'label' => 'Twin Bed',
                'rules' => 'required',
            ]
        ];

        return $rules;
    }


    

}

/* End of file Type_rooms_model.php */
