<?php




defined('BASEPATH') or exit('No direct script access allowed');

class Type_rooms extends Hotel_Controller
{

    public $email;
    public $is_login;
    public $id;
    public $id_role;


    public function __construct()
    {
        parent::__construct();
        $this->email = $this->session->userdata('email');
        $this->is_login  = $this->session->userdata('is_login');
        $this->id    = $this->session->userdata('id');
        $this->id_role = $this->session->userdata('id_role');

        if (!$this->email || $this->is_login == false || !$this->id || !$this->id_role) {
            $this->session->set_flashdata('warning', 'Login terlebih dahulu.');
            redirect(base_url('auth'));
        }
    }



    public function index()
    {
        $data['content']    =  $this->type_rooms->get();

        $data['title']      = 'Tipe Kamar / Kelas Kamar';
        $data['admin']      = 'pages/admin/type-class';
        $this->view_admin($data);
    }

    public function create()
    {

        if (!$_POST) {
            $data['input'] = (object) $this->type_rooms->setDefaultValues();
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }


        $config = [
            'allowed_types'         => 'jpg|jpeg|png',
            'max_size'              => 4048,
            'max_width'             => 0,
            'max_height'            => 0,
            'file_ext_tolower'      => true,
            'overwrite'             => true,
        ];

        $this->load->library('upload', $config);

        if (!empty($_FILES) && $_FILES['image']['name'] !== null && $_FILES['image']['name'] !== '') {
            // custom name
            $imageName = url_title($data['input']->name, '-', true) . '-image-' . $_FILES['image']['name'];
            $config['file_name'] = $imageName;
            $config['upload_path'] = './assets/images/classrooms';
            $this->upload->initialize($config);
            // check where image not eligable
            if ($this->upload->do_upload('image')) {
                // return name
                $image = $this->upload->data();

                $this->load->library('image_lib');
                // config resize
                $image_config["image_library"] = "gd2";
                $image_config["source_image"] = $image["full_path"];
                $image_config['create_thumb'] = FALSE;
                $image_config['maintain_ratio'] = TRUE;
                $image_config['new_image'] = './assets/images/image';
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
                }
                $data['input']->image =  $image['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            }
        } else {
            $data['input']->image = '';
        }



        if (!$this->type_rooms->validate()) {

            $data['form']       =  base_url('admin/type_rooms/create');
            $data['title']      = 'Tambah Tipe / Kelas Kamar';
            $data['admin']      = 'pages/admin/type-class-form.php';
            $this->view_admin($data);

            return;
        }

        $insert = [
            'name'              => strtolower($data['input']->name),
            'price_pernight'    => $data['input']->price_pernight,
            'max_person'        => $data['input']->max_person,
            'facilities'        => $data['input']->facilities,
            'twin_bed'          => $data['input']->twin_bed,
            'image'             => $data['input']->image
        ];

        if ($this->type_rooms->insert($insert)) {
            $this->session->set_flashdata('success', 'Tipe Kamar Di Tambahkan.');
        } else {
            $this->session->set_flashdata('error', 'Terjadi suatu kesalahan!');
        }


        redirect(base_url('admin/type_rooms'));
    }


    public function edit($id)
    {
        $data['content'] = $this->type_rooms->where('id', $id)->first();

        if (!$data['content']) {

            $this->session->set_flashdata('warning', 'Kelas Kamar tidak di temukan!');
            redirect(base_url('admin/type_rooms'));
        }



        if (!$_POST) {
            $data['input'] = $data['content'];
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }


        $config = [
            'allowed_types'         => 'jpg|jpeg|png',
            'max_size'              => 4048,
            'max_width'             => 0,
            'max_height'            => 0,
            'file_ext_tolower'      => true,
            'overwrite'             => true,
        ];

        $this->load->library('upload', $config);

        if (!empty($_FILES) && $_FILES['image']['name'] !== null && $_FILES['image']['name'] !== '') {
            // custom name
            $imageName = url_title($data['input']->name, '-', true) . '-image-' . $_FILES['image']['name'];
            $config['file_name'] = $imageName;
            $config['upload_path'] = './assets/images/classrooms';
            $this->upload->initialize($config);
            // check where image not eligable
            if ($this->upload->do_upload('image')) {
                // return name
                $image = $this->upload->data();

                $this->load->library('image_lib');
                // config resize
                $image_config["image_library"] = "gd2";
                $image_config["source_image"] = $image["full_path"];
                $image_config['create_thumb'] = FALSE;
                $image_config['maintain_ratio'] = TRUE;
                $image_config['new_image'] = './assets/images/image';
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
                }
                $data['input']->image =  $image['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            }
        } else {
            $data['input']->image = '';
        }



        if (!$this->type_rooms->validate()) {
            $data['title']  = 'Edit Kelas Kamar';
            $data['form']   = base_url('admin/type_rooms/edit/' . $id);
            $data['admin']  = 'pages/admin/type-class-form';
            $this->view_admin($data);
            return;
        }

        $update = [
            'name'              => strtolower($data['input']->name),
            'price_pernight'    => $data['input']->price_pernight,
            'max_person'        => $data['input']->max_person,
            'facilities'        => $data['input']->facilities,
            'twin_bed'          => $data['input']->twin_bed,
            'image'             => $data['input']->image
        ];


        if ($this->type_rooms->where('id', $data['input']->id_type_rooms)->update($update)) {
            $this->session->set_flashdata('success', 'Di simpan.');
        } else {
            $this->session->set_flashdata('warning', 'Terjadi suatu kesalahan!');
        }


        redirect(base_url('admin/type_rooms'));
    }


    public function delete($id)
    {


        if (!$_POST) {

            redirect(base_url('admin/type_rooms'), 'refresh');
        } else {
            $type = $this->type_rooms->where('id', $id)->first();

            if (!$type) {
                $this->session->set_flashdata('warning', 'Ruangan tidak ditemukan.');

                redirect(base_url('admin/type_rooms'));
            }


            if ($this->type_rooms->where('id', $this->input->post('id_type_rooms', true))->delete()) {
                $this->session->set_flashdata('success', 'Berhasil di hapus.');
            } else {
                $this->session->set_flashdata('warning', 'Terjadi suatu kesalahan!');
            }

            redirect(base_url('admin/type_rooms'));
        }
    }

    // public function unique_name()
    // {
    //     $type   = strtolower($this->input->post('name', true));
    //     $id     = $this->input->post('id_type_rooms', true);

    //     $type_rooms = $this->type_rooms->where('id', $id)->first();
    //     if ($type == $type_rooms->name) {
    //         if ($id == $type_rooms->id) {
    //             return true;
    //         }
    //         $this->load->library('form_validation');
    //         $this->form_validation->set_message('unique_name', '%s sudah ada!');
    //         return false;
    //     }

    //     return true;
    // }
}

/* End of file Type_rooms.php */
