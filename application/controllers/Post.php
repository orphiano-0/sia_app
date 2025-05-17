<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Post extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Post_model');
        $this->load->model('Tag_model');
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

    private function check_login()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    public function create()
    {
        $this->check_login();
        $user_id = $this->session->userdata('user_id');
        $user = $this->User_model->get_user_by_id($user_id);

        // Get all available tags for the dropdown
        $data['tags'] = $this->Tag_model->get_all_tags();
        $data['username'] = $user['user_name'];
        $data['active_tab'] = 'home';

        // Set validation rules
        $this->form_validation->set_rules('content', 'Content', 'required|max_length[180]');
        $this->form_validation->set_rules('tags', 'Tags', 'callback_validate_tags');

        if ($this->form_validation->run() === FALSE) {
            // Reload with errors
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

            // Redirect to home page to refresh stuffs
            redirect('home');
        }
    }

    // Custom validation callback for tags
    // THis is to ensure that before we send the data to the database,
    // the tags are only 3, and exists in the database.
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


    public function like()
    {
        // Verify AJAX request
        if (!$this->input->is_ajax_request()) {
            return $this->output
                ->set_status_header(403)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Direct access not allowed'
                ]));
        }

        // Verify logged in
        if (!$user_id = $this->session->userdata('user_id')) {
            return $this->output
                ->set_status_header(401)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Please login first'
                ]));
        }

        $post_id = $this->input->post('post_id');

        try {
            // Check if like exists
            $existing = $this->db->get_where('reactions', [
                'post_id' => $post_id,
                'user_id' => $user_id
            ])->row();

            if ($existing) {
                // Unlike
                $this->db->where([
                    'post_id' => $post_id,
                    'user_id' => $user_id
                ])->delete('reactions');
                $action = 'unliked';
            } else {
                // Like
                $this->db->insert('reactions', [
                    'post_id' => $post_id,
                    'user_id' => $user_id,
                    'reaction' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                $action = 'liked';
            }

            // Get updated count
            $count = $this->db->where('post_id', $post_id)
                ->from('reactions')
                ->count_all_results();

            // Update post count
            $this->db->where('post_id', $post_id)
                ->update('posts', ['reaction_count' => $count]);

            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'new_count' => $count,
                    'action' => $action
                ]));

        } catch (Exception $e) {
            return $this->output
                ->set_status_header(500)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Server error: ' . $e->getMessage()
                ]));
        }
    }

    public function edit($post_id)
    {
        // Check if user is logged in
        if (!$user_id = $this->session->userdata('user_id')) {
            redirect('auth/login');
        }

        // Load models
        $this->load->model('Post_model');
        $this->load->model('Tag_model');

        // Get the post
        $post = $this->Post_model->get_post_by_id($post_id);

        // Verify post exists and belongs to user
        if (!$post || $post['user_id'] != $user_id) {
            show_error('You are not authorized to edit this post', 403);
        }

        // Get all available tags
        $data['tags'] = $this->Tag_model->get_all_tags();
        $data['post'] = $post;
        $data['post_tags'] = $this->Post_model->get_post_tags($post_id);

        // Load the edit form view
        $this->load->view('landing/home/edit_post', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        // Check if user is logged in
        if (!$user_id = $this->session->userdata('user_id')) {
            redirect('auth/login');
        }

        $post_id = $this->input->post('post_id');

        // Verify post exists and belongs to user
        $post = $this->Post_model->get_post_by_id($post_id);
        if (!$post || $post['user_id'] != $user_id) {
            show_error('You are not authorized to edit this post', 403);
        }

        // Load models
        $this->load->model('Post_model');
        $this->load->model('Tag_model');
        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('content', 'Content', 'required|max_length[180]');
        $this->form_validation->set_rules('tags', 'Tags', 'callback_validate_tags');

        if ($this->form_validation->run() === FALSE) {
            // Reload edit form with errors
            $this->edit($post_id);
        } else {
            // Prepare updated post data
            $post_data = array(
                'content' => $this->input->post('content'),
                'updated_At' => date('Y-m-d H:i:s')
            );

            // Update the post
            $this->Post_model->update_post($post_id, $post_data);

            // Handle tags
            $tags = $this->input->post('tags');
            $tag_ids = !empty($tags) ? explode(',', $tags) : [];
            $this->Post_model->add_post_tags($post_id, $tag_ids);

            // Redirect to home page with success message
            $this->session->set_flashdata('success', 'Post updated successfully');
            redirect('home');
        }
    }
    public function delete()
    {
        $this->check_login();

        $post_id = $this->input->post('post_id');
        $user_id = $this->session->userdata('user_id');

        // Verify post exists and belongs to user
        $post = $this->Post_model->get_post_by_id($post_id);

        if (!$post || $post['user_id'] != $user_id) {
            echo json_encode(['success' => false, 'message' => 'Post not found or not owned by user']);
            return;
        }

        // Delete the post
        if ($this->Post_model->delete_post($post_id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
    }

}