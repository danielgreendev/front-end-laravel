<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Oneoutlet.site, Documentos. Brasil">
	<title>{{ Helper::admininfo()->website_title }}</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" type="image/x-icon" href="{{ Helper::admininfo()->favicon }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/bootstrap.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/first.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/docs.css') }}" />

	<script type="text/javascript" src="{{ asset('storage/app/public/assets/vendors/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('storage/app/public/landing/js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('storage/app/public/landing/js/docs.js') }}"></script>
</head>
<body>
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
							<button type="button" class="navbar-toggler mobile-menu-btn collapsed" id="sidebarCollapse">
	                <span class="toggler-icon"></span>
									<span class="toggler-icon"></span>
	            </button>
							<a class="navbar-brand" href="#">
								<img class="docs_logo" src="{{ asset('storage/app/public/landing/img/logo.png') }}" alt="logo">
							</a>
							<button class="navbar-toggler mobile-menu-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
								<span class="toggler-icon"></span>
								<span class="toggler-icon"></span>
								<span class="toggler-icon"></span>
							</button>

							<div class="navbar-collapse sub-menu-bar collapse" id="navbarSupportedContent">
								<ul id="nav" class="navbar-nav ms-auto">
									<li class="nav-item">
										<a href="{{route('front.landing.first')}}" class="active" aria-label="Toggle navigation">Home</a>
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
						</nav>
					</div>
				</div>
			</div>
		</div>
	</header>

	<div class="wrapper">
		<!-- Sidebar  -->
		<!-- <nav id="sidebar">
	    <div class="sidebar-header">
	        <h3>Bootstrap Sidebar</h3>
	    </div>

	    <ul class="list-unstyled components">
	      <p>Demonstração</p>
	      <li class="active">
	          <a href="#homeSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Home</a>
	          <ul class="collapse" id="homeSubmenu">
	              <li>
	                  <a href="#">Home</a>
	              </li>
	              <li>
	                  <a href="#">Home 2</a>
	              </li>
	              <li>
	                  <a href="#">Home 3</a>
	              </li>
	          </ul>
	      </li>
	      <li>
	          <a href="#pageSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pagamento</a>
	          <ul class="collapse" id="pageSubmenu">
	              <li>
	                  <a href="#">PayPal</a>
	              </li>
	          </ul>
	      </li>
	      <li>
	          <a href="#">Contact</a>
	      </li>
	      <li>
	          <a href="#">About</a>
	      </li>
	  	</ul>

	    <ul class="list-unstyled CTAs">
	        <li>
	            <a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Download source</a>
	        </li>
	        <li>
	            <a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a>
	        </li>
	    </ul>
	  </nav> -->

		<div class="docs_body" id="content">
			<div class="docs_body_header">
				<h1 class="dx-content-title" id="accept-payments">Como gerar as chaves API PayPal?</h1>
			</div>
			<div class="docs_body_main">
					<p>Para receber pagamentos diretamente na sua conta, é necessário que você insira na configuração de pagamentos do Menu digital as chaves API PayPal.</p>
				<br>
				<p>
					Você deverá coletar essas informações em sua plataforma PayPal e aplicar nos campos abaixo do seu Painel de Administração do Menu digital:
				</p>
				<br>
				<img src="{{asset('storage/app/public/docs/Payment_paypal_setting.png')}}">
				<br><br>
				<div>
					<p>
						Acesse sua conta PayPal empresa e siga as instruções deixadas pelo time PayPal no link abaixo:
					</p>
					<a class="paypal_instruction" href="https://www.paypal.com/br/smarthelp/article/como-fa%C3%A7o-para-solicitar-minhas-credenciais-de-certificado-ou-assinatura-da-api-faq3196" target="_blank">INSTRUÇÕES PAYPAL</a>
					<p>
						Lembre-se de que a API do PayPal está disponível apenas se você tiver uma conta PayPal comercial. Em primeiro lugar, no tutorial abaixo, daremos instruções de como criar uma conta comercial Paypal.
					</p>

					<div class="steps">
						<p class="step">
							<b>Etapa 1.</b> Cadastre-se no <a href="https://www.paypal.com/br/webapps/mpp/home" target="_blank">PayPal.</a>
						</p>
						<p class="step">
							<b>Etapa 2.</b> Você terá que fornecer informações sobre você primeiro: seu nome, sobrenome, e-mail comercial e senha.
						</p>
						<p class="step">
							<b>Etapa 3.</b> Depois disso, você deve fornecer detalhes sobre a empresa: seu nome legal, número de telefone e endereço.
						</p>
						<p class="step">
							<b>Etapa 4.</b> Além disso, você deve selecionar seu tipo de negócio entre as seguintes opções: Individual, Empresa Individual, Parceria, Corporação, Empresa Privada, Empresa Pública, Organização sem fins lucrativos, Entidade governamental.
							<p>Em seguida, descreva sua empresa com mais detalhes e responda a várias perguntas:</p>
							<p>Clique em “Enviar”. Então, conte sobre você.</p>
						</p>
						<p class="step">
							<b>Etapa 5.</b> Depois disso, você terá que escolher a finalidade da sua conta do PayPal. Você pode usá-lo para solicitar ou enviar dinheiro, enviar uma fatura aos clientes ou oferecer o pagamento do PayPal no site. Escolha Configurar pagamentos online. Agora, você está na metade do caminho antes de obter sua chave do PayPal.
						</p>
					</div>
				</div>
			</div>

			<div class="docs_body_header">
				<h1 class="dx-content-title" id="accept-payments">Obter assinatura ou certificado da API do PayPal</h1>
			</div>
			<div class="docs_body_main">
				<div>
					<p>Nossa próxima etapa é gerar credenciais de assinatura de API do PayPal ou credenciais de certificado de API. Se você hesitar em qual escolher, aqui está nossa explicação de sua diferença:</p>
					<p>A assinatura da API do PayPal inclui um nome de usuário da API, senha da API e assinatura, que não expiram. </p>
					<p>As credenciais do certificado API incluem um nome de usuário API no PayPal, senha API e certificado, que expiram automaticamente após três anos.</p>
					<p>Lembre-se de que, para obter credenciais de API no PayPal, você deve ter um endereço de e-mail verificado.</p>
					<p>É assim que você deve obter as credenciais de assinatura ou certificado da API para sua conta do PayPal:</p>
					<div class="steps">
						<p class="step">
							<b>1.</b> Faça login na sua conta do PayPal Sandbox, use os dados do seu perfil comercial.
						</p>
						<p class="step">
							<b>2.</b> Clique no ícone "Configurações".
						</p>
						<p class="step">
							<b>3.</b> Clique em Acesso à conta em “Conta e segurança” à esquerda da página.
						</p>
						<p class="step">
							<b>4.</b> Na seção "Acesso à API", clique em "Atualizar".
						</p>
						<p class="step">
							<b>5.</b> Clique em “Gerenciar credenciais de API” em “Integração NVP/SOAP API”.
						</p>
						<p class="step">
							<b>6.</b> Selecione uma das seguintes opções. Solicitar assinatura de API – selecione para autenticação de assinatura de API. Solicitar certificado de API – selecione para autenticação de certificado de API.
						</p>
						<p class="step">
							<b>7.</b> Clique em “Concordo” e “Enviar”.
						</p>
						<p class="step">
							<b>8.</b> É isso! Depois disso, o PayPal gerará suas credenciais de API.
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>