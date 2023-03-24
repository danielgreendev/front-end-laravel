<!DOCTYPE html>

<html lang="en" class="loading">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <meta name="author" content="Gravity Infotech">

    <title>{{trans('labels.register')}}</title>

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
                    <section id="regestration">
                        <div class="container">
                            <div class="row full-height-vh">
                                <div class="col-12 d-flex align-items-center justify-content-center">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row d-flex">
                                                <div class="col-12 col-sm-12 col-md-6 bg-dark">
                                                    <div class="card-block">
                                                        <div class="card-img overlap">
                                                            <img alt="Card image cap" src="{{Helper::admininfo()->image}}" width="150" class="mx-auto d-block">
                                                        </div>
                                                        <h2 class="card-title font-large-1 text-center white mt-3">{{trans('labels.register')}}</h2>
                                                    </div>
                                                </div>
                                                @if(session()->has('danger'))
                                                <div class="alert alert-danger" style="text-align: center;">
                                                    {{ session()->get('danger') }}
                                                </div>
                                                @endif
                                                <div class="col-12 col-sm-12 col-md-6 d-flex align-items-center">
                                                    <div class="card-block mx-auto">
                                                        <form method="POST" action="{{ URL::to('/admin/create') }}" id="form_register">
                                                            @csrf
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="icon-user"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" class="form-control" name="name" id="name" placeholder="{{trans('labels.name')}}" required value="{{old('name')}}">
                                                            </div>
                                                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="ft-mail"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="email" class="form-control" name="email" id="email" placeholder="{{trans('labels.email')}}" required value="{{old('email')}}">
                                                            </div>
                                                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="ft-mobile">+55</i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="{{trans('labels.mobile')}}" required value="{{old('mobile')}}">
                                                            </div>
                                                            @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="ft-lock"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="password" class="form-control" name="password" id="password" placeholder="{{trans('labels.password')}}" required>
                                                            </div>
                                                            @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                                                            <div class="form-group text-center">
                                                                <button type="submit" class="btn btn-success btn-raised w-100" id="btn_register">{{trans('labels.signup')}}</button>
                                                                <a href="{{ URL::to('/admin/') }}" class="black">{{trans('labels.already_account')}}</a>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <div id="loading_request" style="display: none;">
        <div class="loading_request">
            <div class="loader">
                <div class="loader__bar"></div>
                <div class="loader__bar"></div>
                <div class="loader__bar"></div>
                <div class="loader__bar"></div>
                <div class="loader__bar"></div>
                <div class="loader__ball"></div>
            </div>
            <div class="loadind_text">Processando...</div>
        </div>
    </div>
    <link rel="stylesheet" href="{{asset('storage/app/public/assets/css/loading.css')}}">
    <script src="{{ asset('storage/app/public/admin-assets/js/jquery-3.6.0.js')}}"></script>
    <script src="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.js')}}" type="text/javascript"></script>
    <script>
        // Toaster Success/error Message Start
        @if(Session::has('success'))
        toastr.options = {
                "closeButton": true,
                "progressBar": true
            },
            toastr.success("{{ session('success') }}");
        @endif
        @if(Session::has('error'))
        toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": 10000
            },
            toastr.error("{{ session('error') }}");
        @endif

        $("#btn_register").click(function (e) {
            e.preventDefault();

            $("#loading_request").css("display", "block");

            $("#form_register").submit();
        });
    </script>

</html>