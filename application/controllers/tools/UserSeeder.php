<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '../vendor/autoload.php'; // Load Composer autoloader

class UserSeeder extends CI_Controller
{
    public function index()
    {
        $this->load->database();
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $data = [
                'user_name'    => $faker->userName,
                'password'     => substr($faker->sha1, 0, 16), // 16-character hash
                'acct_created' => $faker->date('Y-m-d'),
            ];

            $this->db->insert('users', $data);
        }

        echo "10 users inserted successfully.";
    }
}
