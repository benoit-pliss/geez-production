<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'ParentTag',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
