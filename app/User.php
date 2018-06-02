<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
}
