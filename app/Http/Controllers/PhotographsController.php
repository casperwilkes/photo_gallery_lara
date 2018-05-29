<?php

namespace App\Http\Controllers;

use App\Photograph;
use Illuminate\Http\Request;

use Illuminate\Session\Store;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class PhotographsController extends Controller {

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
            'caption' => 'required|max:191',
        ));

        // Return message //
        $message = array(
            'status' => 'error',
            'text' => 'Unable to save your photograph at this time, try again later.',
        );

        // Attempt to Save the image //
        $path = $request->image->store('main', 'public_upload');

        // Check valid path //
        if ($path) {
            // Get file name //
            $file_name = basename($path);

            // Setup image path for uploading //
            $img_path = config('filesystems.disks.public_upload.root') . '/main/';

            // Setup thumbnail & save //
            $thumb = Image::make($img_path . $file_name)
                          ->resize(200, null, function ($constrain) {
                              $constrain->aspectRatio();
                          })->save($img_path . 'thumb/' . $file_name);

            // Check we got back a valid instance //
            if ($thumb) {
                // Get file object //
                $file = $request->file('image');

                // Instantiate a new photograph //
                $photo = new Photograph();

                // Set values //
                $photo->user_id = 1;
                $photo->filename = $file_name;
                $photo->type = $file->getClientMimeType();
                $photo->size = $file->getSize();
                $photo->caption = $request->get('caption');

                // Save the photo //
                if ($photo->save()) {
                    $message['status'] = 'success';
                    $message['text'] = 'Your photograph was successfully uploaded';
                }
            }
        }

        return redirect('/photographs')->with($message['status'], $message['text']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Photograph $photograph
     * @return \Illuminate\Http\Response
     */
    public function show(Photograph $photograph) {
        return view('photographs.show', array('photo' => $photograph));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Photograph $photograph
     * @return \Illuminate\Http\Response
     */
    public function edit(Photograph $photograph) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Photograph $photograph
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photograph $photograph) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photograph $photograph
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photograph $photograph) {
        //
    }
}
