<?php

use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UsersProfileSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Factory::create();

        $iteration = 30;
        $users = User::all()->random($iteration);

        // Main storage path //
        $main = Storage::disk('public_upload');
        // Set image path //
        $img_path = $main->getAdapter()->getPathPrefix() . 'avatar';

        // Loop through users //
        foreach ($users as $user) {
            // Img faker gets //
            $img = $faker->image($img_path);
            // Get image base name //
            $file_name = basename($img);
            // Thumb path //
            $thumb_path = $img_path . '/thumb/' . $file_name;

            // Setup thumbnail & save //
            Image::make($img_path . '/' . $file_name)
                 ->resize(200, null, function ($constrain) {
                     $constrain->aspectRatio();
                 })->save($thumb_path);


            // Get user fields //
            $fields = $user->profile_fields;
            // Set fields //
            $fields['bio'] = $faker->realText();
            $fields['avatar'] = $file_name;
            $user->setProfileFieldsAttribute($fields);

            // Save the fields //
            $user->save();
        }
    }
}
