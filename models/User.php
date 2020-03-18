<?php

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];
    public function Posts() {
        return $this->hasMany(Comment::class);
    }
}