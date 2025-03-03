<?php

namespace App\Models;

class Post
{
    private static $blog_posts =[
    [
        "title" => "Judul Post Pertama",
        "slug" => "judul-post-pertama",
        "author" => "Latif Raditya",
        "body"  => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Magmam ipsum esse, maxime quos, quae, quidem quibusdam quod quia voluptates doloribus."
    ],
    [
        "title" => "Judul Post Kedua",
        "slug" => "judul-post-kedua",
        "author" => "Latif Rusdi",
        "body"  => "Lorem ipsum dolor sit amet consectetur adipisicing elit."
    ],
];

public static function all()
{
    return collect(self::$blog_posts);

}
public static function find($slug){

    $posts = static::all();
    // $post = [];
    // foreach($posts as $p){
    // if($p["slug"] === $slug){
    //     $post = $p;
    //     }
    // }

    return $posts -> firstWhere('slug', $slug);
}

}