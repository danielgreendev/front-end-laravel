@extends('admin.layout.main')

@section('page_title',trans('labels.restaurants'))

@section('content')

	<section id="contenxtual">
	    <div class="row">
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h4 class="card-title">{{trans('labels.restaurants')}}
	                    	@if(Auth::user()->type == 1)
		                        <a href="{{ URL::to('/admin/restaurants/add')}}" class="btn btn-primary btn-sm float-right">{{ trans("labels.add_new") }}</a>
		                    @endif
	                  </h4>
	                </div>
	                <div class="card-body">

	                    <div class="card-block">

	                    	<!-- <form action="{{URL::to('admin/restaurants/fetch')}}">
	                    		<div class="input-group mb-3 col-md-6">
								  	<input type="text" class="form-control" name="query" value="@isset($_GET['query']) {{$_GET['query']}} @endisset" placeholder="{{trans('labels.type_and_enter')}}" aria-label="{{trans('labels.type_and_enter')}}" aria-describedby="basic-addon2">
								  	<div class="input-group-append">
								    	<button class="btn btn-outline-secondary" type="submit">{{trans('labels.go')}}</button>
								  	</div>
								</div>
							</form> -->

	                    	@include('admin.restaurants.restaurants_table')
	                        
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</section>

@endsection
@section('scripts')
	<script src="{{asset('resources/views/admin/restaurants/restaurants.js')}}" type="text/javascript"></script>
@endsection