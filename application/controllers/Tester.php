<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tester extends CI_Controller
{
    public function index()
    {
        $this->load->view('tester_landing');
    }
}