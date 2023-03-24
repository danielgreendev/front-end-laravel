<div class="preloader">
	<div class="preloader-inner">
		<div class="preloader-icon">
			<span></span>
			<span></span>
		</div>
	</div>
</div>

<link rel="stylesheet" type="text/css" href="{{asset('resources/views/user/layout/header.css')}}">

	<header class="header navbar-area">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-12">
					<div class="nav-inner">
						<nav class="navbar navbar-expand-lg wow zoomIn header_time" data-wow-delay=".2s">
							<a class="navbar-brand" href="#">
								<img class="first_logo" src="{{ asset('storage/app/public/landing/img/logo.png') }}" alt="logo">
							</a>
							<!-- <button class="navbar-toggler mobile-menu-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
								<span class="toggler-icon"></span>
								<span class="toggler-icon"></span>
								<span class="toggler-icon"></span>
							</button> -->

							<div class="navbar-text">
								<h5>
									Para gerenciar seu Delivery, atualizar ou criar seu Menu digital acesse o Painel de Administração.
								</h5>
							</div>
							<!-- <div class="navbar-collapse sub-menu-bar collapse" id="navbarSupportedContent">
								<ul id="nav" class="navbar-nav ms-auto">
									<li class="nav-item">
										<a href="#" class="active" aria-label="Toggle navigation">Home</a>
									</li>
									<li class="nav-item">
										<a href="#" class="" aria-label="Toggle navigation">About</a>
									</li>
									<li class="nav-item">
										<a href="#" class="active dd-menu collapsed"data-bs-toggle="collapse" data-bs-target="#submenu-1-1" aria-controls="navbarSupportedContent"  aria-label="Toggle navigation">Pages</a>

										<ul class="sub-menu collapse" id="submenu-1-1">
											<li class="nav-item"><a href="#">Document</a></li>
											<li class="nav-item"><a href="#">Our Pricing</a></li>
											<li class="nav-item"><a href="#">About Us</a></li>
											<li class="nav-item"><a href="{{ URL::to('admin/logout') }}">Sign Out</a></li>
											<li class="nav-item"><a href="#">Mail Success</a></li>
											<li class="nav-item"><a href="#">404 Error</a></li>
										</ul>
									</li>
									
									<li class="nav-item">
										<a class="dd-menu collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-1-2" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">Blog</a>
										<ul class="sub-menu collapse" id="submenu-1-2">
											<li class="nav-item"><a href="#">Blog Grid</a></li>
											<li class="nav-item"><a href="#">Blog Single</a></li>
										</ul>
									</li>

									<li class="nav-item">
										<a href="#" aria-label="Toggle navigation">Contact</a>
									</li>

								</ul>
							</div> -->
							<div class="button home-btn" id="btn_business">
								@if(Auth::user()->type == 1 || Auth::user()->type == 2)
								<a href="{{route('dashboard')}}" class="btn">Painel Administrativo</a>
								@else
								<a href="#" class="btn">Painel Administrativo</a>
								@endif
							</div>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</header>

	<script type="text/javascript">
			$("#btn_business").click(function (){
				@if (Auth::user()->type == 3)
					ErrorMsg("{{trans('labels.business_not_avilable')}}");
				@endif
			});
	</script>