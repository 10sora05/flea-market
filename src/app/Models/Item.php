<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'brand',
        'description',
        'condition_id',
        'img_url',
        'image_path',
    ];

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }    
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy($user)
    {
        return $this->likes->contains('user_id', $user->id);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function getImageUrlAttribute()
    {
        if (!empty($this->img_url)) {
            return $this->img_url;
        }

        if (!empty($this->image_path) && \Storage::disk('public')->exists($this->image_path)) {
            return asset('storage/' . $this->image_path);
        }

        return asset('img/no-item.png'); // デフォルト画像
    }


}
