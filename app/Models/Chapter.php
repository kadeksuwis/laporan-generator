<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = ['report_id', 'title', 'order'];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function subChapters()
    {
        return $this->hasMany(SubChapter::class)->orderBy('order');
    }

    // nomor romawi dihitung dari 'order'
    public function getRomanNumberAttribute(): string
    {
        return $this->toRoman($this->order);
    }

    private function toRoman(int $number): string
    {
        $map = [
            'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
            'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
            'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1,
        ];
        $result = '';
        foreach ($map as $roman => $value) {
            while ($number >= $value) {
                $result .= $roman;
                $number -= $value;
            }
        }
        return $result;
    }
}
