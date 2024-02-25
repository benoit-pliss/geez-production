<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilesTags extends Model
{
    use HasFactory;

    protected $table = 'files_tags';

    protected $fillable = [
        'file_id',
        'tag_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
