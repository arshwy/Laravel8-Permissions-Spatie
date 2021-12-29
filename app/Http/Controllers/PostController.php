<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class PostController extends Controller
{



    public function home(){
      $posts = Post::where('status', 'published')
                   ->orderBy('id', 'desc')
                   ->get();
      foreach ($posts as $post) {
        $post->author    = User::find($post->author_id)->name;
        $post->publisher = User::find($post->publisher_id)->name;
        if ($post->editor_id) {
          $post->editor = User::find($post->editor_id)->name;
        }
      }

      return view('posts.published', ['posts' => $posts]);
    }





    public function underReview() {
      $posts = Post::where('status', 'review')
                  ->orderBy('id', 'desc')
                  ->get();
      foreach ($posts as $post) {
        $post->author = User::find($post->author_id)->name;
        if ($post->editor_id) {
          $post->editor = User::find($post->editor_id)->name;
        }
      }

      return view('posts.pending-to-review', [
        'posts' => $posts
      ]);
    }

    public function sendToEdit($id){
      $post = Post::find($id)->update(['status' => 'edit']);
      return redirect()->back();
    }

    public function publish($id){
      $post = Post::find($id)->update([
        'publisher_id' => Auth::user()->id,
        'status'       => 'published'
      ]);
      return redirect()->route('posts.reviews');
    }






    public function underEdit(){
      $posts = Post::where('status', 'edit')
                  ->orderBy('id', 'desc')
                  ->get();
      foreach ($posts as $post) {
        $post->author = User::find($post->author_id)->name;
        if ($post->editor_id) {
          $post->editor = User::find($post->editor_id)->name;
        }
      }
      return view('posts.pending-to-edit', ['posts' => $posts]);
    }

    public function edit($id){
      $post = Post::find($id);
      return view('posts.edit', ['post'=>$post]);
    }

    public function update(Request $request, $id){
      $request->validate([
        'title' => 'required|min:5|max:100',
        'text'  => 'required|max:2000'
      ]);
      Post::find($id)->update([
        'editor_id' => Auth::user()->id,
        'title' => $request->title,
        'text'  => $request->text
      ]);
      return redirect()->route('posts.edits');
    }

    public function cancelEdit(){
      return redirect()->route('posts.edits');
    }








    public function createPost() {
      $posts = Post::where('status', 'created')
                   ->orderBy('id', 'desc')
                   ->get();
      foreach ($posts as $post) {
        $post->author = User::find($post->author_id)->name;
      }
      return view('posts.create', ['posts' => $posts]);
    }

    public function sendToReview($id){
      $post = Post::find($id)->update(['status' => 'review']);
      if (Auth::user()->hasRole('writer')) {
        return redirect()->route('posts.create');
      }
      else {
        return redirect()->route('posts.edits');
      }
    }

    public function savePost(Request $request){
      $request->validate([
        'title' => 'required|min:5|max:100',
        'text'  => 'required|max:2000'
      ]);
      Post::create([
        'author_id' => Auth::user()->id,
        'title' => $request->title,
        'text' => $request->text,
        'status' => 'created'
      ]);
      return redirect()->route('posts.create');
    }






    public function delete($id){
      Post::find($id)->delete();
      if (Auth::user()->hasRole('writer')) {
        return redirect()->route('posts.create');
      }
      else {
        return redirect()->route('posts.reviews');
      }
    }


}
