<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('build_img_structure')) {

    /**
     * Rapidly build out the public directory structure
     */
    function build_img_structure() {
        // Get the public upload disk
        $main = Storage::disk('public_upload');

        // Build out directories  //
        if (!$main->exists('main')) {
            $main->makeDirectory('main');
        }
        if (!$main->exists('main/thumb')) {
            $main->makeDirectory('main/thumb');
        }

        // Build out index files //
        if (!$main->exists('main/index.html')) {
            $main->put('main/index.html', '');
        }
        if (!$main->exists('main/thumb/index.html')) {
            $main->put('main/thumb/index.html', '');
        }
    }
}