<!DOCTYPE html>
<html dir="{{ session()->get('direction') == 2 ? 'rtl' : '' }}">
<head>
    <title>{{ Helper::webinfo($getrestaurant->id)->website_title }}</title>
    <!-- meta tag -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta name="description" content="Oneoutlet Whatsapp Marketing Brasil Entrega de Produtos {{ Helper::webinfo($getrestaurant->id)->meta_title }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="{{ Helper::webinfo($getrestaurant->id)->meta_title }}" />
    <meta property="og:description" content="{{ Helper::webinfo($getrestaurant->id)->meta_description }}" />
    <meta property="og:image" content='{{ Helper::webinfo($getrestaurant->id)->og_image }}' />
    <!-- favicon-icon  -->
    <link rel="icon" href='{{ Helper::webinfo($getrestaurant->id)->favicon }}' type="image/x-icon">
    <!-- font-awsome css  -->
    <link rel="stylesheet" type="text/css" href="{!! asset('storage/app/public/front/css/font-awsome.css') !!}">
    <!-- fonts css -->
    <link rel="stylesheet" type="text/css" href="{!! asset('storage/app/public/front/fonts/fonts.css') !!}">
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{!! asset('storage/app/public/front/css/bootstrap.min.css') !!}">
    <!-- owl.carousel css -->
    <link rel="stylesheet" type="text/css" href="{!! asset('storage/app/public/front/css/owl.carousel.min.css') !!}">
    <!-- style css  -->
    <link rel="stylesheet" type="text/css" href="{!! asset('storage/app/public/front/css/style.css') !!}">
    <link href="{!! asset('storage/app/public/assets/plugins/sweetalert/css/sweetalert.css') !!}" rel="stylesheet">
    <!-- responsive css  -->
    <link rel="stylesheet" type="text/css" href="{!! asset('storage/app/public/front/css/responsive.css') !!}">
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/views/front/theme/theme.css')}}">
</head>
<body>
    <!--*******************
 Preloader start
 ********************-->
    <div id="preloader">
        <input type="hidden" name="hdnsession" id="hdnsession" value="{{ session()->get('direction') }}">
        <div class="loader">
        </div>
    </div>
    <!--*******************
 Preloader end
 ********************-->
    <!-- navbar -->
    <header>
        <nav class="product-details-sec px-0">
            <div class="container">
                <div class="d-flex align-items-center">
                    <a class="navbar-brand mx-3" href="{{ URL::to($getrestaurant->slug) }}">
                        <img src="{{ Helper::webinfo(@$getrestaurant->id)->image }}" alt=""></a>
                    <h2 class="text-white m-0" id="token_name">{{ Helper::getrestaurant($getrestaurant->slug)->name }}</h2>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="sec-head">{{ Helper::webinfo($getrestaurant->id)->description }}</p>
                    <p class="sec-info mx-2">
                        <button class="btn btn-sm btn-light bg-white text-dark p-1" data-toggle="modal"
                            data-target="#infomodal">
                            <i class="far fa-info-circle"></i>
                            {{ Helper::is_store_closed($getrestaurant->id) == 1 ? trans('labels.closed') : trans('labels.open') }}
                        </button>
                    </p>
                </div>
            </div>
        </nav>
    </header>
    @if (request()->route()->getName() == "front.home")
    <div class="nav-sec bg-white menu-sec">
        <div class="container px-0">
            <div class="navbar px-0" id="navbarNav">
                <div class="input-group col-md-12 mb-2 mt-2">
                    <input type="text" id="searchText" class="form-control" placeholder="{{trans('labels.search_here')}}">
                    <div class="{{ session()->get('direction') == 2 ? 'input-group-prepend' : 'input-group-append' }}">
                        <span class="input-group-text"><i class="far fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- navbar -->
    <div id="success-msg" class="alert alert-dismissible mt-3" style="display: none;">
        <span id="msg"></span>
    </div>
    <div id="error-msg" class="alert alert-dismissible mt-3" style="display: none;">
        <span id="ermsg"></span>
    </div>
    <style>
        :root {
            --primary-font: Josefin Sans;
            /* Color */
            --primary-color: #000;
            --primary-bg-color: #f4f4f8;
            --body-color: #f7f7f7;
            /* Hover Color */
            --primary-color-hover: {{ Helper::webinfo($getrestaurant->id)->primary_color }};
            --primary-bg-color-hover: #000;
            --btn-color: {{ Helper::webinfo($getrestaurant->id)->secondary_color }};
            --active-menu: {{ Helper::webinfo($getrestaurant->id)->primary_color }}30;
        }
    </style>
