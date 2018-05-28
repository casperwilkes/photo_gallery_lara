<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

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
        return view('home/dashboard');
    }
}
