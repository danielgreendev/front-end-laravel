@extends('admin.layout.main')

@section('page_title',trans('labels.notification'))

@section('content')

<section id="content-types">
	<div class="row">
		<div class="col-12 mt-3 mb-1">
			<h4 class="content-header">{{trans('labels.notifications')}}
			</h4>
		</div>
	</div>

	<div class="notifications" id="notifications_body">
	</div>
</section>

<link rel="stylesheet" type="text/css" href="{{asset('resources/views/admin/notifications/index.css')}}">

<script src="{{ asset('storage/app/public/admin-assets/vendors/js/core/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
<script>

	var items_view = [];

	var cnt_noti = 0;

	function showNotify() {
		var items = '';

		items_view.forEach(item => {
			if (!item.is_deleted) {
				var origin = new Date().getTime() - item.data['fullperiod'] * 1000;
				var date = new Date(origin);

				items += `<div class="card p-3" role="panel">
			      <div class="d-flex gap-3">
			        <div class="flex-shrink-0">
			        </div>
			        <div class="flex-grow-1">
			          <div class="fw-semibold fs-5 mb-2">Whoo! You have new order 🛒</div>
			          <ul class="list-unstyled mb-0">
			            <li>${item.data['sender']} made new order!!! Order Number is ${item.data['contents']}</li>
			            <li class="notifications_item_time">Order Date: ${date.toLocaleString()}</li>
			          </ul>
			        </div>
			      </div>
			      <button onClick="notifyItemDelete(${item.id})" class="btn-close btn-pinned" aria-label="Close"></button>
			    </div>`;
			}
		});

		$("#notifications_body").html(items);
	}

	function notifyItemDelete(id) {
		items_view[id].is_deleted = true;
		$.ajax({
	         headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	         },
	         url: "{{ URL::to('/user/notify/control') }}",
	         type: 'POST',
	         dataType: 'json',
	         data: {
	            info: 'notification',
	            email: '{{Auth::user()->email}}',
	            name: '{{Auth::user()->slug}}',
	            type: 'delete',
	            data: items_view[id].data['timestamp']
	         },
	         success: function(response) {
	            if (response.status == 1) {
	            }
	         },
	         error: function(error) {
	         }
	    });

		showNotify();
	}

	function notifyFuncNotify(str) {
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: "{{ URL::to('/user/notify/monitor') }}",
			type: 'POST',
			dataType: 'json',
			data: {
			info: 'notification',
			email: '{{Auth::user()->email}}',
			name: '{{Auth::user()->slug}}',
			type: str
		 },
		 success: function(response) {
		    if (response.status == 1) {
		    	response.message.forEach(item => {
		    		items_view.push(
		    		{
		    			id: cnt_noti++,
		    			is_deleted: false,
		    			data: item
		    		});
		    	});

		    	showNotify();
		    }
		 },
		 error: function(error) {
		    console.log(error);
		 }
		});
   	}

	$(document).ready(function() {
		notifyFuncNotify('onstart');
	});
</script>

@endsection