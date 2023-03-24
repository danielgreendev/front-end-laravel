<!DOCTYPE html>
<html>
<head>
	@yield('header')
	<link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/css/app.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.css')}}">
	<script src="{{ asset('storage/app/public/admin-assets/js/jquery-3.6.0.js')}}"></script>
	<script src="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.js')}}" type="text/javascript"></script>
</head>
<body>
<div class="preloader" style="opacity: 0; display: none;">
	<div class="preloader-inner">
		<div class="preloader-icon">
			<span></span>
			<span></span>
		</div>
	</div>
</div>

	@yield('content')

	<!-- @include('front.landing.layout.footer') -->
	
	<a href="#" class="scroll-top" style="display: none;">
		<i class="lni lni-chevron-up"></i>
	</a>

	@yield('scripts')
</body>

<script type="text/javascript">
	// Toaster Success/error Message Start

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

</script>
</html>