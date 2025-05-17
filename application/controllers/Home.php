<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Post_model');
        $this->load->model('User_model');
        $this->load->model('Tag_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        // Get current user from session (replace with your actual session handling)
        $user_id = $this->session->userdata('user_id');
        
        if (!$user_id) {
            redirect('auth/login');
        }

        // Get current user data
        $user = $this->User_model->get_user_by_id($user_id);
        
        // Get posts for this user with their tags
        $data['posts'] = $this->Post_model->get_posts_by_user($user_id);
        
        // Add tags to each post
        foreach ($data['posts'] as &$post) {
            $post['tags'] = $this->Post_model->get_post_tags($post['post_id']);
        }

        // Common data for header
        $data['tags'] = $this->Tag_model->get_all_tags();
        $data['page_title'] = $user['user_name'] . '\'s Posts';
        $data['username'] = $user['user_name'];
        $data['active_tab'] = 'home';

        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('landing/home/create_post', $data);
        $this->load->view('landing/home_page', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        // Check if user is logged in
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('auth/login');
        }

        // Get user data
        $user = $this->User_model->get_user_by_id($user_id);
        
        // Get all available tags for the dropdown
        $data['tags'] = $this->Tag_model->get_all_tags();
        $data['username'] = $user['user_name'];
        $data['active_tab'] = 'home';

        // Set validation rules
        $this->form_validation->set_rules('content', 'Content', 'required|max_length[180]');
        $this->form_validation->set_rules('tags', 'Tags', 'callback_validate_tags');

        if ($this->form_validation->run() === FALSE) {
            // If validation fails, reload the page with errors
            $this->load->view('templates/header', $data);
            $this->load->view('landing/home/create_post', $data);
            $this->load->view('templates/footer');
        } else {
            // Prepare post data
            $post_data = array(
                'user_id' => $user_id,
                'content' => $this->input->post('content'),
                'created_At' => date('Y-m-d H:i:s')
            );

            // Create the post
            $post_id = $this->Post_model->create_post($post_data);

            // Handle tags if provided
            $tags = $this->input->post('tags');
            if (!empty($tags)) {
                $tag_ids = explode(',', $tags);
                $this->Post_model->add_post_tags($post_id, $tag_ids);
            }

            // Redirect to home page
            redirect('home');
        }
    }

    // Custom validation callback for tags
    public function validate_tags($tags)
    {
        if (empty($tags)) {
            return true; // Tags are optional
        }

        $tag_ids = explode(',', $tags);

        // Validate maximum 3 tags
        if (count($tag_ids) > 3) {
            $this->form_validation->set_message('validate_tags', 'You can select maximum 3 tags');
            return false;
        }

        // Validate all tag IDs exist
        foreach ($tag_ids as $tag_id) {
            if (!$this->Tag_model->tag_exists($tag_id)) {
                $this->form_validation->set_message('validate_tags', 'One or more selected tags are invalid');
                return false;
            }
        }

        return true;
    }
}