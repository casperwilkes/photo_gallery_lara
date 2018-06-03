<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller {

    public function __construct() {
        $this->middleware('auth')
             ->except('profile');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }


    /**
     * Display either logged in user's profile, or profile of another user
     * @param null $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function profile($name = null) {
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
            'photos' => $user->photographs()->orderBy('created_at', 'desc')->paginate(4),
        );


        return view('user.profile', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        // Check user is on correct profile //
        if ($user->id !== auth()->user()->id) {
            return back()->with('error', 'You do not have authorization to access that account');
        }

        // Output data //
        $data = array(
            'user' => $user,
            'avatar' => $user->profile_fields['avatar'] === '' ? 'noimg.png' : $user->profile_fields['avatar'],
            'bio' => $user->profile_fields['bio'] !== '' ? $user->profile_fields['bio'] : 'User has not set up a bio yet',
        );

        return view('user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user) {
        $type = $request->input('form');
        $message = array(
            'status' => 'error',
            'text' => 'Invalid data detected',
        );

        if (!is_null($type)) {
            // Access profile fields //
            $profile_fields = $user->profile_fields;

            $update = false;

            switch ($type) {
                case 'bio':
                    $this->validate($request, array(
                        'bio' => 'nullable|max:1000',
                    ));

                    $field = 'Bio';
                    $profile_fields['bio'] = $request->input('bio');
                    $user->setProfileFieldsAttribute($profile_fields);
                    $update = true;

                    break;
                case 'avatar':
                    $this->validate($request, array(
                        'avatar' => 'nullable|image|mimes:jpeg,bmp,png|',
                    ));

                    // Check if they wanted empty image //
                    if (!is_null($request->avatar)) {
                        $image = $user->saveAvatar($request->avatar);
                    } else {
                        $image['name'] = '';
                    }

                    // Make sure image saved //
                    if ($image) {
                        $field = 'Avatar';
                        $profile_fields['avatar'] = $image['name'];
                        $user->setProfileFieldsAttribute($profile_fields);
                        $update = true;
                        break;
                    }

                    $message['status'] = 'error';
                    $message['text'] = 'Unable to save avatar at this time';
                    break;
                case 'email':
                    $this->validate($request, array(
                        'email' => 'required|string|email|max:255|unique:users',
                    ));

                    $field = 'Email';
                    $user->email = $request->input('email');
                    $update = true;
                    break;
                case 'password':
                    $this->validate($request, array(
                        'original' => 'required|string|min:6',
                        'password' => 'required|string|min:6|confirmed',
                    ));

                    // Check original against saved //
                    if(Hash::check($request->input('original'), $user->password)){
                        $field = 'Password';
                        // Hash the new password //
                        $user->password = Hash::make($request->input('password'));
                        $update = true;
                        break;
                    }

                    $message['status'] = 'error';
                    $message['text'] = 'Invalid Original Password';

                    break;
                default:
                    break;
            }

            // Check update was true and user was saved //
            if ($update && $user->save()) {
                $message['status'] = 'success';
                $message['text'] = "{$field} successfully saved";
            }
        }


        return back()->with($message['status'], $message['text']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        //
    }
}
