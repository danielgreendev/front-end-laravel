<table class="table table-responsive-sm">
	<thead>
		<tr>
			<th>{{trans('labels.srno')}}</th>
			<th>{{trans('labels.area')}}</th>
			<th>{{trans('labels.price')}}</th>
			<th>{{trans('labels.action')}}</th>
		</tr>
	</thead>
	<tbody>
		@if(!empty($deliveryarea) && count($deliveryarea)>0)
		@php $i = 1;@endphp
		@foreach($deliveryarea as $ddata)
		<tr>
			<th scope="row">@php echo $i++;@endphp</th>
			<td>{{$ddata->name}}</td>
			<td>{{Helper::currency_format($ddata->price,Auth::user()->id)}}</td>
			<th>
				<a class="info p-0" data-original-title="" title="" href="{{ URL::to('vendor/delivery-area/edit-'.$ddata->slug) }}">
					<i class="ft-edit font-medium-3 mr-2"></i>
				</a>

				@if (env('Environment') == 'sandbox')
				<a class="danger p-0" onclick="myFunction()">
					<i class="ft-trash font-medium-3 mr-2"></i>
				</a>
				@else
				<a class="danger p-0" onclick="deletecategory('{{$ddata->id}}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('vendor/delivery-area/del') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')">
					<i class="ft-trash font-medium-3 mr-2"></i>
				</a>
				@endif
			</th>
		</tr>
		@endforeach
		<tr>
			<td colspan="6" class="text-right">{{$deliveryarea->links()}}</td>
		</tr>
		@else
		<tr>
			<td colspan="6" class="text-center">{{trans('labels.no_data')}}</td>
		</tr>
		@endif
	</tbody>
</table>