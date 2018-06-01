<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $profile_fields = encrypt(array('bio' => '', 'avatar' => ''));

        User::insert(
            array(
                array(
                    'name' => 'admin',
                    'email' => 'admin@admin.com',
                    'password' => 'password',
                    'profile_fields' => $profile_fields,
                ),
                array(
                    'name' => 'wendy',
                    'email' => 'wendy@wendys.com',
                    'password' => 'password',
                    'profile_fields' => $profile_fields,
                ),
                array(
                    'name' => 'dave',
                    'email' => 'dave@wendys.com',
                    'password' => 'password',
                    'profile_fields' => $profile_fields,
                ),
            )
        );
    }
}
