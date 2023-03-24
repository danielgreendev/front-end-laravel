@extends('admin.layout.main')

@section('page_title',trans('labels.delivery_area'))

@section('content')

	<section id="contenxtual">
	    <div class="row">
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h4 class="card-title">{{trans('labels.delivery_area')}}
	                    	@if(Auth::user()->type == 2)
		                        <a href="{{ URL::to('/vendor/delivery-area/add')}}" class="btn btn-primary btn-sm float-right">{{ trans("labels.add_fee") }}</a>
		                    @endif
	                  </h4>
	                </div>
	                <div class="card-body">

	                    <div class="card-block">

	                    	@include('admin.delivery-area.delivery_area_table')
	                        
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</section>

@endsection
@section('scripts')
	<script src="{{asset('resources/views/admin/delivery-area/delivery-area.js')}}" type="text/javascript"></script>
@endsection