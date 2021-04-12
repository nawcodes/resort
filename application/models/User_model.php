<?php



defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends Hotel_Model
{

    public $table = 'user';

    public function setDefaultValues()
    {
        return [
            'name'         => '',
            'email'        => '',
            'email_pass'   => '',
            'is_active'    => 0,
            'role'         => ''
        ];
    }

    public function setRules()
    {
        $rules = [
            [
                'field' => 'name',
                'label' => 'Nama',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'email',
                'label' => 'E-mail',
                'rules' => 'required|valid_email|callback_unique_email'
            ],
            [
                'field' => 'id_role',
                'label' => 'Role',
                'rules' => 'required'
            ],
            [
                'field' => 'is_active',
                'label' => 'Apakah Aktif ?',
                'rules' => 'required'
            ]
        ];
        return $rules;
    }


    public function uploadImage($field, $imageName)
    {
        $config = [
            'upload_path'        => './assets/images/user/',
            'allowed_types'      => 'jpg|png|jpeg|gif|JPG|JPEG|',
            'max_size'           => 1024,
            'max_width'          => 0,
            'max_height'         => 0,
            'file_name'          => $imageName,
            'overwrite'          => true,
            'file_ext_tolower'   => true,
        ];

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload($field)) {
            return $this->upload->data();
        } else {
            return $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
        }
    }
}

/* End of file User_model.php */
