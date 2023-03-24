<table class="table table-responsive-sm">
	<thead>
	    <tr>
            <th>{{ trans('labels.order_number') }}</th>
	        <th>{{ trans('labels.customer_name') }}</th>
            <th>{{ trans('labels.order_type') }}</th>
            <!--<th>{{ trans('labels.time') }}</th>-->
            <th>{{ trans('labels.status') }}</th>
            <th>{{ trans('labels.created_at') }}</th>
	    </tr>
	</thead>
	<tbody>
		@if(!empty($getorders) && count($getorders)>0)
			@foreach($getorders as $odata)
		    <tr>
		        <td><a href="{{URL::to('vendor/orders/invoice/'.$odata->id.'')}}"> {{$odata->order_number}} </a></td>
		        <td>{{$odata->customer_name}}</td>
		        <td>
		        	@if($odata->order_type == 1)
		        		{{trans('labels.delivery')}}
		        	@else
		        		{{trans('labels.pickup')}}
		        	@endif
		        </td>
		        <!--<td>{{$odata->delivery_time}}</td>-->
		        <td>
		        	@if($odata->status == '1')
		        	    <a class="badge badge-secondary px-2" href="{{URL::to('vendor/orders/'.$odata->id.'/2')}}">
		        	        {{ trans('labels.accept') }}
		        	    </a>
		        	    <a class="badge badge-danger px-2" href="{{URL::to('vendor/orders/'.$odata->id.'/5')}}">
		        	        {{ trans('labels.reject') }}
		        	    </a>
		        	@elseif ($odata->status == '2')
		        	    <a class="badge badge-primary px-2" href="{{URL::to('vendor/orders/'.$odata->id.'/3')}}">{{ trans('labels.prepared') }}</a>
		        	@elseif ($odata->status == '3')
		        	    <a class="badge badge-success px-2" href="{{URL::to('vendor/orders/'.$odata->id.'/4')}}">
		        	        {{ trans('labels.delivered') }}
		        	    </a>
		        	@elseif ($odata->status == '4')
		        	    <span class="badge badge-success px-2">
		        	        {{ trans('labels.closed') }}
		        	    </span>
		        	@else
		        	    <span class="badge badge-danger px-2">{{ trans('labels.rejected') }}</span>
		        	@endif
		        </td>
		        <td>{{$odata->created_at}}</td>
		    </tr>
		    @endforeach
		    <tr>
		    	<td colspan="6" class="text-right">{{$getorders->links()}}</td>
		    </tr>
	    @else
	    	<tr>
		    	<td colspan="6" class="text-center">{{trans('labels.no_data')}}</td>
		    </tr>
	    @endif
	</tbody>
</table>