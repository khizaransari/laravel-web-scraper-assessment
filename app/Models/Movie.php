<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    public $guarded = ['id'];

    public function scopeHasDuplicateTitles(Builder $query)
    {
        return $query->select('title')
            ->groupBy('title')
            ->havingRaw('COUNT(title) > 1');
    }
}
