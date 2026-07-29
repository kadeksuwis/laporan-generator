<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['title'];

    public function chapters()
    {
        return $this->hasMany(Chapter::class)->orderBy('order');
    }
}