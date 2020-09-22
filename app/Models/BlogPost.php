<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'content', 'author'
    ];

    protected $hidden = [
        'author_id',
    ];

    public function author()
    {
        return $this->belongsTo("App\Models\User");
    }
}
