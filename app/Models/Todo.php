<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Todo extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'unique_id',
        'provider',
        'difficulty',
        'duration',
    ];

    protected $casts = [
        'difficulty' => 'integer',
        'duration' => 'integer',
    ];
}
