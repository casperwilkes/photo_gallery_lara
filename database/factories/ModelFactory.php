<?php

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});

/**
 * Build out the photograph definition
 */
$factory->define(App\Photograph::class, function (Faker\Generator $faker) {
    // Build out img structure //
    build_img_structure();

    // Main storage path //
    $main = Storage::disk('public_upload');
    // Set image path //
    $img_path = $main->getAdapter()->getPathPrefix() . 'main';
    // Img faker gets //
    $img = $faker->image($img_path, 640, 480);
    // Get image base name //
    $file_name = basename($img);
    // Thumb path //
    $thumb_path = $img_path . '/thumb/' . $file_name;

    // Setup thumbnail & save //
    Image::make($img_path . '/' . $file_name)
         ->resize(200, null, function ($constrain) {
             $constrain->aspectRatio();
         })->save($thumb_path);

    return array(
        'user_id' => User::all()->random()->id,
        //'user_id' => 1,
        'filename' => $file_name,
        'type' => mime_content_type($img),
        'size' => filesize($img),
        'caption' => $faker->realText(50),
    );
});

/**
 * Comment definition
 */
$factory->define(App\Comment::class, function (\Faker\Generator $faker) {
    return array(
        'photograph_id' => \App\Photograph::all()->random()->id,
        'user_id' => User::all()->random()->id,
        'body' => $faker->realText(),
    );
});
