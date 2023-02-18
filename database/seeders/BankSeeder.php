<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banks')->insert([
            'created_at'    => date('Y-m-d H:i:s'),
            'name'          => 'BCA'
        ]);

        DB::table('banks')->insert([
            'created_at'    => date('Y-m-d H:i:s'),
            'name'          => 'BNI'
        ]);

        DB::table('banks')->insert([
            'created_at'    => date('Y-m-d H:i:s'),
            'name'          => 'Bank Mandiri'
        ]);
    }
}
