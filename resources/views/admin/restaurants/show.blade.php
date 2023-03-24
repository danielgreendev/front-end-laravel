@extends('admin.layout.main')

@section('page_title')
{{trans('labels.restaurants')}} | {{trans('labels.update')}}
@endsection

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title" id="bordered-layout-colored-controls">{{trans('labels.update')}}</h4>
			</div>
			<div class="card-body">
				<div class="px-3">
					<form class="form form-horizontal form-bordered" action="{{URL::to('admin/restaurants/update-'.$rdata->slug)}}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="form-body">
							<h4 class="form-section"></h4>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group row">
										<label class="col-md-2 label-control" for="name">{{trans('labels.name')}}</label>
										<div class="col-md-10">
											<input type="text" class="form-control" value="{{$rdata->name}}" placeholder="{{trans('labels.enter_name')}}" name="name" id="name">
											@error('name')<span class="text-danger">{{ $message }}</span>@enderror
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-2 label-control" for="email">{{trans('labels.email')}}</label>
										<div class="col-md-10">
											<input type="email" class="form-control" value="{{$rdata->email}}" placeholder="{{trans('labels.enter_email')}}" name="email" id="email">
											@error('email')<span class="text-danger">{{ $message }}</span>@enderror
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-2 label-control" for="mobile">{{trans('labels.mobile')}}</label>
										<div class="col-md-10">
											<input type="tel" class="form-control" value="{{$rdata->mobile}}" id="mobile" name="mobile" placeholder="{{trans('labels.enter_mobile')}}">
											@error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="form-actions left">
							<a type="button" class="btn btn-raised btn-warning mr-1" href="{{route('restaurants')}}"><i class="ft-x"></i> {{trans('labels.cancel')}}</a>

							@if (env('Environment') == 'sandbox')
							<button type="button" class="btn btn-raised btn-primary" onclick="myFunction()"><i class="fa fa-check-square-o"></i> {{trans('labels.update')}} </button>
							@else
							<button type="submit" class="btn btn-raised btn-primary"><i class="fa fa-check-square-o"></i> {{trans('labels.update')}} </button>
							@endif
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('scripts')
<script src="{{asset('resources/views/admin/restaurants/restaurants.js')}}" type="text/javascript"></script>
@endsection