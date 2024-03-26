<?php

use App\Models\Post;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Spatie\YamlFrontMatter\YamlFrontMatter;

Route::get('/', function () {
    $files = File::files(resource_path("posts"));
    $posts = [];

    foreach($files as $file) {
        $document =YamlFrontMatter::parseFile($file);


        $posts[] = new Post(
            $document->title,
            $document->excerpt,
            $document->date,
            $document->body(),
            $document->slug
        );
    }

    return view('posts', [
        'posts'=> $posts
    ]);
});

Route::get('posts/{post}', function ($slug) {

    //Find a post by its slug and pass it to a view called "post" 2. veids
    return view('post', [
        'post'=>Post::find($slug)
    ]);


//1. variants kā izdarīt ta lai pārslēgtos uz citu majaslapu linku
    // if(! file_exists($path=__DIR__. "/../resources/posts/{$slug}.html")){
    //     return redirect('/');
    //     //abort(404);
    //     //ddd('file does not exist');
    // }

    // $post = cache()->remember("posts.{$slug}",1200, fn() => file_get_contents($path));

    // return view('post', ['post'=> $post]);
    
})->where('post','[A-z_\-]+');