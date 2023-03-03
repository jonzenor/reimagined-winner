<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LifeLog extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-m-d';

    public function category(): BelongsTo
    {
        return $this->BelongsTo(LifeLogCategory::class);
    }
}
