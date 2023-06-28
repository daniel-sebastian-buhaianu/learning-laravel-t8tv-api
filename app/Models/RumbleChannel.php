<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumbleChannel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rumble_id',
        'url',
        'title',
        'joining_date',
        'description',
        'banner',
        'avatar',
        'followers_count',
        'videos_count'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rumble_channel';
}