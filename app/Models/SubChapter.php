<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubChapter extends Model
{
    protected $fillable = ['chapter_id', 'title', 'order', 'content'];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    // nomor "1.1", "1.2" dst — gabungan order bab & order sub bab
    public function getNumberAttribute(): string
    {
        return $this->chapter->order . '.' . $this->order;
    }
}
