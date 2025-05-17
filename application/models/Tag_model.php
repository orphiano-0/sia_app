<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tag_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function create_tag($data)
    {
        return $this->db->insert('tags', $data);
    }

    public function get_all_tags()
    {
        $this->db->order_by('category', 'ASC'); // Optional: sorts tags alphabetically
        return $this->db->get('tags')->result_array();
        // Returns array like: 
        // [
        //    ['tag_id' => 1, 'category' => 'Travel'],
        //    ['tag_id' => 2, 'category' => 'Food'],
        //    ...
        // ]
    }

    // Checks if a tag exists (for validation)
    public function tag_exists($tag_id)
    {
        return $this->db->where('tag_id', $tag_id)
            ->from('Tags')
            ->count_all_results() > 0;
    }

    public function get_or_create_tag($category)
    {
        // Check if tag exists
        $tag = $this->db->get_where('Tags', array('category' => $category))->row_array();

        if ($tag) {
            return $tag['tag_id'];
        } else {
            // Create new tag
            $this->db->insert('Tags', array('category' => $category));
            return $this->db->insert_id();
        }

    }
}
