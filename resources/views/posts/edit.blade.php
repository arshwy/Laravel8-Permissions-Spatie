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
              <form action="{{ route('posts.update', ['id'=>$post->id]) }}" method="post">
                <div class="form-group">
                  @csrf
                  <input type="text" name="title" class="form-control form-control-sm" value="{{$post->title}}" placeholder="Enter post title">
                  @error('title')
                    <span class="text text-danger" style="font-size:15px;">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group">
                  <textarea name="text" rows="8" class="form-control form-control-sm" placeholder="Enter your text">{{$post->text}}</textarea>
                  @error('text')
                    <span class="text text-danger" style="font-size:15px;">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group">
                  <button type="submit" name="button" class="btn btn-success">Update</button>
                </div>
                <a href="{{ route('posts.cancelEdit') }}" class="btn btn-sm btn-danger">Cancel</a>
              </form>
            </div>
          </div>
        </div>


      </div>
    </div>
  </body>
</html>
