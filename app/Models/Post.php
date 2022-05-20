<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'slug',
        'title',
        'description',
        'website_id',
    ];
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public static function createAPost($request,$website_id)
    {
        $post = new Post();
        $post->slug = $request['slug'];
        $post->title = $request['title'];
        $post->content = $request['content'];
        $post->website_id = $website_id;
        $post->save();
        return $post;
    }
}
