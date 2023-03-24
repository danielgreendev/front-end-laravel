@extends('admin.layout.main')

@section('page_title',trans('labels.settings'))

@section('content')
<style>
	html {
		scroll-behavior: smooth;
	}
</style>

<div class="row">
	<div class="col-xl-3">
		<div class="card sticky-top" style="top:30px">
			<div class="list-group list-group-flush list-group-menu" id="useradd-sidenav">
				<a href="#basic_info" class="list-group-item list-group-item-action active">{{trans('labels.basic_info')}}
					<div class="float-end"><i class="ti ti-chevron-right"></i></div>
				</a>
				@if (Auth::user()->type == 2)
				<a href="#theme_settings" class="list-group-item list-group-item-action">{{trans('labels.theme_settings')}}
					<div class="float-end"><i class="ti ti-chevron-right"></i></div>
				</a>
				<a href="#seo_tab" class="list-group-item list-group-item-action">{{trans('labels.seo')}}
					<div class="float-end"><i class="ti ti-chevron-right"></i></div>
				</a>
				<a href="#social_accounts" class="list-group-item list-group-item-action">{{trans('labels.social_accounts')}}
					<div class="float-end"><i class="ti ti-chevron-right"></i></div>
				</a>
				<a href="#whatsapp_message_tab" class="list-group-item list-group-item-action">{{trans('labels.whatsapp_message_settings')}}
					<div class="float-end"><i class="ti ti-chevron-right"></i></div>
				</a>
				@endif
			</div>
		</div>
	</div>
	<div class="col-xl-9">
		@include('admin.settings.admin_settings')
	</div>
</div>

@endsection