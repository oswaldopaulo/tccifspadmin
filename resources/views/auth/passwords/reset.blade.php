<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Reset</title>
         <link href="{{ asset ('css/styles.css') }}" rel="stylesheet" />
        <script src="{{ asset ('/vendor/fontawesome-free-5.13.1-web/js/all.min.js') }}"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Reset Password</h3></div>
                                    <div class="card-body">
                                        <form  method="POST" action="{{ route('password.request') }}">
                        					{{ csrf_field() }}
                        					<input type="hidden" name="token" value="{{ $token }}">
                                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                <label class="small mb-1" for="email">Email</label>
                                                <input class="form-control py-4"  name="email" id="email" type="email" placeholder="Enter email address" value="{{ $email or old('email') }}" required autofocus/>
                                                   @if ($errors->has('email'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                                <label class="small mb-1" for="password">Password</label>
                                                <input class="form-control py-4" name="password" id="password" type="password" placeholder="Enter password" />
                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                              <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                                <label class="small mb-1" for="password-confirm">Password</label>
                                                <input class="form-control py-4" name="password_confirmation" id="password-confirm" type="password" placeholder="Enter password confirme" />
                                                 @if ($errors->has('password_confirmation'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                          
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                
                                               
                                                 <button type="submit" class="btn btn-primary">
                                                    Reset Password
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Oswaldo Paulo 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
 
        
         <script src="{{ asset ('js/jquery-3.5.1.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset ('vendor/bootstrap-4.5.0-dist/js/bootstrap.bundle.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset ('js/scripts.js') }}"></script>
      
    </body>
</html>
