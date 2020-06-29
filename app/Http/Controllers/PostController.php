<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Image;

class PostController extends Controller
{
    public function create() {
        return view('posts/create');
    }

    public function store(Request $request) {

        $data = $request->validate([
            'caption' => 'required',
            'image' => [ 'required', 'image' ],
        ]);
        
        // saves the image in /storage/app/public/uploads. $imagePath === 'uploads/nameofimage.jpg'
        $image = request('image');
        $imagePath = request('image')->store('uploads', 'public'); // 'public' could be 's3' if we use Amazon
        // we ran 'php artisan storage:link', so /public/storage/ is equal to /storage/app/public/, where the iamge is saved
        // moves the image in the /public directory, so we can access it via url, and resizes it
        

        // 
        $resizedImage = Image::make( public_path("storage/{$imagePath}") )->fit(1200, 1200);
        $resizedImage->save();
        // dd($resizedImage);

        $rr = auth()->user()->posts()->create([
            'image' => 'uploads/' . $resizedImage->basename,       // same as $imagePath      
            'caption' => $data['caption'],
        ]);

        return redirect('/profile/' . auth()->user()->username);
    }

    public function show(\App\Post $post) {
//        $post = Post::findOrFail($post_id);
        
        return view('posts/show', [ 'post' => $post ] ); // $compact($post) == [ 'post' => $post ]
    }
}
