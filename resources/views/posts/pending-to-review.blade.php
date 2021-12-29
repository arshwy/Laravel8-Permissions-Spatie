  @include('posts.header')

        <div class="col-md-12 mb-1 mt-2">
          <div class="card">
            <div class="card-body">
              <h3 class="text-center p-0" style="">Posts to Review by Publishers</h3>
            </div>
          </div>
        </div>

        @if(!$posts->isEmpty())
          @foreach($posts as $post)
            <div class="col-md-12 mb-1">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">{{$post->title}}</h5>
                  <div class="" style="font-size:15px"> <strong>Author:</strong> {{$post->author}}</div>
                  @if($post->editor)
                    <div class="" style="font-size:15px"> <strong>Last edit by:</strong> {{$post->editor}}</div>
                  @endif
                  <br>
                  <p class="card-text p-2">{{$post->text}}</p>
                  <a href="{{ route('posts.publish', ['id'=>$post->id]) }}" class="btn btn-sm btn-success">Publish</a>
                  <a href="{{ route('posts.editable', ['id'=>$post->id]) }}" class="btn btn-sm btn-warning">Send to Edit</a>
                  <a href="{{ route('posts.delete', ['id'=>$post->id]) }}" class="btn btn-sm btn-danger">Delete</a>
                </div>
              </div>
            </div>
          @endforeach
        @else
        <div class="col-md-12 mb-1">
          <div class="card">
            <div class="card-body">
              <div class="alert alert-info m-0">
                No posts to review yet!
              </div>
            </div>
          </div>
        </div>
        @endif

      </div>

    </div>
  </body>
</html>
