<?php

/**
 * Seeder file to add photos to the database.
 *
 * @author Casper Wilkes <casper@casperwilkes.net>
 */

use Illuminate\Database\Seeder;

class PhotoTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        factory(App\Photograph::class, 70)->create();
    }
}
