<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_user($username)
    {
        // Also return as array
        return $this->db->get_where('users', ['user_name' => $username])->row();
    }

    public function get_user_by_username($username)
    {
        return $this->db->get_where('users', ['user_name' => $username])->row_array();
    }

    // Insert new user
    public function insert_user($data)
    {
        return $this->db->insert('Users', $data);
    }

    public function update_user($user_id, $data)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->update('Users', $data);
    }

    public function get_user_by_id($user_id)
    {
        // Return as array for consistency
        return $this->db->get_where('users', ['user_id' => $user_id])->row_array();
    }

    public function get_all_users()
    {
        return $this->db->get('users')->result_array();
    }

    public function delete_user($user_id)
    {
        // First check if user exists
        $user = $this->get_user_by_id($user_id);
        if (!$user) {
            return false;
        }

        $this->db->where('user_id', $user_id);
        return $this->db->delete('users');
    }
}
