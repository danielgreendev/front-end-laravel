@extends('user.main')

@section('header')

@include('user.main_resourse')

@endsection('header')

@section('content')
<div class="preloader" style="opacity: 0; display: none;">
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
					<h1 class="page-title">Redefinir Senha</h1>
					<ul class="breadcrumb-nav">
						<li><a href="/">Home</a></li>
						<li>Redefinir Senha</li>
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
				<form class="card login-form inner-content" action="{{route('admin.newpassword')}}" method="post">
					@csrf
					<div class="card-body">
						<div class="title">
							<h3>Crie uma Nova Senha</h3>
							<p>Deseja mudar sua senha? Sem problema! <br/> Por favor informe seu email de cadastro.</p>
						</div>
					
						<div class="input-head">
							<div class="form-group input-group">
								<label><i class="lni lni-envelope"></i></label>
								<input type="email" class="form-control" name="email" id="email" placeholder="{{trans('labels.enter_email')}}" required>
								@error('email')<span class="text-danger text-left" id="email_error">{{ $message }}</span>@enderror
							</div>
						</div>

						<div class="button" style="margin-top: 20px;">
							<button class="btn" type="submit">Criar nova senha</button>
						</div>

						<h4 class="create-account">Acesse sua conta <a href="{{ URL::to('/admin') }}">Clique aqui</a></h4>
					
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection