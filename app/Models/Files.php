<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Files extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'file',
        'id_type',
        'url',
        'poster_url',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'files_tags', 'file_id', 'tag_id');
    }
}
