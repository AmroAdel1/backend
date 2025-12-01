<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostsController extends Controller
{
    // 2) renders view displaying all posts
    public function index() {
        // select * from posts
        $allPosts = Post::all();              // collection object
        return view('posts.index', ["posts" => $allPosts]);    // posts -> name of variable to access in view
    }

    // 3) renders view displaying a single post        // convention over configuration: laravel take care of code when convention is followed
    public function show(Post $post) {      // type hinting    // route model binding => for dynamic route   /posts/{post}

        // select * from posts where id = $id limit 1
//      $singlePost = Post::find($id);                    // model object                                            // 1)
//      $singlePost = Post::where('id', $id);             // builder object: building queries(not complete)          // 2)
//      $singlePost = Post::where('id', $id)->first();    // model object                                            // 2)             // return one record
//      $singlePost = Post::where('id', $id)->get();      // collection object                                       // 3)             // return more than one record

/*
        if(is_null($singlePost)) {                      // for id that doesn't exist(exception)
            return to_route('posts.index');    // singlePost->title
        }

        $singlePost = Post::findorFail($id);
*/
        return view('posts.show', ["post" => $post]);
//      $singlePost->title;
    }

    public function create() {         // renders view to create a new post
        // select * from users
        $users = User::all();
        return view('posts.create', ["users" => $users]);
    }

    public function store() {           // store post in db

        // backend validation
        request()->validate([       // secure and better
            'title' => ['required','min:3'],                // key -> validation rules
            'desc' => ['required', 'min:5'],
            'posted_by' => ['required', 'exists:users,id']       // table, column   // given posted_by value must exist
        ]);         // which column to check posted_by value in table users   // posted-by in table in column id

        // 1) get data
        $data = request()->all();            // get all request data(object)   data->title
//      $description = request()->desc;      // from name of input field
//      $data = $_POST;       return $data;

        // 2) insert into db
        $post = Post::create([    // put in fillable
            "title" => $data['title'],              // or => $title
            "description" => $data['desc'],
            "user_id" => $data['posted_by'],
            "xyz" => 'some value',                // ignore
        ]);
    /*
        $post = new Post();                                 // create new model object
        $post->title = $data['title'];                      // set title    // or = $title
        $post->description = $data['description'];          // set description
        $post->save();                                      // save model(insert)
    */

        // 3) redirect to index
        return to_route('posts.index');
    }

    public function edit(Post $post) {         // renders view to edit a post
        // select * from users
        $users = User::all();
        return view('posts.edit', ["users" => $users, "post" => $post]);
    }

    public function update(Post $post) {           // update post in db

        request()->validate([
            'title' => ['required','min:3'],
            'desc' => ['required', 'min:5'],
            'posted_by' => ['required', 'exists:users,id']
        ]);

        // 1) get data
        $data = request()->all();       // get all request data(object)   data->title
        //$description = request()->desc;      // from name of input field

        // 2) update in db
        $post->update([
            'title' => $data['title'],
            'description' => $data['desc'],
            'user_id' => $data['posted_by'],
        ]);

        // 3) redirect to index
        return to_route('posts.show', $post->id);
    }

    public function destroy(Post $post) {       // delete post from db
        $post->delete();                    // contain model events: when model deleted. want to do something else
        // $post = Post::find($post)
        // $post->delete();    // in two lines
        return to_route('posts.index');
    }
}




// composer create-project laravel/laravel blog
// composer require barryvdh/laravel-debugbar --dev        // install package
// php artisan tinker     // run php code in terminal    Post::all();
// php artisan make:controller PostsController --resource  // create controller
// php artisan make:model Post -m                     // create model
// php artisan make:controller
// php artisan => display artisan commands

// dd(var) => debug and stop execution. ensure parameter passed correctly and display its value   // directive
// put, patch, delete => need form
// phpmyadmin, dbeaver, tableplus => database client GUI tool
// choose package based on documentation, last commit(updates), stars(likes), issues(not good sign), pull requests(need to fix)

// laravel news   // newsletter
// larajobs   // job board
