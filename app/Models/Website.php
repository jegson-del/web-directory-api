<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'name',
        'user_id',
        'description',
        'url',
        'ranking',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_website');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
