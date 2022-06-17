<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasFactory, Sluggable, NodeTrait {
        Sluggable::replicate insteadof NodeTrait;
    }

    protected $fillable = [
        'name',
        'img',
        'description',
    ];

    public function sluggable(): array
    {
        return [
            'slug'=>[
                'source'=>'name',
            ]
        ];
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
