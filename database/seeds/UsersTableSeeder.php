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
        // Default profile fields //
        $profile_fields = encrypt(array('bio' => '', 'avatar' => ''));
        // For seeding purposes only //
        $password = bcrypt('password');

        // Generate main testing //
        User::insert(
            array(
                array(
                    'name' => 'admin',
                    'email' => 'admin@admin.com',
                    'password' => $password,
                    'profile_fields' => $profile_fields,
                ),
                array(
                    'name' => 'wendy',
                    'email' => 'wendy@wendys.com',
                    'password' => $password,
                    'profile_fields' => $profile_fields,
                ),
                array(
                    'name' => 'dave',
                    'email' => 'dave@wendys.com',
                    'password' => $password,
                    'profile_fields' => $profile_fields,
                ),
            )
        );

        // Generate fakes //
        factory(App\User::class, 50)
            ->create(
                array(
                    'password' => $password,
                    'profile_fields' => $profile_fields,
                )
            );
    }
}
