<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Oneoutlet.site, onde qualquer pessoa pode realizar marketing de forma fácil e simples através do whatsapp. Apresse-se e comece a comercializar. Função de bot automatizada, conversa rápida com os clientes. Brasil">
	<title>{{ Helper::admininfo()->website_title }}</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" type="image/x-icon" href="{{ Helper::admininfo()->favicon }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/bootstrap.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/lineicons.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/tiny-slider.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/animate.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/first.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/first_custom.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/glightbox.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/assets/owlcarousel/assets/owl.carousel.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/assets/owlcarousel/assets/owl.theme.default.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('resources/views/front/landing/layout/landing.css')}}">
	<script type="text/javascript" src="{{ asset('storage/app/public/assets/vendors/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('storage/app/public/assets/vendors/plugin.js') }}"></script>
	<script type="text/javascript" src="{{ asset('storage/app/public/front/js/owl.carousel.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('storage/app/public/landing/js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('storage/app/public/landing/js/wow.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('storage/app/public/landing/js/tiny-slider.js') }}"></script>
	<script type="text/javascript" src="{{ asset('storage/app/public/landing/js/count-up.min.js') }}"></script>
	<script src="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.js')}}" type="text/javascript"></script>
	<script type="text/javascript" src="{{ asset('storage/app/public/landing/js/first.js') }}"></script>
</head>
<body>

	@include('front.landing.layout.header')

	<section class="hero-area">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-5 col-md-12 col-12 wow fadeInDown hero_desc" data-wow-delay=".4s">
					<div class="hero-content">
						<h3>Wa Whatsapp Marketing</h3>
						<h1>Venda e atenda com Chatbots pelo WhatsApp</h1>
						<p>SOFTWARE DE MARKETING EMPRESARIAL WHATSAPP</p>
						<div class="button">
							<a href="{{ route('home') }}" class="btn ">Teste Grátis</a>
						</div>
					</div>
				</div>

				<div class="col-lg-7 col-12">
					<div class="hero-image wow fadeInRight hero_logo" data-wow-delay=".6s">
						<img class="main-image" src="{{asset('storage/app/public/landing/img/first_header.png')}}" alt="#" data-xblocker="passed" style="visibility: visible;">
					</div>
				</div>
			</div>
		</div>
	</section>

	@include('front.landing.layout.features')

	@include('front.landing.layout.services')

	@include('front.landing.layout.tutorials')	

	@include('front.landing.layout.team')

	@include('front.landing.layout.clients')

	<!-- @include('front.landing.layout.blogs') -->

	@include('front.landing.layout.plans')

	@include('front.landing.layout.faq')

	@include('front.landing.layout.contact')

	@include('front.landing.layout.download')

	@include('front.landing.layout.footer')

	<a href="#" class="scroll-top" style="display: none;">
		<i class="lni lni-chevron-up"></i>
	</a>

	<div id="contact_loader" style="display: none;">
		<div class="contact_loader">
		    <div class="box">
		        <div class="circle"></div>
		    </div>
		    <div class="box">
		        <div class="circle"></div>
		    </div>
		</div>
	</div>
</body>
<script type="text/javascript">
	toastr.options = {
	  "closeButton": true,
	  "progressBar": true,
	  "timeOut": 5000
	}

	@if(Session::has('success'))
	toastr.options = {
	  "closeButton": true,
	  "progressBar": true
	}
	toastr.success("{{ session('success') }}");
	@endif

	@if(Session::has('error'))
	toastr.options = {
	  "closeButton": true,
	  "progressBar": true,
	  "timeOut": 10000
	}
	toastr.error("{{ session('error') }}");
	@endif

	function ErrorMsg(str) {
      toastr.error("Erro!", str);
	}
	var owl = $('.owl-carousel');
	owl.owlCarousel({
	    loop:true,
	    nav:true,
	    margin:10,
	    responsive:{
	        0:{
	            items:1
	        },
	        600:{
	            items:2
	        },
	        960:{
	            items:3
	        }
	    }
	});
	owl.on('mousewheel', '.owl-stage', function (e) {
    if (e.deltaY>0) {
        owl.trigger('next.owl');
    } else {
        owl.trigger('prev.owl');
    }
    e.preventDefault();
	});

	$('#btn_contact_form').click(function(e) {
		e.preventDefault();

		var name = $("#contact_name").val().trim();
		var email = $("#contact_email").val().trim();
		var title = $("#contact_subject").val().trim();
		var message = $("#contact_message").val().trim();

		if (name == "") {
			ErrorMsg("{{trans('messages.user_name_required')}}");
			return;
		}

		if (!validateEmail(email)) {
			ErrorMsg("{{trans('messages.invalid_email')}}");
			return;
		}
		
		if (title == '') {
			ErrorMsg('Você deve inserir um assunto');
			return;
		}

		if (message.length < 30) {
			ErrorMsg('Você deve enviar uma mensagem com no mínimo 30 caracteres.');
			return;
		}
		
		$('#contact_loader').css('display', 'block');
		$('#btn_contact_form').prop("disabled", true);

		$.ajax({
			headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
		    url: "{{ URL::to('contact/sendMsg') }}",
		    type: 'POST',
		    dataType: 'json',
		    data: {
		        name: name,
		        email: email,
		        title: title,
		        message: message
		    },
		    success: function(response) {
		        if (response.status == 1) {
		            $('#btn_contact_form').prop("disabled", false);
		            $('#contact_loader').css('display', 'none');
		            toastr.success("Sucesso!", "Sua mensagem foi enviada com sucesso!");
		            window.location.reload();
		        }
		    },
		    error: function(error) {
		        $('#btn_contact_form').prop("disabled", false);
		        $('#contact_loader').css('display', 'none');
		        ErrorMsg("Falha ao enviar mensagem!!!");
		    }
		});
	});

	const validateEmail = (email) => {
		return String(email)
			.toLowerCase()
			.match(
			  /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
		);
	};
</script>
</html>