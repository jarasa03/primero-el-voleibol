<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Club extends CatalogEntry
{
    public function supporters(): HasMany
    {
        return $this->hasMany(ProjectClubSupporter::class);
    }
}
