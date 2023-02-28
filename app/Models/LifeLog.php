<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LifeLog extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-m-d';
}
