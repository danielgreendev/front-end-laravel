@extends('admin.layout.main')

@section('page_title')
	{{trans('labels.pricing_plans')}} | {{trans('labels.update')}}
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
	                    <form class="form form-horizontal form-bordered" action="{{URL::to('admin/plans/update-'.$pdata->id)}}" method="POST" enctype="multipart/form-data">
	                    	@csrf
	                    	<input type="hidden" name="id" value="{{$pdata->id}}">
	                    	<div class="form-body">
	                    		<h4 class="form-section"></h4>
	                    		<div class="row">
	                    			<div class="col-md-12">
				                        <div class="form-group row">
				                        	<label class="col-md-2 label-control" for="name">{{trans('labels.name')}}</label>
				                        	<div class="col-md-10">
				                            	<input type="text" class="form-control" placeholder="{{trans('labels.enter_name')}}" name="name" id="name" value="{{$pdata->name}}">
				                            	@error('name')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
				                            </div>
				                        </div>
				                    </div>

				                    <div class="col-md-12">
				                        <div class="form-group row">
				                        	<label class="col-md-2 label-control" for="description">{{trans('labels.description')}}</label>
				                        	<div class="col-md-10">
				                            	<input type="text" class="form-control" placeholder="{{trans('labels.enter_description')}}" name="description" id="description" value="{{$pdata->description}}">
				                            	@error('description')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
				                            </div>
				                        </div>
				                    </div>

				                    <div class="col-md-12">
				                        <div class="form-group row">
				                        	<label class="col-md-2 label-control" for="features">{{trans('labels.features')}}</label>
				                        	<div class="col-md-10">
				                            	<input type="text" class="form-control" placeholder="{{trans('labels.comma_separated')}}" name="features" id="features" value="{{$pdata->features}}">
				                            	@error('features')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
				                            </div>
				                        </div>
				                    </div>

				                    <div class="col-md-12">
				                        <div class="form-group row">
				                        	<label class="col-md-2 label-control" for="price">{{trans('labels.price')}}</label>
				                        	<div class="col-md-10">
				                            	<input type="text" class="form-control" placeholder="{{trans('labels.enter_price')}}" name="price" id="price" value="{{$pdata->price}}">
				                            	@error('price')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
				                            </div>
				                        </div>
				                    </div>

				                    <div class="col-md-12">
				                        <div class="form-group row">
				                        	<label class="col-md-2 label-control" for="plan_period">{{trans('labels.plan_period')}}</label>
				                        	<div class="col-md-10">
				                        		<select class="form-control" name="plan_period" id="plan_period">
																			<option value="">{{trans('labels.select')}}</option>
																			<option value="5" {{$pdata->plan_period == "5"  ? 'selected' : ''}}>{{trans('labels.7_days')}}</option>
																			<option value="1" {{$pdata->plan_period == "1"  ? 'selected' : ''}}>{{trans('labels.1_month')}}</option>
																			<option value="2" {{$pdata->plan_period == "2"  ? 'selected' : ''}}>{{trans('labels.3_month')}}</option>
																			<option value="3" {{$pdata->plan_period == "3"  ? 'selected' : ''}}>{{trans('labels.6_month')}}</option>
																			<option value="4" {{$pdata->plan_period == "4"  ? 'selected' : ''}}>{{trans('labels.1_year')}}</option>
				                        		</select>
				                            	@error('plan_period')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
				                            </div>
				                        </div>
				                    </div>

				                    <div class="col-md-12">
				                        <div class="form-group row">
				                        	<label class="col-md-2 label-control" for="item_unit">{{trans('labels.item_limit')}}</label>
				                        	<div class="col-md-10">
				                            	<input type="text" class="form-control" placeholder="{{trans('labels.enter_item_limit')}}" name="item_unit" id="item_unit" value="{{$pdata->item_unit}}">
				                            	@error('item_unit')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
				                            </div>
				                        </div>
				                    </div>

				                    <div class="col-md-12">
				                        <div class="form-group row">
				                        	<label class="col-md-2 label-control" for="order_limit">{{trans('labels.order_limit')}}</label>
				                        	<div class="col-md-10">
				                            	<input type="text" class="form-control" placeholder="{{trans('labels.order_limit')}}" name="order_limit" id="order_limit" value="{{$pdata->order_limit}}">
				                            	@error('order_limit')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
				                            </div>
				                        </div>
				                    </div>
		                       </div>

												</div>

	                        <div class="form-actions left">
	                            <a type="button" class="btn btn-raised btn-warning mr-1" href="{{ URL::to('/admin/plans')}}"><i class="ft-x"></i> {{trans('labels.cancel')}}</a>
	                            @if (env('Environment') == 'sandbox')
	                              	<button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"><i class="fa fa-check-square-o"></i> {{trans('labels.update')}} </button>
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