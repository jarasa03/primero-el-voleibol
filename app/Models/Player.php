<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Player extends CatalogEntry
{
    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }
}
