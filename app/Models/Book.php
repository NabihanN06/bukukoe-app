<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        "title",
        "slug",
        "description",
        "page_count",
        "author",
        "published_year",
        "image",
        "status",
        "category",
    ];

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}
