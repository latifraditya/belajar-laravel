<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function getRouteKeyName()
    {
      return 'id';
    }

    protected static function boot() {
      parent::boot();
      static::deleting(function ($category) {
        $category->posts()->delete(); // Hapus semua post yang terkait
    });

    }
}
