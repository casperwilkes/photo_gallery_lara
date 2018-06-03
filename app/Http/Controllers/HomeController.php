<?php

namespace App\Http\Controllers;

use App\User;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function test() {

        return '';
    }
}
