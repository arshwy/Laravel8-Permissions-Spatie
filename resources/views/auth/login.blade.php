<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Algorithmi | Login</title>
    <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
  </head>
  <body>
    <div class="container">

      <div class="row">

        <div class="col-md-4 offset-md-4" style="margin-top: 100px;">
          <div class="card border-info">

            <div class="card-header card-header-light">
              <h4 style="text-align:center;">User Login</h4>
            </div>
            <div class="card-body">
              <form action="{{ route('user.check') }}" method="post">
                @csrf
                @if(Session::get('fail'))
                  <div class="alert alert-danger">
                    {{Session::get('fail')}}
                  </div>
                @endif
                <div class="form-group">
                  <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-sm" placeholder="Enter your email">
                  <span class="text text-danger" style="font-size:13px;">@error('email') {{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-sm" placeholder="Enter your password">
                  <span class="text text-danger" style="font-size:13px;">@error('password') {{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                  <button class="btn btn-info" type="submit" name="button">Login</button>
                </div>
                <a href="{{ route('user.register') }}">Create new Account</a>
              </form>
            </div>

          </div>
        </div>

      </div>
    </div>
  </body>
</html>
