@extends('admin.layout.main')
@section('page_title')
	{{trans('labels.item')}} | {{trans('labels.update')}}
@endsection
@section('content')
	<section id="basic-form-layouts">
		<div class="row">
	        <div class="col-sm-12">
	            <div class="content-header">{{trans('labels.update')}}</div>
	        </div>
	    </div>
		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
						    <div class="col-8">
						        <h4 class="card-title" id="basic-layout-colored-form-control">{{trans('labels.item_management')}}</h4>
						    </div>
						    <div class="col-4 text-right">
						    @if (env('Environment') == 'sandbox')
						    	<button type="button" class="btn btn-sm btn-danger" onclick="myFunction()">{{trans('labels.delete')}}</button>
						    @else
						        <button type="button" class="btn btn-sm btn-danger" onclick="deleteitem('{{$mdata->id}}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('vendor/item/del') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}','{{ URL::to('/vendor/menus') }}')">{{trans('labels.delete')}}</button>
						    @endif
						    </div>
						</div>
					</div>
					<div class="card-body">
						<div class="px-3">
							<form class="form" action="{{URL::to('vendor/item/update-'.$mdata->slug)}}" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="form-body">
									<div class="form-group">
									    <label for="cat_id" class="col-form-label">{{ trans('labels.category') }}</label>
									    <select class="form-control" name="cat_id" id="cat_id">
									    	<option value="">{{trans('labels.select')}}</option>
									    	@foreach($categories as $category)
									    		<option value="{{$category->id}}" {{ $category->id == $mdata->cat_id ? 'selected' : ''}}>{{$category->name}}</option>
									    	@endforeach
									    </select>
									    @error('cat_id')<span class="text-danger" id="cat_id">{{ $message }}</span>@enderror
									</div>
									<div class="form-group">
									    <label for="item_name" class="col-form-label">{{ trans('labels.name') }}</label>
									    <input type="text" class="form-control" name="item_name" id="item_name" placeholder="{{ trans('labels.enter_name') }}" required value="{{$mdata->item_name}}">
									    @error('item_name')<span class="text-danger" id="item_name">{{ $message }}</span>@enderror
									</div>
									<div class="form-group">
									    <label for="item_price" class="col-form-label">{{ trans('labels.price') }}</label>
									    <input type="text" class="form-control" name="item_price" id="item_price" placeholder="{{ trans('labels.enter_price') }}" required value="{{$mdata->item_price}}">
									    @error('item_price')<span class="text-danger" id="item_price">{{ $message }}</span>@enderror
									</div>
									<div class="form-group">
									    <label for="description" class="col-form-label">{{ trans('labels.description') }}</label>
									    <input type="text" class="form-control" name="description" id="description" placeholder="{{ trans('labels.description') }}" required value="{{$mdata->description}}">
									    @error('description')<span class="text-danger" id="description">{{ $message }}</span>@enderror
									</div>
									<div class="form-group" style="display: none;">
									    <label for="tax" class="col-form-label">{{trans('labels.vat_percentage')}}</label>
									    <input type="text" class="form-control" name="tax" id="tax" placeholder="{{ trans('labels.enter_vat_percentage') }}" required value="{{$mdata->tax}}">
									    @error('tax')<span class="text-danger" id="tax">{{ $message }}</span>@enderror
									</div>
									<div class="form-group">
									    <label for="image" class="col-form-label">{{ trans('labels.image') }}</label>
									    <input type="file" id="image" class="form-control" name="image">
		                                <img src="{{ asset('storage/app/public/item/'.$mdata->image) }}" alt="{{trans('labels.image')}}" class="rounded show-image mt-1">
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="is_available">Status</label>
												<select id="is_available" name="is_available" class="form-control">
													<option value="1" {{ $mdata->is_available == "1" ? 'selected' : ''}}>{{trans('labels.available')}}</option>
													<option value="2" {{ $mdata->is_available == "2" ? 'selected' : ''}}>{{trans('labels.unavailable')}}</option>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="has_variants">Possui varientes ?</label>
												<select id="has_variants" name="has_variants" class="form-control">
													<option value="1" {{ $mdata->has_variants == "1" ? 'selected' : ''}}>{{trans('messages.yes')}}</option>
													<option value="2" {{ $mdata->has_variants == "2" ? 'selected' : ''}}>{{trans('messages.no')}}</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions">
									 <a type="button" class="btn btn-raised btn-warning mr-1" href="{{route('menus')}}"><i class="ft-x"></i> {{trans('labels.cancel')}}</a>
									 @if (env('Environment') == 'sandbox')
									 	<button type="button" class="btn btn-raised btn-raised btn-primary" onclick="myFunction()">
									 		<i class="fa fa-check-square-o"></i> {{trans('labels.update')}}
									 	</button>
									 @else
									     <button type="submit" class="btn btn-raised btn-raised btn-primary">
									     	<i class="fa fa-check-square-o"></i> {{trans('labels.update')}}
									     </button>
									 @endif
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				@if($mdata->has_variants == "1")
				<div class="card">
					<div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="card-title" id="basic-layout-colored-form-control">{{trans('labels.variants')}}</h4>
                            </div>
                            <div class="col-4 text-right">
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addVariants">{{trans('labels.add_new')}}</button>
                            </div>
                        </div>
                    </div>
					<div class="card-body">
						<table class="table table-responsive-sm text-center">
							<thead>
								<tr>
									<th>{{trans('labels.name')}}</th>
									<th>{{trans('labels.price')}}</th>
									<th>{{trans('labels.action')}}</th>
								</tr>
							</thead>
							<tbody>
								@foreach($variants as $variants)
								<tr>
									<td>{{$variants->name}}</td>
									<td>{{Helper::currency_format($variants->price,Auth::user()->id)}}</td>
									<td>
										<a class="success edit-variants" data-variants-name="{{$variants->name}}" data-variants-price="{{$variants->price}}" data-variants-id="{{$variants->id}}">
											<i class="ft-edit-2 font-medium-3 mr-2"></i>
										</a>
										@if (env('Environment') == 'sandbox')
											<a class="danger" onclick="myFunction()">
										    	<i class="ft-x"></i>
										    </a>
										@else
										    <a class="danger" onclick="deletevariants('{{$variants->id}}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('vendor/variants/del') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')">
										    	<i class="ft-x"></i>
										    </a>
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				@endif
				<div class="card">
					<div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="card-title" id="basic-layout-colored-form-control">{{trans('labels.extras')}}</h4>
                            </div>
                            <div class="col-4 text-right">
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addExtra">{{trans('labels.add_new')}}</button>
                            </div>
                        </div>
                    </div>
					<div class="card-body">
						<table class="table table-responsive-sm text-center">
							<thead>
								<tr>
									<th>{{trans('labels.name')}}</th>
									<th>{{trans('labels.price')}}</th>
									<th>{{trans('labels.action')}}</th>
								</tr>
							</thead>
							<tbody>
								@foreach($extras as $extra)
								<tr>
									<td>{{$extra->name}}</td>
									<td>{{Helper::currency_format($extra->price,Auth::user()->id)}}</td>
									<td>
										<a class="success edit-extra" data-extra-name="{{$extra->name}}" data-extra-price="{{$extra->price}}" data-extra-id="{{$extra->id}}">
											<i class="ft-edit-2 font-medium-3 mr-2"></i>
										</a>
										@if (env('Environment') == 'sandbox')
											<a class="danger" onclick="myFunction()">
										    	<i class="ft-x"></i>
										    </a>
										@else
										    <a class="danger" onclick="deleteextra('{{$extra->id}}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('vendor/extra/del') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')">
										    	<i class="ft-x"></i>
										    </a>
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
<!-- Add Extra -->
<div class="modal fade" id="addExtra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('labels.add_extra') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form method="post" action="{{URL::to('vendor/extra/store')}}">
	            <div class="modal-body">
	                <span id="msg"></span>
	                @csrf
	                <input type="hidden" name="item_id" value="{{$mdata->id}}">
	                <div class="form-group">
	                    <label for="name" class="col-form-label">{{ trans('labels.name') }}</label>
	                    <input type="text" class="form-control" name="name" id="name" placeholder="{{ trans('labels.name') }}" required>
	                </div>     
	                <div class="form-group">
	                    <label for="price" class="col-form-label">{{ trans('labels.price') }}</label>
	                    <input type="text" class="form-control" name="price" id="price" placeholder="{{ trans('labels.price') }}" required>
	                </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('labels.close') }}</button>
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
<!-- Edit Extra -->
<div class="modal fade" id="editExtra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('labels.edit_extra') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form method="post" action="{{URL::to('vendor/extra/update')}}">
	            <div class="modal-body">
	                <span id="msg"></span>
	                @csrf
	                <input type="hidden" name="extra_id" id="extra_id">
	                <input type="hidden" name="item_id" value="{{$mdata->id}}">
	                <div class="form-group">
	                    <label for="name" class="col-form-label">{{ trans('labels.name') }}</label>
	                    <input type="text" class="form-control" name="name" id="extra_name" placeholder="{{ trans('labels.name') }}" required>
	                </div>     
	                <div class="form-group">
	                    <label for="price" class="col-form-label">{{ trans('labels.price') }}</label>
	                    <input type="text" class="form-control" name="price" id="extra_price" placeholder="{{ trans('labels.price') }}" required>
	                </div>        
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('labels.close') }}</button>
	                @if (env('Environment') == 'sandbox')
	                    <button type="button" class="btn btn-primary" onclick="myFunction()">{{ trans('labels.update') }}</button>
	                @else
	                    <button type="submit" class="btn btn-primary">{{ trans('labels.update') }}</button>
	                @endif
	            </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Variants -->
