<?php

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $guarded = [];

    public function replies () {
        return $this->hasMany(Reply::class)->with('user');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}