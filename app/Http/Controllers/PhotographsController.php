<?php

namespace App\Http\Controllers;

use App\Photograph;
use Illuminate\Http\Request;

use Illuminate\Session\Store;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;
use Log;

class PhotographsController extends Controller {

    public function __construct() {
        $this->middleware('auth')
             ->except(array('index', 'show',));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        // Get collection of photos //
        $photos = Photograph::orderBy('created_at', 'desc')->paginate(4);

        return view('photographs.index', array('photos' => $photos));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('photographs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // Validate incoming request //
        $this->validate($request, array(
            'image' => 'required|image|mimes:jpeg,bmp,png|',
            'caption' => 'required|max:191|min:5',
        ));

        // Return message //
        $message = array(
            'status' => 'error',
            'text' => 'Unable to save your photograph at this time, try again later.',
        );

        // If new image created, will contain id for redirect //
        $new = '';

        // Get user //
        $user = auth()->user()->id;

        // Attempt to Save the image //
        $path = $request->image->store('main', 'public_upload');

        // Check valid path //
        if ($path) {
            // Get file name //
            $file_name = basename($path);

            // Setup image path for uploading //
            $img_path = config('filesystems.disks.public_upload.root') . '/main/';

            // Thumb path //
            $thumb_path = $img_path . 'thumb/' . $file_name;

            // Setup thumbnail & save //
            $thumb = Image::make($img_path . $file_name)
                          ->resize(200, null, function ($constrain) {
                              $constrain->aspectRatio();
                          })->save($thumb_path);

            // Check we got back a valid instance //
            if ($thumb) {
                // Get file object //
                $file = $request->file('image');

                // Instantiate a new photograph //
                $photo = new Photograph();

                // Set values //
                $photo->user_id = $user;
                $photo->filename = $file_name;
                $photo->type = $file->getClientMimeType();
                $photo->size = $file->getSize();
                $photo->caption = $request->input('caption');

                // Save the photo //
                if ($photo->save()) {
                    $message['status'] = 'success';
                    $message['text'] = 'Your photograph was successfully uploaded';
                    $new = '/' . $photo->id;

                    Log::info('User uploaded a new photo', array('User' => $user, 'photo' => $photo->id));
                } else {
                    Log::error('Unable to save photograph', array('User' => $user, 'request' => $request->all()));
                }
            } else {
                Log::error('Unable to save image thumb', array(
                    'User' => $user->id,
                    'image_path' => $img_path . $file_name,
                    'thumb_path' => $thumb_path,
                ));
            }
        } else {
            Log::error('Unable to save image path', array('User' => $user->id, 'Image_Path' => $path));
        }

        // Redirect to new photo //
        return redirect("/photographs{$new}")->with($message['status'], $message['text']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Photograph $photograph
     * @return \Illuminate\Http\Response
     */
    public function show(Photograph $photograph) {
        // Display the photo //
        return view('photographs.show', array('photo' => $photograph));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Photograph $photograph
     * @return \Illuminate\Http\Response
     */
    public function edit(Photograph $photograph) {
        // Check access //
        if (auth()->user()->id !== $photograph->user_id) {
            return redirect('/photographs')->with('error', 'Unauthorized access');
        }

        // Display the view //
        return view('photographs.edit', array('photo' => $photograph));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Photograph $photograph
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photograph $photograph) {
        // Check access //
        if (auth()->user()->id !== $photograph->user_id) {
            return redirect('/photographs')->with('error', 'Unauthorized access');
        }

        // Validate rules | Shared with create //
        $this->validate($request, array(
            'caption' => 'required|max:191|min:5',
        ));

        // Get user //
        $user = auth()->user();

        // Log data for logs //
        $log_data = array('User' => $user->id, 'Photo' => $photograph->id);

        // Response message //
        $message = array(
            'status' => 'error',
            'text' => 'Unable to edit photograph at this time. Please try again later.',
        );

        // Update the caption //
        $photograph->caption = $request->input('caption');

        // Attempt to save //
        if ($photograph->save()) {
            $message['status'] = 'success';
            $message['text'] = 'Successfully updated the photograph';
            Log::info('User updated photograph', $log_data);
        } else {
            Log::error('User attempted to update photograph', $log_data);
        }

        // Redirect user back to photograph page //
        return redirect("photographs/{$photograph->id}")->with($message['status'], $message['text']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photograph $photograph
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photograph $photograph) {
        // Get user id //
        $user = auth()->user()->id;

        // Check access //
        if ($user !== $photograph->user_id) {
            return redirect('/photographs')->with('error', 'Unauthorized access');
        }

        // Response message //
        $message = array(
            'status' => 'error',
            'text' => 'Unable to remove photograph at this time. Please try again later.',
        );


        // Got to remove old images here //
        $main = Storage::disk('public_upload')->delete("main/{$photograph->filename}");
        $thumb = Storage::disk('public_upload')->delete("main/thumb/{$photograph->filename}");

        // Check image deleted //
        if (!$main) {
            Log::error('Unable to remove main photograph', array('Photo' => $photograph->filename));
        }
        // Check thumb deleted //
        if (!$thumb) {
            Log::error('Unable to remove thumb photograph', array('Photo' => $photograph->filename));
        }

        try {
            // Attempt to delete //
            if ($photograph->delete()) {
                $message['status'] = 'success';
                $message['text'] = 'Successfully removed photo';
                Log::info('Image was removed', array('User' => $user, 'Photo' => $photograph->id));
            }
        } catch (\Exception $e) {
            // Catch exception if thrown //
            Log::error($e);
        }

        return redirect('photographs')->with($message['status'], $message['text']);

    }
}
