<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Session $session
 * @property Post_model $Post_model
 * @property User_model $User_model
 */
class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

        // Check if admin is logged in
        if (!$this->session->userdata('admin_id')) {
            $this->session->set_flashdata('error', 'Please login to access the admin dashboard.');
            redirect('admin/login');
        }
    }

    public function dashboard() {
        $data['title'] = 'Admin Dashboard';
        $this->load->view('admin/partial_header', $data);
        //$this->load->view('admin/partial_sidebar');
        $this->load->view('admin/dashboard');
        //$this->load->view('admin/partial_footer');
    }

    public function post_management() {
        $data['title'] = 'Post Management';
        $this->load->view('admin/_header', $data);
        $this->load->view('admin/_sidebar');
        $this->load->view('admin/post_management');
        $this->load->view('admin/_footer');
    }

    public function user_management() {
        $data['title'] = 'User Management';
        $this->load->view('admin/_header', $data);
        $this->load->view('admin/_sidebar');
        $this->load->view('admin/user_management');
        $this->load->view('admin/_footer');
    }

    public function logout() {
        $this->session->unset_userdata('admin_id');
        $this->session->set_flashdata('success', 'You have been logged out.');
        redirect('admin/login');
    }
    public function delete_post($post_id) {
    // Load the Post model
    $this->load->model('Post_model');
    $post = $this->Post_model->get_post_by_id($post_id);

    if ($post) {
        // Delete the post
        $this->Post_model->delete_post($post_id);

        // Set success flash message
        $this->session->set_flashdata('success', 'Post deleted successfully!');
    } else {
        // If post doesn't exist
        $this->session->set_flashdata('error', 'Post not found!');
    }

    // Redirect back to the post management page
    redirect('admin/posts');
}

    public function users() {
        $this->load->model('User_model');
        $data['users'] = $this->User_model->get_all_users();
        $data['success'] = $this->session->flashdata('success');
        $data['error'] = $this->session->flashdata('error');

        $this->load->view('admin/user_management', $data);
    }

    public function delete_user($id) {
        // Call model to delete the user
        $this->load->model('User_model');
        $deleted = $this->User_model->delete_user($id);
        
        // Check if the deletion was successful
        if ($deleted) {
            // Set a success flash message
            $this->session->set_flashdata('success', 'User deleted successfully.');
        } else {
            // Set an error flash message if deletion failed
            $this->session->set_flashdata('error', 'Failed to delete user.');
        }
        
        // Redirect back to the user management page
        redirect('admin/users');
}
    public function posts()
{
    $data['title'] = 'Post Management';

    // Load all tags for the dropdown
    $tags_query = $this->db->get('Tags');
    $data['tags'] = $tags_query->result_array();

    $tag_id = $this->input->get('tag'); // Get selected tag filter from query string

    // Prepare SQL with optional tag filter
    $sql = "
        SELECT 
            p.post_id AS id,
            u.user_name AS username,
            p.content,
            GROUP_CONCAT(t.category ORDER BY t.category) AS tag_name,
            p.created_At,
            p.reaction_count
        FROM Posts p
        INNER JOIN Users u ON p.user_id = u.user_id
        LEFT JOIN Post_Tags pt ON p.post_id = pt.post_id
        LEFT JOIN Tags t ON pt.tag_id = t.tag_id
    ";

    // Add WHERE clause if tag filter is selected
    if (!empty($tag_id)) {
        $sql .= " WHERE t.tag_id = " . $this->db->escape($tag_id);
    }

    $sql .= "
        GROUP BY p.post_id, u.user_name, p.content, p.created_At, p.reaction_count
        ORDER BY p.created_At DESC
    ";

    $query = $this->db->query($sql);
    $data['posts'] = $query->result_array();

    $this->load->view('admin/post_management', $data);
}

}

