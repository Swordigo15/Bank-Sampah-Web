<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sampah extends Model
{
    protected $table = 'sampahs';

    protected $guarded = ['id'];

    public function inputHistory(): BelongsToMany
    {
        return $this->belongsToMany(InputHistory::class, 'user_sampah', 'sampah_id', 'input_history_id')->withPivot('total', 'total_harga');
    }
}
