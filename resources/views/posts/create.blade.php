
  @include('posts.header')

        <div class="col-md-12 mb-1 mt-2">
          <div class="card">
            <div class="card-body">
              <h3 class="text-center p-0" style="">Creating Posts by Writers</h3>
            </div>
          </div>
        </div>

        <div class="col-md-12 mb-1 mt-2">
          <div class="card">
            <div class="card-body">
              <form action="{{ route('posts.save') }}" method="post">
                <div class="form-group">
                  @csrf
                  <input type="text" name="title" class="form-control form-control-sm" placeholder="Enter post title">
                  @error('title')
                    <span class="text text-danger" style="font-size:15px;">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group">
                  <textarea name="text" rows="8" class="form-control form-control-sm" placeholder="Enter your text"></textarea>
                  @error('text')
                    <span class="text text-danger" style="font-size:15px;">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group">
                  <button type="submit" name="button" class="btn btn-success">Submit</button>
                </div>
              </form>
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
                  <p class="card-text">{{$post->text}}</p>
                  <a href="{{ route('posts.reviewable', ['id'=>$post->id]) }}" class="btn btn-sm btn-info">Send to review</a>
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
                No written posts yet.
              </div>
            </div>
          </div>
        </div>
        @endif

      </div>
    </div>
  </body>
</html>
