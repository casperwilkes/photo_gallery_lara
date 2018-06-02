<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Log;

class Photograph extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'photographs';

    /**
     * User relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Comments relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    /**
     * Saves image and thumbnail to filesystem
     * @param UploadedFile $image Uploaded image
     * @return array|bool False on fail, Array of image data on success
     */
    public function saveImage(UploadedFile $image) {
        // Get public upload storage disk //
        $main = Storage::disk('public_upload');

        // Setup image path for uploading //
        $img_path = $main->getAdapter()->getPathPrefix() . 'main/';

        // Move temp file to public_upload main dir //
        $path = $main->putFile('main', $image);

        // Get saved image file name //
        $file_name = basename($path);

        // Store original //
        if ($path) {
            // Thumb path //
            $thumb_path = $img_path . 'thumb/' . $file_name;

            // Setup thumbnail & save //
            $thumb = Image::make($img_path . $file_name)
                          ->resize(200, null, function ($constrain) {
                              $constrain->aspectRatio();
                          })->save($thumb_path);

            if ($thumb) {
                // Return array of image data //
                return array(
                    'path' => $img_path . $file_name,
                    'name' => $file_name,
                    'type' => $image->getClientMimeType(),
                    'size' => $image->getSize(),
                );
            }

            // Couldn't save thumbnail //
            Log::error('Unable to thumbnail image', array('thumb_path' => $thumb_path));
        }

        // Couldn't save image //
        Log::error('Unable to save image', array('image_path' => $img_path . $file_name));

        return false;
    }
}
