<table class="table table-responsive-sm">
	<thead>
	    <tr>
	        <th>{{trans('labels.srno')}}</th>
	        <th>{{trans('labels.name')}}</th>
	        <th>{{trans('labels.status')}}</th>
	        <th>{{trans('labels.action')}}</th>
	    </tr>
	</thead>
	<tbody>
		@if(!empty($menus) && count($menus)>0)
			@foreach($menus as $mdata)
		    <tr>
		        <th scope="row">{{$mdata->id}}</th>
		        <td>{{$mdata->name}}</td>
               	<td>
                  	@if($mdata->is_available == 1)
                     	<a class="success p-0" onclick="status('{{$mdata->id}}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('vendor/menus/edit/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-check font-medium-3 mr-2"></i></a>
                  	@else
                     	<a class="danger p-0" onclick="status('{{$mdata->id}}','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('vendor/menus/edit/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-x font-medium-3 mr-2"></i></a>
                  	@endif
               	</td>
		        <th>
		        	<a class="info p-0" data-original-title="" title="" href="{{ URL::to('vendor/menus/edit-'.$mdata->slug) }}"><i class="ft-edit font-medium-3 mr-2"></i></a>
	                <a class="danger p-0" onclick="deletemenus('{{$mdata->id}}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('vendor/menus/del') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')" >
	                     <i class="ft-trash font-medium-3 mr-2"></i>
	                </a>
		        </th>
		    </tr>
		    @endforeach
		    <tr>
		    	<td colspan="4" class="text-right">{{$menus->links()}}</td>
		    </tr>
	    @else
	    	<tr>
		    	<td colspan="4" class="text-center">{{trans('labels.no_data')}}</td>
		    </tr>
	    @endif
	</tbody>
</table>