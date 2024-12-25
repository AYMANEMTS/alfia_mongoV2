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
            for ($i = 0; $i < 70; $i++) {
                DB::connection('mongodb')->table($collection)->insert([
                    'fullName' => $faker->name,
                    'tel' => $faker->phoneNumber,
                    'email' => $faker->email,
                    'age' => $faker->numberBetween(18, 60),
                    'city' => $faker->city,
                    'job' => $faker->jobTitle, // Job title
                    'nameproject' => $faker->words(3, true), // Random project name
                    'ideaproject' => $faker->sentence, // Random sentence for project idea
                    'gender' => $faker->randomElement(['male', 'female']),
                    'createdAt' => $faker->dateTimeBetween('01-01-' . date('Y'), '31-12-' . date('Y')), // Random date within the current year
                ]);
            }
        }

        $this->command->info('Fake data seeded successfully!');
    }
}
