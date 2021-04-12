<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Hotel_model extends CI_Model
{

    protected $table = '';
    protected $perPage = 5;


    public function __construct()
    {
        parent::__construct();
        if (!$this->table) {
            $this->table = strtolower(str_replace('_model', '', get_class($this)));
        }
    }


    /**
     * validation rules
     */


    public function validate()
    {
        $this->load->library('form_validation');

        $rules = $this->setRules();

        $this->form_validation->set_rules($rules);

        return $this->form_validation->run();
    }


    /**
     * pagination
     */

    public function paginate($page)
    {
        $this->db->limit(
            $this->perPage,
            $this->countOffset($page)
        );

        return $this;
    }


    public function countOffset($page)
    {
        if (is_null($page) || empty($page)) {
            $offset = 0;
        } else {
            $offset = ($page * $this->perPage) - $this->perPage;
        }
        return $offset;
    }

    public function makePagination($baseUrl, $uriSegment, $totalRows)
    {
        $this->load->library('pagination');

        $config = [
            'base_url'          => $baseUrl,
            'uri_segment'       => $uriSegment,
            'per_page'          => $this->perPage,
            'total_rows'        => $totalRows,
            'use_page_numbers' => true,



            // active link 
            'cur_tag_open'      => '<li class="page-item active"><a href="#" class="page-link">',
            'cur_tag_close'     => '<span class="sr-only">(current)</span></a></li>',
            // end active link 

            // num pages
            'num_tag_open'      => '<li class="page-item">',
            'num_tag_close'     => '</li>',
            // end numpages 

            // extra 
            'first_link'        => false,
            'last_link'         => false,
            // end extra


            // class    
            'attributes'        => ['class' => 'page-link'],
            // end class 

            // full tag 
            'full_tag_open'     => '<ul class="pagination">',
            'prev_tag_open'     => '<li class="page-item">',
            'prev_tag_close'    => '</li>',
            'prev_link'         => 'Previous',
            'first_tag_open'    => '<li class="page-item">',
            'first_tag_close'   => '</li>',
            'next_link'         => 'Next',
            'next_tag_open'     => '<li class="page-item">',
            'next_tag_close'    => '</li>',
            'last_tag_open'     => '<li class="page-item">',
            'last_tag_close'    => '</li>',
            'full_tag_close'    => '</ul>'
            // full tag


        ];




        $this->pagination->initialize($config);

        return $this->pagination->create_links();
    }


    /**
     * query builder : chain method
     */

    public function select($column)
    {
        $this->db->select($column);
        return $this;
    }

    public function where($column, $cond)
    {
        $this->db->where($column, $cond);
        return $this;
    }

    public function like($column, $cond)
    {
        $this->db->like($column, $cond);
        return $this;
    }

    public function orLike($column, $cond)
    {
        $this->db->or_like($column, $cond, 'both');
        return $this;
    }

    public function orderBy($column, $order = 'ASC')
    {
        $this->db->order_by($column, $order);
        return $this;
    }

    public function join($table, $set = 'left')
    {

        $this->db->join($table, "$this->table.id_$table = $table.id", $set);
        return $this;
    }


    /**
     * query builder result
     */

    public function count()
    {
        return $this->db->count_all_results($this->table);
    }

    public function get()
    {
        $query = $this->db->get($this->table)->result();
        return $query;
    }

    public function first()
    {
        $query = $this->db->get($this->table)->row();
        return $query;
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }


    public function update($data)
    {
        $query = $this->db->update($this->table, $data);
        return $query;
    }

    public function delete()
    {
        $query = $this->db->delete($this->table);
        return $query;
    }
}

/* End of file Hotel_model.php */
