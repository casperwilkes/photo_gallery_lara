<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Photograph extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'photographs';

    public function user() {
        return $this->belongsTo(User::class);
    }
}
