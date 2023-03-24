@extends('admin.layout.main')

@section('page_title',trans('labels.transaction'))

@section('content')

<section id="contenxtual">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="horz-layout-colored-controls">{{trans('labels.transaction')}}</h4>
                </div>

                <div class="card-body collapse show">
                	<div class="card-block card-dashboard" id="table-display">
		                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
		                    <div class="row">
                            	<div class="col-sm-12 transaction_table">

		                    	@include('admin.transaction.transaction_table')

		                        </div>
		                    </div>
		                </div>
		            </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('scripts')
	<script src="{{asset('resources/views/admin/transaction/transaction.js')}}" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="{{asset('resources/views/admin/transaction/transaction.css')}}">
@endsection