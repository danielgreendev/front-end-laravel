@extends('admin.layout.main')

@section('page_title')
	{{trans('labels.categories')}} | {{trans('labels.add')}}
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
	                    <form class="form form-horizontal form-bordered" action="{{URL::to('vendor/categories/store')}}" method="POST" enctype="multipart/form-data">
	                    	@csrf
	                    	<div class="form-body">
	                    		<h4 class="form-section"></h4>
	                    		<div class="row">
	                    			<div class="col-md-12">
				                        <div class="form-group row last">
				                        	<label class="col-md-1 label-control" for="name">{{trans('labels.name')}}</label>
				                        	<div class="col-md-11">
				                            	<input type="text" class="form-control" placeholder="{{trans('labels.enter_name')}}" name="name" id="name">
				                            	@error('name')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
				                            </div>
				                        </div>
				                        <!-- <div class="form-group row last">
				                        	<label class="col-md-1 label-control" for="name">{{trans('labels.category_type')}}</label>
					                        <div class="form-group col-md-11">
			                                    <select id="category_type" name="category_type" class="form-control">
			                                        <option selected value="0">{{trans('labels.normal')}}</option>
			                                        <option value="1">{{trans('labels.drink')}}</option>
			                                    </select><br/>
			                                    <span>{{trans('labels.category_desc')}}</span>
			                                </div>
		                            	</div> -->
				                    </div>
		                        </div>

							</div>

	                        <div class="form-actions left">
	                        	<a type="button" class="btn btn-raised btn-warning mr-1" href="{{route('menus')}}"><i class="ft-x"></i> {{trans('labels.cancel')}}</a>

	                        	@if (env('Environment') == 'sandbox')
	                        		<button type="button" class="btn btn-raised btn-primary" onclick="myFunction()"><i class="fa fa-check-square-o"></i> {{trans('labels.add')}} </button>
	                        	@else
	                        	    <button type="submit" class="btn btn-raised btn-primary"><i class="fa fa-check-square-o"></i> {{trans('labels.add')}} </button>
	                        	@endif	                            
	                        </div>
	                    </form>

	                </div>
	            </div>
	        </div>
	    </div>
	</div>

@endsection