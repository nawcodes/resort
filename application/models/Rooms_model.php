<?php 



defined('BASEPATH') OR exit('No direct script access allowed');

class Rooms_model extends Hotel_Model {

    public $table = '';


    public function setDefaultValues() {
        return [
            'number_rooms'      => '',
            'id_type_rooms'     => '',
            'status'            => ''      
        ];
    }


    public function setRules() {
        $rules = [
            [
                'label' => 'No Kamar',
                'field' => 'number_rooms',
                'rules' => 'required|numeric|max_length[5]|callback_unique_numbers',
            ],
            [
                'label' => 'Kelas Kamar',
                'field' => 'id_type_rooms',
                'rules' => 'required',
            ],
            [
                'label' => 'Keadaan',
                'field' => 'status',
                'rules' => 'required',
            ]
        ];

        return $rules;
    }





}

/* End of file Rooms_model.php */



?>