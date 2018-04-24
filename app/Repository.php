<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commits()
    {
        return $this->hasMany(Commit::class);
    }

    public function scopeFindByName($query, $name)
    {
        return $query->where('name', $name)->first();
    }
}
