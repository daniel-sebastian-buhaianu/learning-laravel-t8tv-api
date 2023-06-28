<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VideoCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'video_category';

    protected static function boot()
    {
        parent::boot();

        // Generate slug before saving the model
        static::creating(function ($videoCategory) {
            $videoCategory->slug = Str::slug($videoCategory->name);
        });
    }
}