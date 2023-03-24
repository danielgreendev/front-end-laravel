@extends('admin.layout.main')

@section('page_title')
{{trans('labels.categories')}} | {{trans('labels.update')}}
@endsection

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title" id="bordered-layout-colored-controls">{{trans('labels.update')}} {{trans('labels.category')}}</h4>
			</div>
			<div class="card-body">
				<div class="px-3">
					<form class="form form-horizontal form-bordered" action="{{URL::to('vendor/delivery-area/update-'.$cdata->slug)}}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="form-body">
							<h4 class="form-section"></h4>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group row">
										<label class="col-md-1 label-control" for="name">{{trans('labels.name')}}</label>
										<div class="col-md-11">
											<input type="text" class="form-control" name="name" id="name" value="{{$cdata->name}}" placeholder="{{trans('labels.enter_name')}}">
											@error('name')<span class="text-danger" id="name">{{ $message }}</span>@enderror
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group row">
										<label class="col-md-1 label-control" for="price">{{trans('labels.price')}}</label>
										<div class="col-md-11">
											<input type="text" class="form-control" name="price" id="price" value="{{$cdata->price}}" placeholder="{{trans('labels.enter_price')}}">
											@error('price')<span class="text-danger" id="price">{{ $message }}</span>@enderror
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="form-actions left">
							<a type="button" class="btn btn-raised btn-warning mr-1" href="{{route('delivery-area')}}"><i class="ft-x"></i> {{trans('labels.cancel')}}</a>

							<button type="submit" class="btn btn-raised btn-primary"><i class="fa fa-check-square-o"></i> {{trans('labels.update')}} </button>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>

@endsection