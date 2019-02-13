<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            ['name' => 'aliuwahab',
                'password' => bcrypt('secret'),
                'email' => 'aliuwahab@gmail.com',
                'email_verified_at' => \Carbon\Carbon::parse('-1 week'),
            ]
        );
    }
}
