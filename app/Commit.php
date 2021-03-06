<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Commit extends Model
{
    protected $casts = [
        'author' => 'object',
        'timestamp' => 'datetime',
    ];

    protected $fillable = [
        'author', 'timestamp', 'uid', 'message',
    ];

    public function scopeLatest($query)
    {
        return $query->where('timestamp', '>', Carbon::now()->subDays(30));
    }
}
