<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumbleVideo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rumble_channel_id',
        'video_category_id',
        'html',
        'url',
        'title',
        'thumbnail',
        'duration',
        'uploaded_at',
        'likes_count',
        'dislikes_count',
        'views_count',
        'comments_count',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rumble_video';
}