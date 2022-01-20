<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    /**
     * @param Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @mixin Builder
     */

    public function index(){
//        $posts = Post::all(); shows all posts but we need only user's posts

//        $posts = Auth::user()->posts(); displays relation

//        $user_id = 31;
//        $posts = Post::where('user_id', $user_id)->get();  this is too specific

//        $posts = \auth()->user()->posts; just another way of using.
//        $posts = Auth::user()->posts()->get();
        $posts = Auth::user()->posts()->paginate(5);

        return view('admin.posts.index', ['posts' => $posts]);
    }

    public function show(Post $post){
        return view('blog-post', ['post' => $post]);
    }

    public function create(){
        return view('admin.posts.create');
    }

    public function store(){
        $this->authorize('create', Post::class);

        $inputs = \request()->validate([
            'title' => 'required|min:8|max:255',
            'file' => 'file',
            'body' => 'required'
        ]);

        if (\request('post_image')){
            $inputs['post_image'] = \request('post_image')->store('images');
        }

        if(auth()->user()->posts()->create($inputs)){
            \session()->flash('message-post-created', 'Post named '.$inputs['title'].' was successfully created');
        }else{
            \session()->flash('message-post-failed', 'There was a problem with adding the post');
        }
        return redirect()->route('admin.posts.index');
    }

    public function destroy(Post $post){
//        if(auth()->user()->id !== $post->user_id){
//
//        }
        $this->authorize('delete', $post);
        $post->delete();
        Session::flash('message', 'The post was deleted');
        return back();
    }

    public function edit(Post $post){
//        $this->authorize('view', $post);
//        if(\auth()->user()->can('view', $post)){}
        return view('admin.posts.edit', ['post' => $post]);
    }

    public function update(Post $post){
        $inputs = \request()->validate([
            'title' => 'required|min:8|max:255',
            'file' => 'file',
            'body' => 'required'
        ]);

        if (\request('post_image')){
            $inputs['post_image'] = \request('post_image')->store('images');
            $post->post_image = $inputs['post_image'];
        }

        $post->title = $inputs['title'];
        $post->body = $inputs['body'];

//        auth()->user()->posts()->save($post)
//        $post->save()
//        $post->update(
//            $inputs = \request()->validate([
//                'title' => 'required|min:8|max:255',
//                'file' => 'file',
//                'body' => 'required'
//            ]));

        $this->authorize('update', $post);

        if($post->save()){
            \session()->flash('message-post-created', 'Post named '.$inputs['title'].' was successfully updated');
        }else{
            \session()->flash('message-post-failed', 'There was a problem with updating the post');
        }
        return redirect()->route('admin.posts.index');
    }
}
