<table class="table table-responsive-sm">
	<thead>
		<tr>
			<th>{{trans('labels.srno')}}</th>
			<th>{{trans('labels.name')}}</th>
			<th>{{trans('labels.code')}}</th>
			<th>{{trans('labels.price')}}</th>
			<th>{{trans('labels.active_from')}}</th>
			<th>{{trans('labels.active_to')}}</th>
			<th>{{trans('labels.limit_number')}}</th>
			<th>{{trans('labels.sold_number')}}</th>
			<th>{{trans('labels.action')}}</th>
			<th>{{trans('labels.status')}}</th>
		</tr>
	</thead>
	<tbody>
		@if(!empty($coupons) && count($coupons)>0)
		@php $i = 1;@endphp
		@foreach($coupons as $ddata)
		<tr>
			<th scope="row">@php echo $i++;@endphp</th>
			<td>{{$ddata->name}}</td>
			<td>{{$ddata->code}}</td>
			<td>{{Helper::currency_format($ddata->price,Auth::user()->id)}}</td>
			<td>{{$ddata->active_from}}</td>
			<td>{{$ddata->active_to}}</td>
			<td>{{$ddata->limit}}</td>
			@if ($ddata->date == null)
			<td>0</td>
			@else
			<td>{{$ddata->sold}}</td>
			@endif
			<th>
				<a class="info p-0" data-original-title="" title="" href="{{ URL::to('admin/coupons/edit-'.$ddata->token) }}">
					<i class="ft-edit font-medium-3 mr-2"></i>
				</a>

				<!-- <a class="danger p-0" onclick="deletecategory('{{$ddata->id}}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('vendor/delivery-area/del') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')">
					<i class="ft-trash font-medium-3 mr-2"></i>
				</a> -->
				@if (!($ddata->limit <= $ddata->sold || $ddata->active_to < date("Y-m-d")))
				@if($ddata->status == 2)
          <a class="success p-0" onclick="status('{{$ddata->id}}','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('admin/coupons/status/edit-'.$ddata->token) }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-check font-medium-3 mr-2"></i></a>
        @else
          <a class="danger p-0" onclick="status('{{$ddata->id}}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('admin/coupons/status/edit-'.$ddata->token) }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-x font-medium-3 mr-2"></i></a>
        @endif
        @endif
			</th>
			@if ($ddata->limit <= $ddata->sold || $ddata->active_to < date("Y-m-d"))
			<td>{{trans('labels.expired')}}</td>
			@elseif ($ddata->active_from > date("Y-m-d"))
			<td>{{trans('labels.not_yet')}}</td>
			@else
			@if ($ddata->status == 1)
			<td>{{trans('labels.paused')}}</td>
			@else
			<td>{{trans('labels.active')}}</td>
			@endif
			@endif
		</tr>
		@endforeach
		<tr>
			<td colspan="10" class="text-right"></td>
		</tr>
		@else
		<tr>
			<td colspan="10" class="text-center">{{trans('labels.no_data')}}</td>
		</tr>
		@endif
	</tbody>
</table>