<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'username' => 'ADMIN_IPMUGO',
            'firstname' => 'ADMIN',
            'lastname' => 'IPMUGO',
            'email' => 'adm_ipmugo@gmail.com',
            'password' => bcrypt('123456'),
            'interest' => '',
            'affiliation' => 'IAES',
            'country' => 'Indonesia',
        ]);
    
        $role = Role::create(['name' => 'Administrator']);
     
        $user->assignRole([$role->name]);

        $user = User::create([
            'username' => 'CS_IPMUGO',
            'firstname' => 'CS',
            'lastname' => 'IPMUGO',
            'email' => 'cs_ipmugo@gmail.com',
            'password' => bcrypt('123456'),
            'interest' => '',
            'affiliation' => 'IAES',
            'country' => 'Indonesia',
        ]);
    
        $role = Role::create(['name' => 'Assistent']);
     
        $user->assignRole([$role->name]);

        $user = User::create([
            'username' => 'CS_Reader',
            'firstname' => 'CS',
            'lastname' => 'Reader',
            'email' => 'cs_reader@gmail.com',
            'password' => bcrypt('123456'),
            'interest' => '',
            'affiliation' => 'IAES',
            'country' => 'Indonesia',
        ]);
    
        $role = Role::create(['name' => 'Reader']);
     
        $user->assignRole([$role->name]);
    }
}
