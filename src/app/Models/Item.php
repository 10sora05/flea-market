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
        'description',
        'img_url'
    ];

    public function conditions()
    {
        return $this->belongsToMany(Condition::class, 'condition_item')->withTimestamps();
    }
}
