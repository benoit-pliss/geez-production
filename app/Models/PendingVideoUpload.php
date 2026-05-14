<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingVideoUpload extends Model
{
    protected $fillable = ['video_id', 'user_id'];
}
