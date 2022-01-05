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
                "email"     => "admin@gmail.com",
                "password"  => bcrypt("admin"),
                "first_name"     => "Super",
                "last_name"      => "Admin",
            ]
        ]);
    }
}
