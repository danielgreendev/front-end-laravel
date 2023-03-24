<div class="preloader">
	<div class="preloader-inner">
		<div class="preloader-icon">
			<span></span>
			<span></span>
		</div>
	</div>
</div>
	
<header class="header navbar-area">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-12">
				<div class="nav-inner">
					<nav class="navbar navbar-expand-lg wow zoomIn header_time" data-wow-delay=".2s">
						<a class="navbar-brand" href="#">
							<img class="first_logo" src="{{ asset('storage/app/public/landing/img/logo.png') }}" alt="logo">
						</a>
						<button class="navbar-toggler mobile-menu-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="toggler-icon"></span>
							<span class="toggler-icon"></span>
							<span class="toggler-icon"></span>
						</button>

						<div class="navbar-collapse sub-menu-bar collapse" id="navbarSupportedContent">
							<ul id="nav" class="navbar-nav ms-auto">
								<li class="nav-item">
									<a href="#" class="active" aria-label="Toggle navigation">Home</a>
								</li>

								<li class="nav-item">
									<a href="#" class="active dd-menu collapsed"data-bs-toggle="collapse" data-bs-target="#submenu-1-1" aria-controls="navbarSupportedContent"  aria-label="Toggle navigation">Gerenciamento de delivery</a>

									<ul class="sub-menu collapse" id="submenu-1-1">
										<li class="nav-item"><a href="{{route('front.landing.index')}}">Menu digital</a></li>
										<!-- <li class="nav-item"><a href="{{route('front.restaurants')}}">Lojas</a></li> -->
										<li class="nav-item"><a href="{{ route('home') }}">Já sou cliente</a></li>
										<li class="nav-item"><a href="{{ URL::to('/admin/register') }}">Ainda não sou cliente</a></li>
									</ul>
								</li>

								<li class="nav-item">
									<a href="#" class="active dd-menu collapsed"data-bs-toggle="collapse" data-bs-target="#submenu-1-2" aria-controls="navbarSupportedContent"  aria-label="Toggle navigation">Demonstração</a>
									<ul class="sub-menu collapse" id="submenu-1-2">
										<li class="nav-item"><a href="#features">Sobre</a></li>
										<li class="nav-item"><a href="#services">Funcionalidades</a></li>
										<li class="nav-item"><a href="#tutorial">Tutorial</a></li>
										<li class="nav-item"><a href="#pricing">Planos</a></li>
									</ul>
								</li>

								<li class="nav-item">
									<a href="#contact" aria-label="Toggle navigation">Contato</a>
								</li>
							</ul>
						</div>
						<div class="button home-btn">
							<a href="{{ route('home') }}" class="btn">Teste Grátis</a>
						</div>
					</nav>
				</div>
			</div>
		</div>
	</div>
</header>