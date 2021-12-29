  @include('posts.header')
        <div class="col-md-12 mb-1 mt-2">
          <div class="card">
            <div class="card-body">
              <h3 class="text-center p-0" style="">Published Posts</h3>
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
                  <div class="" style="font-size:15px"> <strong>Publisher:</strong> {{$post->publisher}}</div>
                  @if($post->editor)
                    <div class="" style="font-size:15px"> <strong>Last edit by:</strong> {{$post->editor}}</div>
                  @endif
                  <br>
                  <p class="card-text">{{$post->text}}</p>
                </div>
              </div>
            </div>
          @endforeach
        @else
        <div class="col-md-12 mb-1">
          <div class="card">
            <div class="card-body">
              <div class="alert alert-info m-0">
                No published posts yet.
              </div>
            </div>
          </div>
        </div>
        @endif

      </div>

    </div>
  </body>
</html>
