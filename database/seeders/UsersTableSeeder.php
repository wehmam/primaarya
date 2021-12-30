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
                "name"      => "Admin",
                "email"     => "admin@gmail.com",
                "password"  => bcrypt("admin"),
                "role"      => "admin"
            ],
            [
                "name"      => "Users",
                "email"     => "users@gmail.com",
                "password"  => bcrypt("users"),
                "role"      => "user"
            ]
        ]);
    }
}
