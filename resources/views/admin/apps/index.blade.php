@extends('admin.layout.main')

@section('page_title',trans('labels.apps'))

@section('content')

<section id="contenxtual">
	<a href="{{URL::to('admin/createsystem-addons')}}" class="btn btn-primary">{{trans('labels.install_update_addon')}}</a>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<!-- Nav tabs -->
					<div class="default-tab">
						<ul class="nav nav-tabs mb-3" role="tablist">
							<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#installed">{{trans('labels.installed_addon')}}</a>
							</li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#available">{{trans('labels.available_addon')}}</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade show active" id="installed" role="tabpanel">
								<div class="row">
									@forelse(App\Models\SystemAddons::all() as $key => $addon)
									<div class="col-md-6 col-lg-3">
										<div class="card">
											<img class="img-fluid" src='{!! asset("storage/app/public/addons/".$addon->image) !!}' alt="">
											<div class="card-body">
												<h5 class="card-title mt-3">{{ ucfirst($addon->name) }}</h5>
											</div>
											<div class="card-footer bg-white">
												<p class="card-text d-inline"><small class="text-muted">{{trans('labels.version')}} : {{ $addon->version }}</small></p>

												@if($addon->activated)
												<a href="#" class="btn btn-sm btn-primary float-right" onclick="StatusUpdate('{{$addon->id}}','0')">{{trans('labels.activated')}}</a>
												@else
												<a href="#" class="btn btn-sm btn-danger float-right" onclick="StatusUpdate('{{$addon->id}}','1')">{{trans('labels.deactivated')}}</a>
												@endif
											</div>
										</div>
									</div>
									<!-- End Col -->
									@empty
									<div class="col-md-6 col-lg-3 mt-4">
										<h4>{{trans('labels.no_addon_installed')}}</h4>
									</div>
									@endforelse
								</div>
							</div>
							<div class="tab-pane fade" id="available">
								<div class="p-t-15">
									<?php
									$payload = file_get_contents('https://gravityinfotech.net/api/addonsapi.php?type=gravity&item=restro');
									$obj = json_decode($payload);
									?>
									<div class="row">
										@foreach($obj->data as $item)
										<div class="col-md-6 col-lg-3">
											<div class="card">
												<img class="img-fluid" src='{{$item->image}}' alt="">
												<div class="card-body">
													<h5 class="card-title mt-3">{{$item->name}}</h5>
												</div>
												<div class="card-footer bg-white">
													<span class="btn btn-sm btn-success float-right">{{trans('labels.free_with_extended_license')}}</span>
												</div>
											</div>
										</div>
										@endforeach
									</div>
									<!-- End Col -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-12 m-b-30">

			<div class="row mt-4">

			</div>
		</div>
	</div>
</section>

<input type="hidden" name="email" id="email" value="{{Helper::getrestaurant(Auth::user()->slug)->email}}">
<input type="hidden" name="mobile" id="mobile" value="{{Helper::getrestaurant(Auth::user()->slug)->mobile}}">
<input type="hidden" name="name" id="name" value="{{Helper::getrestaurant(Auth::user()->slug)->name}}">

@endsection
<script type="text/javascript">
	function StatusUpdate(id, status) {
		swal({
				title: "{{ trans('messages.are_you_sure') }}",
				type: 'warning',
				showCancelButton: true,
				confirmButtonText: "{{ trans('messages.yes') }}",
				cancelButtonText: "{{ trans('messages.no') }}",
				closeOnConfirm: false,
				closeOnCancel: false,
				showLoaderOnConfirm: true,
			},
			function(isConfirm) {
				if (isConfirm) {
					$.ajax({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						url: "{{ URL::to('admin/systemaddons/update') }}",
						data: {
							id: id,
							status: status
						},
						method: 'POST',
						success: function(response) {
							if (response == 1) {
								location.reload();
							} else {
								swal("Cancelled", "{{ trans('messages.wrong') }} :(", "error");
							}
						},
						error: function(e) {
							swal("Cancelled", "{{ trans('messages.wrong') }} :(", "error");
						}
					});
				} else {
					swal("Cancelled", "{{ trans('messages.record_safe') }} :)", "error");
				}
			});
	}
</script>