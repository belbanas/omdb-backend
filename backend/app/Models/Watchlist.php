<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Watchlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'imdb_id',
        'user_id',
        'timestamp'
    ];
}
