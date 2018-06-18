<?php

/**
 * Seeder file to add user comments on photos to the database.
 *
 * @author Casper Wilkes <casper@casperwilkes.net>
 */

use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(App\Comment::class, 100)->create();
    }
}
