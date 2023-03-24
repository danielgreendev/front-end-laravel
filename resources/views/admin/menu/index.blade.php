@extends('admin.layout.main')
@section('page_title',trans('labels.menus'))
@section('content')
	<section id="contenxtual">
	    <div class="row">
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h4 class="card-title"> {{trans('labels.menu_management')}} 
		                    <a href="{{ URL::to('/vendor/categories/add')}}" class="btn btn-primary btn-sm float-right" >{{trans('labels.add_new_category')}}</a>
	                  	</h4>
	                </div>
	            </div>
	        </div>
	    </div>
        @if (\Session::has('danger'))
			<div class="alert alert-danger">
				{!! \Session::get('danger') !!}
			</div>
		@endif
        
	    @foreach($categories as $category)
        <div class="card-block">
        	<div class="alert alert-dark" role="alert">
				<div class="d-flex w-100 justify-content-between mt-3">
			    	<h4>{{$category->name}}</h4>
		        	<div class="form-group">
		                <span class="btn btn-raised btn-outline-success btn-min-width mr-1 mb-1 add-item" data-cat-id="{{$category->id}}" data-category-name="{{$category->name}}">{{trans('labels.add_new_item')}}</span>
		                <a class="btn btn-raised btn-outline-info btn-min-width mr-1 mb-1" href="{{ URL::to('vendor/categories/edit-'.$category->slug) }}">{{trans('labels.update')}}</a>
                        @if (env('Environment') == 'sandbox')
                            <span class="btn btn-raised btn-outline-danger btn-min-width mr-1 mb-1" onclick="myFunction()">{{trans('labels.delete')}}</span>
                        @else
                            <span class="btn btn-raised btn-outline-danger btn-min-width mr-1 mb-1" onclick="deletecategory('{{$category->id}}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('vendor/categories/del') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')">{{trans('labels.delete')}}</span>
                        @endif
		            </div>
                </div>
        	</div>
            <div class="row match-height">
            @foreach($menus as $items)
                @if($items->cat_id == $category->id)
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <a href="{{ URL::to('vendor/item/edit/'.$items->_id) }}">
                            <div class="card card_style">
                                <div class="card-body item_body">
                                    <img class="card-img-top img-fluid img_fit" src="{{asset('storage/app/public/item/'.$items->image)}}" alt="Card image cap">
                                    <div class="card-block mt-3 item_content">
                                        <h4 class="text-dark">{{$items->item_name}}</h4>
                                        <p class="card-text text-secondary">{{$items->description}}</p>
                                    </div>
                                    <div class="item_under">
                                        <span class="badge badge-info">{{Helper::currency_format($items->item_price, Auth::user()->id)}}</span>
                                        @if($items->is_available == "1")
                                            <p class="font-medium-2 success mt-2">{{trans('labels.extra')}}</p>
                                        @else
                                            <p class="font-medium-2 danger mt-2">{{trans('labels.unavailable')}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
    	    	<div class="col-xl-3 col-lg-6 col-md-6 add-item" data-cat-id="{{$category->id}}" data-category-name="{{$category->name}}">
                    <div class="card card_style">
                        <div class="card-body">
                            <img class="card-img-top img-fluid" src="{{ asset('storage/app/public/admin-assets/img/add_new_item.jpg') }}" alt="Card image cap">
                            <div class="card-block">
                                <h4 class="card-title text-center">{{ trans('labels.add_new_item') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    	</div>
    	@endforeach
	</section>
@endsection
<!-- Add Item -->
<div class="modal fade" id="addItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('labels.add_new_item') }}</h5>
                <button type="button" class="close" id="btn_closeItem" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form id="add_item" action="{{ URL::to('vendor/item/store') }}" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <span id="msg"></span>
                @csrf
                <input type="hidden" name="cat_id" id="cat_id" class="form-control">
                <input type="hidden" name="route" id="route" class="form-control" value="{{ URL::to('vendor/item/store') }}">
                <div class="form-group">
                    <label for="category_name" class="col-form-label">{{ trans('labels.category') }}</label>
                    <input type="text" class="form-control" name="category_name" id="category_name" placeholder="{{ trans('labels.enter_category') }}" readonly required>
                    @error('category_name') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="item_name" class="col-form-label">{{ trans('labels.name') }}</label>
                    <input type="text" class="form-control" name="item_name" id="item_name" placeholder="{{ trans('labels.enter_name') }}" required>
                    @error('item_name') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="item_price" class="col-form-label">{{ trans('labels.price') }}</label>
                    <input type="text" class="form-control" name="item_price" id="item_price" placeholder="{{ trans('labels.enter_price') }}" required>
                    @error('item_price') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="description" class="col-form-label">{{ trans('labels.description') }}</label>
                    <input type="text" class="form-control" name="description" id="description" placeholder="{{ trans('labels.enter_description') }}" required>
                    @error('description') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="image" class="col-form-label">{{ trans('labels.image') }}</label>
                    <input type="file" class="form-control" name="image" id="image" accept="image/*" required>
                    @error('image') <span class="text-danger">{{$message}}</span> @enderror
                    <input type="hidden" name="removeimg" id="removeimg">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn_closeItem_" data-dismiss="modal">{{ trans('labels.close') }}</button>
                @if (env('Environment') == 'sandbox')
                    <button type="button" class="btn btn-primary" onclick="myFunction()">{{ trans('labels.add') }}</button>
                @else
                    <button type="submit" class="btn btn-primary">{{ trans('labels.add') }}</button>
                @endif
            </div>
            </form>
        </div>
    </div>
</div>
@section('scripts')
	<script src="{{asset('resources/views/admin/menu/menus.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('resources/views/admin/menu/menus.css')}}">
@endsection