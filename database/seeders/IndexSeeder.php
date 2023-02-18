<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class IndexSeeder extends Seeder
{
    public function run()
    {
        $data   = [
            'name' => 'Admin'
        ];

        $admin = Role::create($data);

        $data   = [
            'name' => 'Member'
        ];

        $member = Role::create($data);

        $data   = [
            'email'         => 'admin@mail.com',
            'name'          => 'Admin',
            'password'      => Hash::make('12345678')
        ];

        $user   = User::create($data);

        $user->syncRoles($admin);

        $data   = [
            'email'         => 'member@mail.com',
            'name'          => 'Member',
            'password'      => Hash::make('12345678')
        ];

        $user   = User::create($data);

        $user->syncRoles($member);

        DB::table('user_details')->insert([
            'created_at'    => date('Y-m-d H:i:s'),
            'phone'         => generatePhoneNumber(),
            'uid'           => generateUid(),
            'user_id'       => $user->id,
        ]);
    }
}
