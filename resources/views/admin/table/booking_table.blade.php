<table class="table table-responsive-sm">
	<thead>
	    <tr>
	        <th>{{trans('labels.srno')}}</th>
	        <th>{{trans('labels.type_of_event')}}</th>
	        <th>{{trans('labels.no_of_people')}}</th>
	        <th>{{trans('labels.date_of_event')}}</th>
	        <th>{{trans('labels.time_required')}}</th>
	        <th>{{trans('labels.fullname')}}</th>
	        <th>{{trans('labels.mobile')}}</th>
	        <th>{{trans('labels.email')}}</th>
	        <th>{{trans('labels.additional_requests')}}</th>
	    </tr>
	</thead>
	<tbody>
		@if(!empty($getdata) && count($getdata)>0)
			@foreach($getdata as $mdata)
		    <tr>
		        <th scope="row">{{$mdata->id}}</th>
		        <td>{{$mdata->type_of_event}}</td>
		        <td>{{$mdata->no_of_people}}</td>
		        <td>{{$mdata->date_of_event}}</td>
		        <td>{{$mdata->time_required}}</td>
		        <td>{{$mdata->fullname}}</td>
		        <td>{{$mdata->mobile}}</td>
		        <td>{{$mdata->email}}</td>
		        <td>{{$mdata->additional_requests}}</td>
		    </tr>
		    @endforeach
		    <tr>
		    	<td colspan="9" class="text-right">{{$getdata->links()}}</td>
		    </tr>
	    @else
	    	<tr>
		    	<td colspan="9" class="text-center">{{trans('labels.no_data')}}</td>
		    </tr>
	    @endif
	</tbody>
</table>