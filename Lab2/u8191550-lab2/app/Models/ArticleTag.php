<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleTag extends Model
{
    use HasFactory;
    protected $table = 'articles_tags';
    protected $fillable = ['article_id', 'tag_id'];
    public $timestamp = false;
    public $timestamps = false;
}
