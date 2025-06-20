<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Condition extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function item()
    {
        return $this->hasOne(Item::class);
    }
}
