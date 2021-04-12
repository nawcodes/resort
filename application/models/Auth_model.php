<?php



defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends Hotel_Model
{

    public $table = 'user';

    public function setDefaultValues()
    {
        return [
            'account_id'    => '',
            'phone'         => '',
        ];
    }


    public function setRules()
    {
        $rules  = [
            [
                'field' => 'account_id',
                'label' => 'No Ktp',
                'rules' => 'required|numeric',
            ],
            [
                'field' => 'phone',
                'label' => 'No Hp',
                'rules' => 'required|numeric',
            ]
        ];

        return $rules;
    }
}

/* End of file Auth_model.php */
