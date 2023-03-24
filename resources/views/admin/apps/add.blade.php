@extends('admin.layout.main')

@section('page_title')
	{{trans('labels.apps')}} | {{trans('labels.add')}}
@endsection

@section('content')
	
	<div class="row">
		<div class="col-md-12">
	        <div class="card">
	            <div class="card-header">
	                <h4 class="card-title" id="bordered-layout-colored-controls">{{trans('labels.install_addon')}}</h4>
	            </div>
	            <div class="card-body">
	                <div class="px-3">
	                    <form method="post" action="{{ URL::to('admin/systemaddons/store')}}" name="about" id="about" enctype="multipart/form-data">
	                        @csrf

	                        <div class="row">
	                            <div class="col-sm-3 col-md-12">
	                                <div class="form-group">
	                                    <label for="addon_zip" class="col-form-label">{{trans('labels.zip_file')}}</label>
	                                    <input type="file" class="form-control" name="addon_zip" id="addon_zip" required="">
	                                </div>
	                            </div>
	                        </div>
	                        
	                        <button type="submit" class="btn btn-primary">{{trans('labels.install')}}</button>
	                    </form>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

@endsection