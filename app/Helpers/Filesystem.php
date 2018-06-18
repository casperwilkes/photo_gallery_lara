<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

if (!function_exists('build_img_structure')) {

    /**
     * Rapidly build out the public directory structure
     */
    function build_img_structure() {
        // Get the public upload disk
        $main = Storage::disk('public_upload');
        $main_root = $main->getAdapter()->getPathPrefix();
        $resource_root = resource_path('img/');

        // Check if exists, try to create, then check again //
        if (!is_dir($main_root) && !mkdir($main_root, 0755) && !is_dir($main_root)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $main_root));
        }

        // Build out main image directory //
        if (!$main->exists('main')) {
            // Setup paths //
            $main_path = $main_root . 'main/';
            $r_main_path = $resource_root . 'main/';

            File::copyDirectory($r_main_path, $main_path);
        }

        // Build out avatar directory //
        if (!$main->exists('avatar')) {
            $avatar_path = $main_root . 'avatar/';
            $r_avatar_path = $resource_root . 'avatar/';
            File::copyDirectory($r_avatar_path, $avatar_path);
        }
    }
}