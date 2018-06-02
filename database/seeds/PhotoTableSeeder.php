<?php

use Illuminate\Database\Seeder;

class PhotoTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        factory(App\Photograph::class, 25)->create();
    }
}