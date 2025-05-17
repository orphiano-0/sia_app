<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property Post_model $Post_model
 * @property Tag_model $Tag_model
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_DB $db
 */
class Posts extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Post_model');
        $this->load->model('Tag_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }

    public function index() {
        $data['posts'] = $this->Post_model->get_all_posts();
        $this->load->view('posts/index', $data);
    }

    public function view($id) {
        $data['post'] = $this->Post_model->get_post_by_id($id);
        $this->load->view('posts/view', $data);
    }

    public function create() {
        $this->form_validation->set_rules('content', 'Content', 'required|max_length[180]');
        $this->form_validation->set_rules('category', 'Category', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('posts/create');
        } else {
            $post_data = [
                'user_id' => 1, // Replace with session user_id later
                'content' => $this->input->post('content'),
                'reaction_count' => 0
            ];
            $post_id = $this->Post_model->create_post($post_data);

            $tag_data = [
                'post_id' => $post_id,
                'category' => $this->input->post('category')
            ];
            $this->Tag_model->create_tag($tag_data);

            redirect('posts');
        }
    }
}
