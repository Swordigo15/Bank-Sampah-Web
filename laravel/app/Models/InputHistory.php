<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InputHistory extends Model
{
    protected $table = 'input_histories';

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sampahs(): BelongsToMany
    {
        return $this->belongsToMany(Sampah::class, 'user_sampah', 'input_history_id', 'sampah_id')->withPivot('total', 'total_harga');
    }
}
