<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

use Log;

class HomeController extends Controller {

    /**
     * Show the application main page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('home/index');
    }

    /**
     * About page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about() {
        // Get about file data //
        $about = File::get(resource_path('internals/about.md'));

        $data = array(
            'about' => $about,
        );

        return view('home/about', $data);
    }

    /**
     * Privacy policy page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function privacy() {
        // Get privacy policy data //
        $policy = File::get(resource_path('internals/privacy.md'));

        $data = array(
            'policy' => $policy,
        );

        return view('home/privacy', $data);
    }

    /**
     * Terms and conditions page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function terms() {
        $terms = File::get(resource_path('internals/terms.md'));
        $data = array(
            'terms' => $terms,
        );

        return view('home/terms', $data);
    }

    /**
     * FAQ page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function faq() {
        $faq = File::get(resource_path('internals/faq.md'));

        $data = array(
            'faq' => $faq,
        );

        return view('home/faq', $data);
    }

    public function test() {

        return '';
    }
}
