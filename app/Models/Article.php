<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Article extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name',
        'img',
        'anons',
        'text',
        'user_id',
    ];

    public function sluggable(): array
    {
        return [
            'slug'=>[
                'source'=>'name',
            ]
        ];
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
