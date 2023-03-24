@extends('admin.layout.main')

@section('page_title')
{{trans('labels.coupons')}} | {{trans('labels.add')}}
@endsection

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title" id="bordered-layout-colored-controls">{{trans('labels.add_new')}}</h4>
			</div>
			<div class="card-body">
				<div class="px-3">
					<form class="form form-horizontal form-bordered" action="{{URL::to('admin/coupons/store')}}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="form-body">
							<h4 class="form-section"></h4>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group row">
										<label class="col-md-2 label-control" for="name">{{trans('labels.name')}}</label>
										<div class="col-md-10">
											<input type="text" class="form-control" placeholder="{{trans('labels.enter_name')}}" name="name" id="name">
											@error('name')<span class="text-danger" id="name">{{ $message }}</span>@enderror
										</div>
									</div>

									<div class="form-group row">
										<label class="col-md-2 label-control" for="code">{{trans('labels.code')}}</label>
										<div class="col-md-10">
											<input type="text" class="form-control" placeholder="{{trans('labels.input_couponcode')}}" name="code" id="code">
											@error('code')<span class="text-danger" id="code">{{ $message }}</span>@enderror
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-2 label-control" for="price">{{trans('labels.price')}}</label>
										<div class="col-md-10">
											<input type="number" class="form-control" placeholder="{{trans('labels.enter_price')}}" name="price" id="price" min="1">
											@error('price')<span class="text-danger" id="price">{{ $message }}</span>@enderror
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-2 label-control" for="active_from">{{trans('labels.active_from')}}</label>
										<div class="col-md-10">
											<input type="date" class="form-control" placeholder="{{trans('labels.enter_active_from')}}" name="active_from" id="active_from">
											@error('active_from')<span class="text-danger" id="active_from">{{ $message }}</span>@enderror
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-2 label-control" for="active_to">{{trans('labels.active_to')}}</label>
										<div class="col-md-10">
											<input type="date" class="form-control" placeholder="{{trans('labels.enter_active_to')}}" name="active_to" id="active_to">
											@error('active_to')<span class="text-danger" id="active_to">{{ $message }}</span>@enderror
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-2 label-control" for="limit">{{trans('labels.limit')}}</label>
										<div class="col-md-10">
											<input type="number" class="form-control" placeholder="{{trans('labels.enter_limit')}}" name="limit" id="limit" min="0">
											@error('limit')<span class="text-danger" id="limit">{{ $message }}</span>@enderror
										</div>
									</div>
								</div>
							</div>

						</div>

						<div class="form-actions left">
							<a type="button" class="btn btn-raised btn-warning mr-1" href="{{route('coupons')}}"><i class="ft-x"></i> {{trans('labels.cancel')}}</a>

							<button type="submit" class="btn btn-raised btn-primary"><i class="fa fa-check-square-o"></i> {{trans('labels.add')}} </button>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>

@endsection