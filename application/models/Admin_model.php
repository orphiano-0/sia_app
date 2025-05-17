<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

// class Admin_model extends CI_Model {

//     public function get_admin_by_name($name) {
//         $query = $this->db->get_where('Admin', ['name' => $name]);
//         return $query->num_rows() > 0 ? $query->row() : false;
//     }

//     public function insert_admin($data) {
//         return $this->db->insert('Admin', $data);
//     }
// }

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_admin($name) {
        $query = $this->db->get_where('Admin', ['name' => $name]);
        return $query->row();
    }
}