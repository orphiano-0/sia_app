<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '../vendor/autoload.php'; // Include Composer autoloader

class PostSeeder extends CI_Controller
{
    public function index()
    {
        $this->load->database();
        $faker = Faker\Factory::create();

        // Get user IDs and tag IDs (example assumes user IDs 1–10, tag IDs 1–5)
        $userIds = range(1, 10);
        $tagIds = range(1, 5);

        for ($i = 0; $i < 20; $i++) {
            $createdAt = $faker->dateTimeThisYear();
            $updatedAt = $faker->dateTimeBetween($createdAt, 'now');

            $data = [
                'user_id'        => $faker->randomElement($userIds),
                'tag_id'         => $faker->randomElement($tagIds),
                'created_At'     => $createdAt->format('Y-m-d H:i:s'),
                'updated_At'     => $updatedAt->format('Y-m-d H:i:s'),
                'content'        => $faker->text(180),
                'reaction_count' => $faker->numberBetween(0, 100),
            ];

            $this->db->insert('post', $data);
        }

        echo "20 posts inserted successfully.";
    }
}
