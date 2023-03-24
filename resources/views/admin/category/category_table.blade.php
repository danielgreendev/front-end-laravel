<table class="table table-responsive-sm">
	<thead>
	    <tr>
	        <th>{{trans('labels.srno')}}</th>
	        <th>{{trans('labels.image')}}</th>
	        <th>{{trans('labels.name')}}</th>
	        <th>{{trans('labels.featured')}}</th>
	        <th>{{trans('labels.status')}}</th>
	        <th>{{trans('labels.action')}}</th>
	    </tr>
	</thead>
	<tbody>
		@if(!empty($categories) && count($categories)>0)
			@foreach($categories as $cdata)
		    <tr>
		        <th scope="row">{{$cdata->id}}</th>
		        <td><img src="{{asset('storage/app/public/category/'.$cdata->image)}}" class="rounded show-image"></td>
		        <td>{{$cdata->name}}</td>
               	<td>
               		@if (env('Environment') == 'sandbox')
           				@if($cdata->is_featured == 1)
           			   		<a class="success p-0" onclick="myFunction()"><i class="ft-check font-medium-3 mr-2"></i></a>
           				@else
           			   		<a class="danger p-0" onclick="myFunction()"><i class="ft-x font-medium-3 mr-2"></i></a>
           				@endif
               		@else
           		    	@if($cdata->is_featured == 1)
           		       		<a class="success p-0" onclick="isfeatured('{{$cdata->id}}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('admin/categories/edit/featured') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-check font-medium-3 mr-2"></i></a>
           		    	@else
           		       		<a class="danger p-0" onclick="isfeatured('{{$cdata->id}}','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('admin/categories/edit/featured') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-x font-medium-3 mr-2"></i></a>
           		    	@endif
               		@endif
               	</td>
               	<td>
               		@if (env('Environment') == 'sandbox')
           				@if($cdata->is_available == 1)
       		    	   		<a class="success p-0" onclick="myFunction()"><i class="ft-check font-medium-3 mr-2"></i></a>
       		    		@else
       		    	   		<a class="danger p-0" onclick="myFunction()"><i class="ft-x font-medium-3 mr-2"></i></a>
       		    		@endif
               		@else
       		    		@if($cdata->is_available == 1)
       		    	   	<a class="success p-0" onclick="status('{{$cdata->id}}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('admin/categories/edit/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-check font-medium-3 mr-2"></i></a>
       		    		@else
       		    	   	<a class="danger p-0" onclick="status('{{$cdata->id}}','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('admin/categories/edit/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-x font-medium-3 mr-2"></i></a>
       		    		@endif
               		@endif
               	</td>
		        <th>
		        	@if (env('Environment') == 'sandbox')
           				<a class="info p-0" data-original-title="" title="" onclick="myFunction()">
	                     	<i class="ft-edit font-medium-3 mr-2"></i>
	                  	</a>
	                  	<a class="danger p-0" onclick="myFunction()" >
	                     	<i class="ft-trash font-medium-3 mr-2"></i>
	                  	</a>
               		@else
       		    		<a class="info p-0" data-original-title="" title="" href="{{ URL::to('admin/categories/edit-'.$cdata->slug) }}">
	                     	<i class="ft-edit font-medium-3 mr-2"></i>
	                  	</a>
	                  	<a class="danger p-0" onclick="deletecategory('{{$cdata->id}}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('admin/categories/del') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')" >
	                     	<i class="ft-trash font-medium-3 mr-2"></i>
	                  	</a>
               		@endif
		        </th>
		    </tr>
		    @endforeach
		    <tr>
		    	<td colspan="6" class="text-right">{{$categories->links()}}</td>
		    </tr>
	    @else
	    	<tr>
		    	<td colspan="6" class="text-center">{{trans('labels.no_data')}}</td>
		    </tr>
	    @endif
	</tbody>
</table>