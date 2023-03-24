@extends('admin.layout.main')

@section('page_title',trans('labels.share'))

@section('content')
<?php
	$isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile"));
	// @if($isMob == "1") "WhatsApp";
?>

<section id="contenxtual">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title text-center">{{trans('labels.share_heading')}}
					</h4>
				</div>
				<div class="card-body">

					<div class="card-block text-center">

						<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{URL::to('/')}}/{{Auth::user()->slug}}&choe=UTF-8" title="Link to Google.com" />

						<div class="card-block">
							@if($isMob == "1")
                              <a href="whatsapp://send/send?text={{URL::to('/')}}/{{Auth::user()->slug}}" target="_blank" class="btn btn-social btn-min-width btn-adn-flat mr-2 mb-2 btn-adn btn_icon"><i class="fa-brands fa-whatsapp text-wa-color"></i> {{trans('labels.whatsapp')}}</a>
                              @else
                              <a href="https://web.whatsapp.com/send?text={{URL::to('/')}}/{{Auth::user()->slug}}" target="_blank" class="btn btn-social btn-min-width btn-adn-flat mr-2 mb-2 btn-adn btn_icon"><i class="fa-brands fa fa-whatsapp text-wa-color"></i>{{trans('labels.whatsapp')}}</a>
                              @endif

							<a href="https://www.facebook.com/sharer.php?u={{URL::to('/')}}/{{Auth::user()->slug}}" target="_blank" class="btn btn-social btn-min-width btn-facebook-flat mr-2 mb-2 btn-facebook btn_icon"><span class="fa-brands fa-facebook"></span> {{trans('labels.facebook')}}</a>


							<a href="http://twitter.com/share?text={{Auth::user()->name}}&url={{URL::to('/')}}/{{Auth::user()->slug}}&hashtags=restaurant,whatsapporder,onlineorder" target="_blank" class="btn btn-social btn-min-width btn-twitter-flat mr-2 mb-2 btn-twitter btn_icon"><span class="fa-brands fa-twitter"></span> {{trans('labels.twitter')}}</a>

							<a href="https://www.linkedin.com/shareArticle?mini=true&url={{URL::to('/')}}/{{Auth::user()->slug}}" target="_blank" class="btn btn-social btn-min-width btn-linkedin-flat mr-2 mb-2 btn-linkedin btn_icon"><span class="fa-brands fa-linkedin"></span> {{trans('labels.linkedin')}}</a>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<link rel="stylesheet" type="text/css" href="{{asset('resources/views/admin/dashboard/home.css')}}">
@endsection