<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Session $session
 * @property User_model $User_model
 */
class UserController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load necessary models
        $this->load->model('User_model');
    }

    // List all users
    public function index() {
        // Fetch all users from the model
        $data['users'] = $this->User_model->get_all_users();
        
        // Load the user management view
        $this->load->view('admin/user_management', $data);
    }

    // Delete a user by ID
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
}
