<?php

/**
 * Calls on seed files to fill database with mock data.
 *
 * @author Casper Wilkes <casper@casperwilkes.net>
 */

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->call(UsersTableSeeder::class);
        $this->call(UsersProfileSeeder::class);
        $this->call(PhotoTableSeeder::class);
        $this->call(CommentTableSeeder::class);
    }
}