<div class="modal fade" id="addVariants" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('labels.add_variants') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form method="post" action="{{URL::to('vendor/variants/store')}}">
	            <div class="modal-body">
	                <span id="msg"></span>
	                @csrf
	                <input type="hidden" name="item_id" value="{{$mdata->id}}">
	                <div class="form-group">
	                    <label for="variants_name" class="col-form-label">{{ trans('labels.name') }}</label>
	                    <input type="text" class="form-control" name="variants_name" id="variants_name" placeholder="{{ trans('labels.name') }}" required>
	                </div>     
	                <div class="form-group">
	                    <label for="variants_price" class="col-form-label">{{ trans('labels.price') }}</label>
	                    <input type="text" class="form-control" name="variants_price" id="variants_price" placeholder="{{ trans('labels.price') }}" required>
	                </div>        
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('labels.close') }}</button>
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
<!-- Edit Extra -->
<div class="modal fade" id="editVariants" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('labels.edit_variants') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form method="post" action="{{URL::to('vendor/variants/update')}}">
	            <div class="modal-body">
	                <span id="msg"></span>
	                @csrf
	                <input type="hidden" name="variants_id" id="variants_id">
	                <input type="hidden" name="item_id" value="{{$mdata->id}}">
	                <div class="form-group">
	                    <label for="name" class="col-form-label">{{ trans('labels.name') }}</label>
	                    <input type="text" class="form-control" name="variants_name" id="edit_variants_name" placeholder="{{ trans('labels.name') }}" required>
	                </div>     
	                <div class="form-group">
	                    <label for="price" class="col-form-label">{{ trans('labels.price') }}</label>
	                    <input type="text" class="form-control" name="variants_price" id="edit_variants_price" placeholder="{{ trans('labels.price') }}" required>
	                </div>        
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('labels.close') }}</button>
	                @if (env('Environment') == 'sandbox')
	                    <button type="button" class="btn btn-primary" onclick="myFunction()">{{ trans('labels.update') }}</button>
	                @else
	                    <button type="submit" class="btn btn-primary">{{ trans('labels.update') }}</button>
	                @endif
	            </div>
            </form>
        </div>
    </div>
</div>
@section('scripts')
	<script src="{{asset('resources/views/admin/menu/menus.js')}}" type="text/javascript"></script>
@endsection