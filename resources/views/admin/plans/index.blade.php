@extends('admin.layout.main')
@section('page_title',trans('labels.pricing_plans'))
@section('content')

<section id="content-types">
	<div class="row">
		<div class="col-12 mt-3 mb-1">
			<h4 class="content-header">{{trans('labels.pricing_plans')}}
				@if(Auth::user()->type == 1)
				<a href="{{ URL::to('/admin/plans/add')}}" class="btn btn-primary btn-sm float-right">{{ trans("labels.add_new") }}</a>
				@endif
			</h4>
		</div>
	</div>

	@if (\Session::has('danger'))
	<div class="alert alert-danger">
		{!! \Session::get('danger') !!}
	</div>
	@endif

	@if (Auth::user()->plan == "EXPERT" || Auth::user()->plan_app == "PREMIUM")
	<?php
		$flag = true;
		$str = "Você foi contemplado com o Plano VIP. Uma assinatura exclusiva para clientes especiais.";	
	?>
	<div style="color: green;">{{$str}}</div>
	@else
	<?php $flag = false; ?>
	@endif
	<div class="row match-height">
		@foreach($plans as $pdata)
		<div class="col-lg-4 col-md-6 col-sm-12">
			<div class="card" style="height: 473px;">

				<div class="card-body">
					<div class="card-block">
						<h4 class="card-title">{{$pdata->name}}</h4>
						<p class="card-text">{{$pdata->description}}</p>
					</div>
					<ul class="list-group">
						<li class="list-group-item">
							<h4 class="card-title">{{Helper::currency_format($pdata->price,1)}} / 
							@if($pdata->plan_period == 5)
								{{trans('labels.7_days')}}
							@endif
							@if($pdata->plan_period == 1)
								{{trans('labels.1_month')}}
							@endif
							@if($pdata->plan_period == 2)
								{{trans('labels.3_month')}}
							@endif
							@if($pdata->plan_period == 3)
								{{trans('labels.6_month')}}
							@endif
							@if($pdata->plan_period == 4)
								{{trans('labels.1_year')}}
							@endif
							</h4>
						</li>

						<li class="list-group-item"><i class="ft-check"></i>
							@if($pdata->item_unit == -1)
							{{trans('labels.item_unlimited')}}
							@else
							{{$pdata->item_unit}} {{trans('labels.item_limit')}}
							@endif
						</li>

						<li class="list-group-item"><i class="ft-check"></i>
							@if($pdata->item_unit == -1)
							{{trans('labels.order_unlimited')}}
							@else
							{{$pdata->order_limit}} {{trans('labels.order_limit')}}
							@endif
						</li>

						<?php
						$myString = $pdata->features;
						$myArray = explode(',', $myString);
						?>
						@foreach($myArray as $features)
						<li class="list-group-item"><i class="ft-check"></i> {{$features}}</li>
						@endforeach
					</ul>
					<div class="card-block">
					@if (Auth::user()->type == 2)
						@if (Helper::getrestaurant(Auth::user()->slug)->plan == $pdata->name)
						<?php
						$now = date('Y-m-d');
						if ($pdata->plan_period == "5") {
							$purchasedate = date("Y-m-d", strtotime(Auth::user()->purchase_date));

							$exdate = date('Y-m-d', strtotime($purchasedate . ' +7 days'));
							if ($purchasedate <= $now && $now <= $exdate) {
								$showbuy = "yes";
							} else {
								$showbuy = "no";
							}
						}
						if ($pdata->plan_period == "1") {
							$purchasedate = date("Y-m-d", strtotime(Auth::user()->purchase_date));

							$exdate = date('Y-m-d', strtotime($purchasedate . ' +30 days'));
							if ($purchasedate <= $now && $now <= $exdate) {
								$showbuy = "yes";
							} else {
								$showbuy = "no";
							}
						}
						if ($pdata->plan_period == "2") {
							$purchasedate = date("Y-m-d", strtotime(Auth::user()->purchase_date));

							$exdate = date('Y-m-d', strtotime($purchasedate . ' +90 days'));
							if ($purchasedate <= $now && $now <= $exdate) {
								$showbuy = "yes";
							} else {
								$showbuy = "no";
							}
						}
						if ($pdata->plan_period == "3") {
							$purchasedate = date("Y-m-d", strtotime(Auth::user()->purchase_date));

							$exdate = date('Y-m-d', strtotime($purchasedate . ' +180 days'));
							if ($purchasedate <= $now && $now <= $exdate) {
								$showbuy = "yes";
							} else {
								$showbuy = "no";
							}
						}
						if ($pdata->plan_period == "4") {
							$purchasedate = date("Y-m-d", strtotime(Auth::user()->purchase_date));

							$exdate = date('Y-m-d', strtotime($purchasedate . ' +365 days'));

							if ($purchasedate <= $now && $now <= $exdate) {
								$showbuy = "yes";
							} else {
								$showbuy = "no";
							}
						}
						?>
						@if($showbuy == "no")
						@if ($pdata->price > 0)
						<a href="{{ URL::to('/vendor/plans/'.$pdata->_id)}}" class="btn btn-raised btn-success btn-min-width mr-1">{{trans('labels.buy_now')}} {{$showbuy}}</a>
						@endif
						<span class="text-danger">
							{{trans('labels.current_plan')}} ({{trans('labels.expired')}} {{$exdate}})
						</span>
						@else
						<span class="text-success">
							{{trans('labels.current_plan')}} ({{trans('labels.expired_on')}} {{$exdate}})
						</span>
						@endif

						@else

						@if ($pdata->price == 0)
							@if(Auth::user()->free_plan == "0")
								<form method="post" action="{{ URL::to('/vendor/plans/order') }}">
									@csrf
									<input type="hidden" name="plan" value="{{$pdata->name}}">
									<input type="hidden" name="payment_type" value="COD">
									<input type="hidden" name="plan_period" value="{{$pdata->plan_period}}">
									<input type="hidden" name="amount" value="{{$pdata->price}}">
									<button type="submit" class="btn btn-raised btn-success btn-min-width mr-1">{{trans('labels.activate')}}</button>
								</form>
							@else
								<span class="text-danger">
									{{trans('messages.already_used')}}
								</span>
							@endif
						@else
							<a href="@if(!$flag) {{ URL::to('/vendor/plans/'.$pdata->_id)}} @else {{'#'}} @endif" class="btn btn-raised btn-success btn-min-width mr-1 @if($flag) {{'disabled'}} @endif">{{trans('labels.buy_now')}}</a>
						@endif
						@endif
						@endif
						@if (Auth::user()->type == 1)
						@if (env('Environment') == 'sandbox')
						<a data-original-title="" title="" href="{{ URL::to('admin/plans/edit-'.$pdata->id) }}">
							<button type="button" class="btn btn-sm btn-primary">{{trans('labels.update')}}</button>
						</a>
						<a onclick="myFunction()">
							<button type="button" class="btn btn-sm btn-danger">{{trans('labels.delete')}}</button>
						</a>
						@else
						<a data-original-title="" title="" href="{{ URL::to('admin/plans/edit-'.$pdata->id) }}">
							<button type="button" class="btn btn-sm btn-primary">{{trans('labels.update')}}</button>
						</a>
						<a onclick="deleteplans('{{$pdata->id}}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('admin/plans/del') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')">
							<button type="button" class="btn btn-sm btn-danger">{{trans('labels.delete')}}</button>
						</a>
						@endif
						@endif
					</div>
				</div>

			</div>
		</div>
		@endforeach
	</div>

</section>

@endsection
@section('scripts')
<script src="{{asset('resources/views/admin/plans/plans.js')}}" type="text/javascript"></script>
@endsection