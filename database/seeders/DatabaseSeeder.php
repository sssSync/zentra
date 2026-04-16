<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            CompaniesTableSeeder::class,
            ContactsTableSeeder::class,
            AppointmentsTableSeeder::class,
            InteractionsTableSeeder::class,
            TasksTableSeeder::class,
            DealsTableSeeder::class,
        ]);
    }
}
