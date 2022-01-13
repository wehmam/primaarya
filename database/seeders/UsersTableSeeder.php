<?php

namespace Database\Seeders;

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
        DB::table("users")->insert([
            [
                "name"      => "Users",
                "email"     => "users@gmail.com",
                "password"  => bcrypt("users"),
            ]
        ]);
        DB::table("admin_users")->insert([
            [
                "email"         => "admin@gmail.com",
                "password"      => '$2y$10$V.E2.gEMCMMDvcBvc8uvUuvGJS1IPoPOHOFfZnCvgeugToEVZ2QRG',
                "last_login"    => "2022-01-10 04:00:24",
                "first_name"    => "Super",
                "last_name"     => "Admin",
            ]
        ]);
        DB::table("activations")->insert([
            [
                "user_id"       => 1,
                "code"          => "4b4f811235face81f341835d250994b8",
                "completed"     => 1,
                "completed_at"  => "2022-01-05 05:25:38"
            ]
        ]);
    }
}
