<?php

namespace App\Http\Controllers;

use App\User;
use Faker\Factory;
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

    /**
     * Show user dashboards
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard($name = null) {
        // If name is empty and user not logged in //
        if (is_null($name) && !Auth::check()) {
            //return redirect('home')->with('warning', 'User not detected');
            return back()->with('warning', 'User not detected');
        }

        // Get logged in user //
        if (is_null($name) && Auth::check()) {
            $user = User::find(auth()->user()->id);
        } else {

            // Get searched user //
            //$user = User::where('name', $name)->firstOrFail();
            try {
                $user = User::where('name', $name)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                //return redirect('home')->with('error', 'Could not find user');
                return back()->with('error', 'Could not locate requested user');
            }

        }

        // Output data //
        $data = array(
            'user' => $user,
            'avatar' => $user->profile_fields['avatar'] === '' ? 'noimg.png' : $user->profile_fields['avatar'],
            'bio' => $user->profile_fields['bio'] !== '' ? $user->profile_fields['bio'] : 'User has not set up a bio yet',
        );

        return view('home/dashboard', $data);
    }

    public function test() {

        return '';
    }
}
