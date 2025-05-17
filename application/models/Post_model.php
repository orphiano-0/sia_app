<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Post_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_tags()
    {
        $this->db->order_by('category', 'ASC');
        return $this->db->get('tags')->result_array();
    }

    public function get_all_posts()
    {
        $this->db->select('posts.*, users.user_name');
        $this->db->from('posts');
        $this->db->join('users', 'users.user_id = posts.user_id');
        $this->db->order_by('created_At', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_post_by_id($post_id)
    {
        // Get post details
        $this->db->select('posts.*, users.user_name');
        $this->db->from('posts');
        $this->db->join('users', 'users.user_id = posts.user_id');
        $this->db->where('posts.post_id', $post_id);
        $post = $this->db->get()->row_array();

        if ($post) {
            // Get tags for this post
            $post['tags'] = $this->get_post_tags($post_id);
        }

        return $post;
    }

    public function get_explore_posts($exclude_user_id, $limit = 30)
    {
        $this->db->select('p.*, u.user_name');
        $this->db->from('posts p');
        $this->db->join('users u', 'p.user_id = u.user_id');
        $this->db->where('p.user_id !=', $exclude_user_id);
        $this->db->order_by('p.created_At', 'DESC');
        $this->db->limit($limit);
        $posts = $this->db->get()->result_array();

        // Add tags to each post
        foreach ($posts as &$post) {
            $post['tags'] = $this->get_post_tags($post['post_id']);
        }

        return $posts;
    }

    public function update_reaction_count($post_id)
    {
        $count = $this->db->where('post_id', $post_id)
            ->from('reactions')
            ->count_all_results();

        $this->db->where('post_id', $post_id)
            ->update('posts', ['reaction_count' => $count]);
    }

    public function get_reaction_count($post_id)
    {
        return $this->db->get_where('posts', ['post_id' => $post_id])->row()->reaction_count;
    }

    public function get_posts_by_user($user_id)
    {
        $this->db->select('p.*');
        $this->db->from('posts p');
        $this->db->where('p.user_id', $user_id);
        $this->db->order_by('p.created_At', 'DESC');
        $posts = $this->db->get()->result_array();

        // Add tags to each post
        foreach ($posts as &$post) {
            $post['tags'] = $this->get_post_tags($post['post_id']);
        }

        return $posts;
    }

    public function create_post($data)
    {
        $this->db->insert('posts', $data);
        return $this->db->insert_id();
    }

    public function add_post_tags($post_id, $tag_ids)
    {
        // Remove any existing tags
        $this->db->where('post_id', $post_id)->delete('post_tags');

        // Add new tags
        $data = [];
        foreach ($tag_ids as $tag_id) {
            $data[] = [
                'post_id' => $post_id,
                'tag_id' => $tag_id
            ];
        }

        if (!empty($data)) {
            $this->db->insert_batch('post_tags', $data);
        }
    }

    public function get_post_tags($post_id)
    {
        // Validate post_id is numeric
        if (!is_numeric($post_id)) {
            return [];
        }

        // Ensure post exists
        $post_exists = $this->db->where('post_id', $post_id)
            ->from('posts')
            ->count_all_results();

        if (!$post_exists) {
            return [];
        }

        // Get tags with proper error handling
        $this->db->select('t.tag_id, t.category')
            ->from('post_tags pt')
            ->join('tags t', 'pt.tag_id = t.tag_id')
            ->where('pt.post_id', $post_id)
            ->order_by('t.category', 'ASC');  // Optional: sort tags alphabetically

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return [];  // Return empty array if no tags found
    }

    public function update_post($post_id, $data)
    {
        $this->db->where('post_id', $post_id);
        return $this->db->update('posts', $data);
    }

    public function delete_post($post_id)
    {
        // Delete from posts table (cascades to post_tags and reactions via foreign keys)
        return $this->db->delete('posts', ['post_id' => $post_id]);
    }

    public function increment_reaction_count($post_id)
    {
        $this->db->set('reaction_count', 'reaction_count+1', FALSE);
        $this->db->where('post_id', $post_id);
        return $this->db->update('posts');
    }

    // New method to get posts with their tags in a single query
    public function get_posts_with_tags($limit = null)
    {
        $this->db->select('posts.*, users.user_name, GROUP_CONCAT(tags.category) as tag_names, GROUP_CONCAT(tags.tag_id) as tag_ids');
        $this->db->from('posts');
        $this->db->join('users', 'users.user_id = posts.user_id');
        $this->db->join('post_tags', 'post_tags.post_id = posts.post_id', 'left');
        $this->db->join('tags', 'tags.tag_id = post_tags.tag_id', 'left');
        $this->db->group_by('posts.post_id');
        $this->db->order_by('posts.created_At', 'DESC');

        if ($limit) {
            $this->db->limit($limit);
        }

        return $this->db->get()->result_array();
    }
}