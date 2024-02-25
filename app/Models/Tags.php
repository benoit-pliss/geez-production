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
        'color',
        'ParentTag',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function images()
    {
        return $this->belongsToMany(Images::class, 'files_tags');
    }
}
