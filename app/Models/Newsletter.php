<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $table = 'newsletter';

    protected $fillable = [
        'email',
        'is_active',
        'unsubscribed_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
