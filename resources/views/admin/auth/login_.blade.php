@extends('user.main')

@section('header')

@include('user.main_resourse')

@endsection('header')

@section('content')
<div class="preloader">
	<div class="preloader-inner">
		<div class="preloader-icon">
			<span></span>
			<span></span>
		</div>
	</div>
</div>

<div class="breadcrumbs">
	<div class="container wow zoomIn" data-wow-delay=".2s">
		<div class="row align-items-center">
			<div class="col-lg-6 offset-lg-3 col-md-12 col-12">
				<div class="breadcrumbs-content">
					<h1 class="page-title">Acesse sua Conta</h1>
					<ul class="breadcrumb-nav">
						<li><a href="/">Home</a></li>
						<li>Acessar</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="account-login section">
	<div class="container wow fadeInUp" data-wow-delay=".4s">
		<div class="row">
			<div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
				<form class="card login-form inner-content" action="{{ route('check-admin') }}" method="post">
					@csrf
					<div class="card-body">
						<div class="title">
							<h3>Faça o Login para acessar sua Conta</h3>
							<p>Acesse sua conta com as informações abaixo</p>
						</div>
					
					<div class="input-head">
						<div class="form-group input-group">
							<label><i class="lni lni-envelope"></i></label>
							<input class="form-control" type="email" name="email" id="email" placeholder="{{trans('labels.enter_email')}}"  required="">
						</div>
						@error('email')<span class="text-danger text-left" id="email_error">{{ $message }}</span>@enderror
						<div class="form-group input-group">
							<label><i class="lni lni-lock-alt"></i></label>
							<input class="form-control" type="password" name="password" id="password" placeholder="{{trans('labels.enter_password')}}" required="">
						</div>
						@error('password')<span class="text-danger text-left" id="AuthPasswordError">{{ $message }}</span>@enderror
					</div>

					<div class="d-flex flex-wrap justify-content-between bottom-content">
						<div class="form-check">
							<input type="checkbox" class="form-check-input width-auto" id="check_remeber">
							<label class="form-check-label">Mantenha-me conectado</label>
						</div>
						<a href="{{ URL::to('/admin/forgot-password') }}" class="lost-pass">{{trans('labels.recover_password')}}</a>
					</div>

					<div class="button">
						<button class="btn" type="submit">Acessar</button>
					</div>

					<div class="or"><span>Ou</span></div>
					<div class="alt-option">
						<span class="small-title">Entre com seu email de trabalho</span>
						<a href="javascript:void(0)" class="option-button"><img src="{{ asset('storage/app/public/account-login/google.png')}}" alt="#">Entre com Google</a>
					</div>
						<h4 class="create-account">Ainda não possui conta?<a href="{{ URL::to('/admin/register') }}">Criar Conta </a>
						</h4>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection