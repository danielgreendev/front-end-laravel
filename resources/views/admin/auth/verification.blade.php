<!DOCTYPE html>

<html lang="en" class="loading">

   <head>

      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

      <meta http-equiv="X-UA-Compatible" content="IE=edge">

      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

      <meta name="author" content="Gravity Infotech">

      <title>{{trans('labels.login')}}</title>

      <link rel="icon" href='{{Helper::admininfo()->favicon}}' type="image/x-icon">

      <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/css/app.css') }}">

      <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.css')}}">

   </head>
  <body data-col="1-column" class=" 1-column  blank-page blank-page">
    @if(Session::has('error'))
        <div class="alert alert-danger" style="text-align: center; color: #fff !important; font-weight: bold;">
            {{ Session::get('error') }}
        </div>
    @endif
    <div class="wrapper">
      <div class="main-panel">
        <div class="main-content">
          <div class="content-wrapper">
                <section id="login">
                    <div class="container-fluid gradient-red-pink">
                        <div class="row full-height-vh">
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                <div class="card bg-blue-grey bg-darken-3 text-center width-400">
                                    <div class="card-body">
                                        <div class="card-block">

                                        	@if(session()->has('danger'))
                                        	    <div class="alert alert-danger" style="text-align: center;">
                                        	        {{ session()->get('danger') }}
                                        	    </div>
                                        	@endif

                                            <div class="form-group mt-4">
                                                <div class="col-md-12">
                                                    <img alt="element 06" class="mb-1" src="{{Helper::admininfo()->image}}" width="190">
                                                </div>
                                            </div>

                                            <form method="POST" class="mt-5 mb-5 login-input" action="{{route('admin.systemverification')}}">
                                                @csrf

                                                <div class="form-group">
                                                    <input id="envato_username" type="text" class="form-control @error('envato_username') is-invalid @enderror" name="envato_username" value="{{ old('envato_username') }}" required autocomplete="envato_username" autofocus placeholder="Enter Envato username">

                                                    @error('envato_username')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ trans('labels.email') }}">

                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <input id="purchase_key" type="text" class="form-control @error('purchase_key') is-invalid @enderror" name="purchase_key" required autocomplete="current-purchase_key" placeholder="Envato purchase key">

                                                    @error('purchase_key')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <?php
                                                $text = str_replace('verification', '', url()->current());
                                                ?>

                                                <div class="form-group">
                                                    <input id="domain" type="hidden" class="form-control @error('domain') is-invalid @enderror" name="domain" required autocomplete="current-domain" value="{{$text}}"  readonly="">
                                                </div>

                                                <button type="submit" class="btn login-form__btn submit w-100">
                                                    {{ __('Submit') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <!--Login Page Ends-->
          </div>
        </div>
      </div>
    </div>

    <script src="{{ asset('storage/app/public/admin-assets/js/jquery-3.6.0.js')}}"></script>
   <script src="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.js')}}" type="text/javascript"></script>
   <script>
      // Toaster Success/error Message Start
      @if(Session::has('success'))
         toastr.options = {
            "closeButton" : true,
            "progressBar" : true
         },
         toastr.success("{{ session('success') }}");
      @endif
      @if(Session::has('error'))
         toastr.options ={
            "closeButton" : true,
            "progressBar" : true,
            "timeOut" : 10000
         },
         toastr.error("{{ session('error') }}");
      @endif
   </script>

</html>