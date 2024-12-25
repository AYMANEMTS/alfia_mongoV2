<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class FakeDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $collections = ['formations', 'participants', 'accompagnment'];

        foreach ($collections as $collection) {
            // Insert 50 fake records into each collection
            for ($i = 0; $i < 60; $i++) {
                DB::connection('mongodb')->table($collection)->insert([
                    'fullName' => $faker->name, // Full name for participants
                    'tel' => $faker->phoneNumber, // Generate a phone number
                    'email' => $faker->email, // Generate a valid email address
                    'age' => $faker->numberBetween(18, 60), // Age between 18 and 60
                    'city' => $faker->city, // Random city name
                    'job' => $faker->jobTitle, // Job title
                    'nameproject' => $faker->words(3, true), // Random project name
                    'ideaproject' => $faker->sentence, // Random sentence for project idea
                    'createdAt' => $faker->dateTimeBetween('2022-01-01', '2024-12-31'), // Random date between 2022-01-01 and 2024-12-31
                ]);
            }
        }

        $this->command->info('Fake data seeded successfully!');
    }
}
