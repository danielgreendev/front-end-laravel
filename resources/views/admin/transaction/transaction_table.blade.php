<table class="table table-striped table-bordered zero-configuration dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
	<thead>
		<tr role="row">
			<th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" >{{trans('labels.srno')}}</th>
			@if (Auth::user()->type == 1)
			<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">{{trans('labels.name')}}</th>
			@endif
			<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Plan: activate to sort column ascending">{{trans('labels.plan')}}</th>
			<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Amount: activate to sort column ascending">{{trans('labels.amount')}}</th>
			<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payment type: activate to sort column ascending">{{trans('labels.payment_type')}}</th>
			<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">{{trans('labels.start_date')}}</th>
			<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="End date: activate to sort column ascending">{{trans('labels.end_date')}}</th>
			<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">{{trans('labels.status')}}</th>
			@if (Auth::user()->type == 1)
			<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">{{trans('labels.action')}}</th>
			@endif
		</tr>
	</thead>
	<tbody>
		@if(!empty($transaction) && count($transaction)>0)
		@foreach($transaction as $key => $rdata)
		<tr>
			<td>{{$key + 1}}</td>
			@if (Auth::user()->type == 1)
			<td>{{$rdata['users'] ? $rdata['users']->name : 'deleted'}}</td>
			@endif
			<td>{{$rdata->plan}} (
				@if($rdata->plan_period == 5)
					{{trans('labels.7_days')}}
				@endif
				@if($rdata->plan_period == 1)
					{{trans('labels.1_month')}}
				@endif
				@if($rdata->plan_period == 2)
					{{trans('labels.3_month')}}
				@endif
				@if($rdata->plan_period == 3)
					{{trans('labels.6_month')}}
				@endif
				@if($rdata->plan_period == 4)
					{{trans('labels.1_year')}}
				<!--  -->
				@endif
				)
			</td>
			<td>{{Helper::currency_format($rdata->amount,Auth::user()->id)}}</td>
			<td>
				@if ($rdata->payment_type == "COD")
				{{ trans('labels.cod') }}
				@else
				{{ $rdata->payment_type }} : {{ $rdata->payment_id }}
				@endif

				@if ($rdata->payment_type == 7)
				Mercado Pago : {{ $rdata->payment_id }}
				@endif
			</td>
			<td>
				{{$rdata->date}}
			</td>
			<td>
				@if($rdata->date != "")
				<?php
				$now = date('Y-m-d');
				if ($rdata->plan_period == "5") {
					$purchasedate = $rdata->date;

					$exdate = date('Y-m-d', strtotime($purchasedate . ' +7 days'));
					if ($purchasedate <= $now && $now <= $exdate) {
						$showbuy = "yes";
					} else {
						$showbuy = "no";
					}
				}
				if ($rdata->plan_period == "1") {
					$purchasedate = $rdata->date;

					$exdate = date('Y-m-d', strtotime($purchasedate . ' +30 days'));
					if ($purchasedate <= $now && $now <= $exdate) {
						$showbuy = "yes";
					} else {
						$showbuy = "no";
					}
				}
				if ($rdata->plan_period == "2") {
					$purchasedate = $rdata->date;

					$exdate = date('Y-m-d', strtotime($purchasedate . ' +90 days'));
					if ($purchasedate <= $now && $now <= $exdate) {
						$showbuy = "yes";
					} else {
						$showbuy = "no";
					}
				}
				if ($rdata->plan_period == "3") {
					$purchasedate = $rdata->date;

					$exdate = date('Y-m-d', strtotime($purchasedate . ' +180 days'));
					if ($purchasedate <= $now && $now <= $exdate) {
						$showbuy = "yes";
					} else {
						$showbuy = "no";
					}
				}
				if ($rdata->plan_period == "4") {
					$purchasedate = $rdata->date;

					$exdate = date('Y-m-d', strtotime($purchasedate . ' +365 days'));

					if ($purchasedate <= $now && $now <= $exdate) {
						$showbuy = "yes";
					} else {
						$showbuy = "no";
					}
				}
				else if ($rdata->plan_period == "6") {
					$purchasedate = $rdata->date;

					$exdate = 'ilimitado';
				}
				?>
				{{$exdate}}
				@endif
			</td>
			<td> - </td>
			@if (Auth::user()->type == 1)
			<td>-
				@if($rdata->status == 1)
					<!-- <a class="success p-0" onclick="status('{{$rdata->id}}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('admin/transaction/edit/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-check font-medium-3 mr-2"></i></a> -->
				@else
				<!-- <a class="danger p-0" onclick="status('{{$rdata->id}}','3','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('admin/transaction/edit/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-x font-medium-3 mr-2"></i></a> -->
				@endif
			</td>
			@endif
		</tr>
		@endforeach
		@if ($transaction->hasPages())
		<tr>
			<td colspan="9" class="text-right float-center">{{$transaction->links()}}</td>
		</tr>
		@endif
		@else
		<tr>
			<td colspan="9" class="text-center">{{trans('labels.no_data')}}</td>
		</tr>
		@endif
	</tbody>
</table>