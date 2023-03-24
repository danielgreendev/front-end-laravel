<table class="table table-responsive-sm">
	<thead>
		<tr>
			<th>{{trans('labels.srno')}}</th>
			<th>{{trans('labels.image')}}</th>
			<th>{{trans('labels.name')}}</th>
			<th>{{trans('labels.email')}}</th>
			<th>{{trans('labels.mobile')}}</th>
			<th>{{trans('labels.status')}}</th>
			<th>{{trans('labels.whatsapp')}}</th>
			<th>{{trans('labels.action')}}</th>
		</tr>
	</thead>
	<tbody>
		@if(!empty($restaurants) && count($restaurants)>0)
		@foreach($restaurants as $key => $rdata)
		<tr>
			<th scope="row">{{$key + 1}}</th>
			<td><img src="{{Helper::image_path($rdata->image)}}" class="rounded show-image"></td>
			<td>{{$rdata->name}}</td>
			<td>{{$rdata->email}}</td>
			<td>{{$rdata->mobile}}</td>
			<td>
				@if (env('Environment') == 'sandbox')
					@if($rdata->is_available == 1)
						<a class="success p-0" onclick="myFunction()"><i class="ft-check font-medium-3 mr-2"></i></a>
					@else
						<a class="danger p-0" onclick="myFunction()"><i class="ft-x font-medium-3 mr-2"></i></a>
					@endif
				@else
					@if($rdata->is_available == 1)
						<a class="success p-0" onclick="status('{{$rdata->id}}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('admin/restaurants/edit/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}', '')"><i class="ft-check font-medium-3 mr-2"></i></a>
					@else
						<a class="danger p-0" onclick="status('{{$rdata->id}}','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('admin/restaurants/edit/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}', '')"><i class="ft-x font-medium-3 mr-2"></i></a>
					@endif
				@endif
			</td>
			<td>
				@if($rdata->is_approved == 2)
					<a class="success p-0" onclick="status('{{$rdata->id}}','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('admin/restaurants/edit/status_whatsapp') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}', '')"><i class="ft-check font-medium-3 mr-2"></i></a>
				@else
					<a class="danger p-0" onclick="status('{{$rdata->id}}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('admin/restaurants/edit/status_whatsapp') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}', '')"><i class="ft-x font-medium-3 mr-2"></i></a>
				@endif
			</td>
			<th>
				<a class="info p-0" href="{{ URL::to('admin/restaurants/edit-'.$rdata->slug) }}"><i class="ft-edit font-medium-3 mr-2"></i></a>
				<a class="dark p-0" href="{{ URL::to($rdata->slug) }}" target="_blank"><i class="ft-eye font-medium-3 mr-2"></i></a>
				<a class="dark p-0" onclick="status('{{$rdata->id}}','3','{{ trans('messages.are_you_deleted') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('admin/restaurants/edit/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}', '{{$rdata->token}}')"><i class="ft-trash-2 font-medium-3 mr-2 red"></i></a>
			</th>
		</tr>
		@endforeach
		<tr>
			<td colspan="7" class="text-right">{{$restaurants->links()}}</td>
		</tr>
		@else
		<tr>
			<td colspan="7" class="text-center">{{trans('labels.no_data')}}</td>
		</tr>
		@endif
	</tbody>
</table>