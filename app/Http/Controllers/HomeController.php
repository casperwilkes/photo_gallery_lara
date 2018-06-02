<?php

namespace App\Http\Controllers;

use App\User;
use Faker\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use Log;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

    }

    /**
     * Show the application main page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('home/index');
    }

    /**
     * Show user dashboards
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard() {
        // Fetch user //
        $user = User::find(auth()->user()->id);

        return view('home/dashboard', array('user' => $user));
    }

    public function test() {

        return view('home/dashboard');
    }
}
