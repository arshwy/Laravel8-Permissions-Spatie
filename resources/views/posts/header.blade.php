<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Algorithmi | create post</title>
    <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
  </head>
  <body>
    <div class="container">
      <div class="col-md-8" style="margin:auto;">

        <div class="col-md-12 mb-1 mt-1">
          <div class="card border-info">
            <div class="card-body" style="margin:auto;">

              @hasanyrole('writer|admin')
                <a href="{{ route('posts.create') }}" class="btn btn-success btn-sm">Create new</a>
              @endhasanyrole
              <a href="{{ route('posts.home') }}" class="btn btn-info btn-sm">Published posts</a>
              @hasanyrole('publisher|admin')
                <a href="{{ route('posts.reviews') }}" class="btn btn-warning btn-sm">Waiting review</a>
              @endhasanyrole
              @hasanyrole('editor|admin')
                <a href="{{ route('posts.edits') }}" class="btn btn-warning btn-sm">Waiting edit</a>
              @endhasanyrole
              <a href="{{ route('user.logout') }}" class="btn btn-info btn-sm">Logout</a>


            </div>
          </div>
        </div>
