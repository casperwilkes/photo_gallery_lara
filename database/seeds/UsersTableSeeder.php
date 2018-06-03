<?php

use Carbon\Carbon;
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
        $profile_fields = array('bio' => '', 'avatar' => '');
        // Encrypted profile_fields //
        $pfe = encrypt($profile_fields);
        // For seeding purposes only //
        $password = bcrypt('password');
        $date = Carbon::now();

        // Generate main testing //
        User::insert(
            array(
                array(
                    'name' => 'admin',
                    'email' => 'admin@admin.com',
                    'password' => $password,
                    'profile_fields' => $pfe,
                    'remember_token' => str_random(10),
                    'created_at' => $date,
                    'updated_at' => $date,
                ),
                array(
                    'name' => 'wendy',
                    'email' => 'wendy@wendys.com',
                    'password' => $password,
                    'profile_fields' => $pfe,
                    'remember_token' => str_random(10),
                    'created_at' => $date,
                    'updated_at' => $date,
                ),
                array(
                    'name' => 'dave',
                    'email' => 'dave@wendys.com',
                    'password' => $password,
                    'profile_fields' => $pfe,
                    'remember_token' => str_random(10),
                    'created_at' => $date,
                    'updated_at' => $date,
                ),
            )
        );

        // Generate fakes //
        factory(App\User::class, 70)
            ->create(
                array(
                    'profile_fields' => $profile_fields,
                )
            );
    }
}
