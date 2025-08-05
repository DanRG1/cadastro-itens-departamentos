<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    /**
     * Get the department that owns the item.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
