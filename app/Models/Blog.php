<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-m-d';

    protected $fillable = ['title', 'slug', 'date', 'status', 'text'];
}
