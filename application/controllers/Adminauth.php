<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Session $session
 * @property Admin_model $Admin_model
 */
class Adminauth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
    }

    public function login() {
        $this->form_validation->set_rules('name', 'Admin Name', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['error'] = validation_errors();
            $this->load->view('auth/admin_login', $data);
        } else {
            $name = $this->input->post('name');
            $password = $this->input->post('password');

            $admin = $this->Admin_model->get_admin($name);

            if ($admin && password_verify($password, $admin->password)) {
                // Login successful
                $this->session->set_userdata('admin_id', $admin->admin_id);
                $data['success'] = 'Admin login successful! Redirecting to dashboard...';
                $this->load->view('auth/admin_login', $data);
                header('Refresh: 2;url=' . site_url('admin/dashboard'));
            } else {
                // Login failed
                $this->session->set_flashdata('error', 'Invalid admin name or password.');
                redirect('admin/login');
            }
        }
    }

    public function logout() {
        $this->session->unset_userdata('admin_id');
        $this->session->set_flashdata('success', 'Logged out successfully.');
        redirect('admin/login');
    }
}