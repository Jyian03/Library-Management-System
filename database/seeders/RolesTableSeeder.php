<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'librarian',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'member',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
