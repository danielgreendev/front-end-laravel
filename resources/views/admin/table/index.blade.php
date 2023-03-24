@extends('admin.layout.main')

@section('page_title',trans('labels.book_table'))

@section('content')

	<section id="contenxtual">
	    <div class="row">
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h4 class="card-title">{{trans('labels.book_table')}}
	                  </h4>
	                </div>
	                <div class="card-body">

	                    <div class="card-block">

	                    	@include('admin.table.booking_table')
	                        
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</section>

@endsection