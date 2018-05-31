<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comments';

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function photograph() {
        return $this->belongsTo(Photograph::class);
    }
}
