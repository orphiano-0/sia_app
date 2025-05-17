<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Form_validation $form_validation
 * @property CI_Session $session
 * @property CI_Input $input
 * @property Admin_model $Admin_model
 */
class admin_auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
    }

    public function login() {
    $this->form_validation->set_rules('name', 'Admin Name', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

    $data = [
        'error' => $this->session->flashdata('error'),
        'validation_errors' => validation_errors('<p style="color:red;">', '</p>')
    ];

    if ($this->form_validation->run() == FALSE) {
        $this->load->view('admin/login', $data);
    } else {
        $name = $this->input->post('name');
        $password = $this->input->post('password');

        $admin = $this->Admin_model->get_admin_by_name($name);

        if ($admin && password_verify($password, $admin->password)) {
            $this->session->set_userdata('admin_id', $admin->admin_id);
            redirect('admin/dashboard');
        } else {
            $this->session->set_flashdata('error', 'Invalid login credentials');
            redirect('adminauth/login');
        }
    }
}

    public function logout() {
        $this->session->unset_userdata('admin_id');
        redirect('adminauth/login');
    }
}
