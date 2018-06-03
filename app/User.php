<?php

namespace App;

use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Log;

class User extends Authenticatable {

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_fields',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'profile_fields' => 'array',
    ];

    /**
     * Photographs relationship.
     *  User has many photos
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photographs() {
        return $this->hasMany(Photograph::class);
    }

    /**
     * Comments relationship.
     *  User has many comments
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    /**
     * User profile fields mutator.
     *  Encrypts profile fields
     * @param $value
     * @return string
     */
    public function setProfileFieldsAttribute($value) {
        $this->attributes['profile_fields'] = encrypt($value);
    }

    /**
     * User profile fields accessor.
     *  Decrypts profile fields
     * @param $value
     * @return string
     */
    public function getProfileFieldsAttribute($value) {
        return decrypt($value);
    }

    public function saveAvatar(UploadedFile $image){
        // Get public upload storage disk //
        $main = Storage::disk('public_upload');

        // Builds img structure //
        build_img_structure();

        // Setup image path for uploading //
        $img_path = $main->getAdapter()->getPathPrefix() . 'avatar/';

        // Move temp file to public_upload main dir //
        $path = $main->putFile('avatar', $image);

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
