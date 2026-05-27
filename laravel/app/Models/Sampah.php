<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sampah extends Model
{
    protected $table = 'sampahs';

    protected $guarded = ['id'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_sampah', 'sampah_id', 'user_id')->withPivot('total');
    }
}
