@extends('admin.layout.main')
@section('page_title',trans('labels.home'))
@section('content')
<?php
$isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile"));
?>
<div class="row">
	@if (Auth::user()->type == 1)
	<div class="col-xl-3 col-lg-6 col-md-6 col-12">
		<div class="card gradient-green-tea">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
						<div class="media-body white text-left">
                     <h3 class="font-large-1 mb-0">{{$restaurants}}</h3>
                     <span>{{ trans('labels.providers') }}</span>
                  </div>
                  <div class="media-right white text-right">
                     <i class="fa fa-home font-large-2"></i>
                  </div>
					</div>
				</div>
				<div id="Widget-line-chart2" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">				
				</div>
			</div>
		</div>
	</div>
	@endif
	<div class="col-xl-3 col-lg-6 col-md-6 col-12">
		<div class="card gradient-pomegranate">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
						<div class="media-body white text-left">
                     <h3 class="font-large-1 mb-0">{{$menus}}</h3>
                     <span>{{ trans('labels.categories') }}</span>
                  </div>
                  <div class="media-right white text-right">
                     <i class="ft-list font-large-2"></i>
                  </div>
					</div>
				</div>
				<div id="Widget-line-chart3" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">					
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-lg-6 col-md-6 col-12">
		<div class="card gradient-blackberry">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
                  <div class="media-body white text-left">
                     <h3 class="font-large-1 mb-0">{{$orders}}</h3>
                     <span>{{ trans('labels.orders') }}</span>
                  </div>
                  <div class="media-right white text-right">
                     <i class="fa fa-shopping-cart font-large-2"></i>
                  </div>
					</div>
				</div>
				<div id="Widget-line-chart" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">					
				</div>
			</div>
		</div>
	</div>
	@if (Auth::user()->type == 1)
	<div class="col-xl-3 col-lg-6 col-md-6 col-12">
		<div class="card gradient-ibiza-sunset">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
						<div class="media-body white text-left">
                     <h3 class="font-large-1 mb-0">{{$plans}}</h3>
                     <span>{{ trans('labels.pricing_plans') }}</span>
                  </div>
                  <div class="media-right white text-right">
                     <i class="fa fa-usd font-large-2"></i>
                  </div>
					</div>
				</div>
				<div id="Widget-line-chart1" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
				</div>
			</div>
		</div>
	</div>
	@endif
	@if (Auth::user()->type == 2)
	<div class="col-xl-6 col-lg-6 col-md-6 col-12">
		<div class="card bg-white">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
						<div class="media-body white">
							<div class="row justify-content-space-evenly">
								<div class="media-body white">
                                @if($isMob == "1")
                                <a href="whatsapp://send/send?text={{URL::to('/')}}/{{Auth::user()->slug}}" target="_blank" class="btn btn-social btn-min-width btn-adn-flat mr-2 mb-2 btn-adn btn_icon"><i class="fa-brands fa-whatsapp text-wa-color"></i> {{trans('labels.whatsapp')}}</a>
                                @else
                                <a href="https://web.whatsapp.com/send?text={{URL::to('/')}}/{{Auth::user()->slug}}" target="_blank" class="btn btn-social btn-min-width btn-adn-flat mr-2 mb-2 btn-adn btn_icon"><i class="fa-brands fa fa-whatsapp text-wa-color"></i>{{trans('labels.whatsapp')}}</a>
                                @endif
								</div>
								<div class="media-body white">
									<a href="https://www.facebook.com/sharer.php?u={{URL::to('/')}}/{{Auth::user()->slug}}" target="_blank" class="btn btn-social btn-min-width btn-facebook-flat mr-2 mb-2 btn-facebook btn_icon"><i class="fa-brands fa-facebook fa-fw"></i>{{trans('labels.facebook')}}</a>
								</div>
								<div class="media-body white">
									<a href="http://twitter.com/share?text={{Auth::user()->name}}&url={{URL::to('/')}}/{{Auth::user()->slug}}&hashtags=restaurant,whatsapporder,onlineorder" target="_blank" class="btn btn-social btn-min-width btn-twitter-flat mr-2 mb-2 btn-twitter btn_icon"><i class="fa-brands fa-twitter"></i> {{trans('labels.twitter')}}</a>
								</div>
								<div class="media-body white">
									<a href="https://www.linkedin.com/shareArticle?mini=true&url={{URL::to('/')}}/{{Auth::user()->slug}}" target="_blank" class="btn btn-social btn-min-width btn-linkedin-flat mr-2 mb-2 btn-linkedin btn_icon"><i class="fa-brands fa-linkedin"></i> {{trans('labels.linkedin')}}</a>
								</div>
							</div>
						</div>
						<div class="media-right white text-right">
							<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{URL::to('/')}}/{{Auth::user()->slug}}&choe=UTF-8" style="width: 156px; margin-top: -13px;" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif
	<div class="@if (Auth::user()->type == 1) col-sm-9 @endif @if (Auth::user()->type == 2) col-sm-12 @endif">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">{{ trans('labels.order_overview') }}</h4>
			</div>
			<div class="card-body">
				<div class="card-block">
					<div class="chart-info mb-3 ml-3">
						<select name="getyear" class="form-control rounded float-right col-lg-3 col-md-6" id="getyear" data-url="{{ URL::to('/admin/dashboard') }}">
							@foreach($order_years as $orderyear)
								<option value="{{$orderyear->year}}">{{$orderyear->year}}</option>
							@endforeach
						</select>
					</div>
					<canvas id="orderschart" height="80px"></canvas>
				</div>
			</div>
		</div>
	</div>
	@if (Auth::user()->type == 1)
	<div class="col-sm-3">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">{{ trans('labels.providers') }}</h4>
			</div>
			<div class="card-body">
				<div class="card-block">
					<div class="chart-info mb-3 ml-3">
						<select name="useryear" class="form-control rounded float-right col-lg-3 col-md-6" id="useryear" data-url="{{ URL::to('/admin/dashboard') }}">
						@foreach($user_years as $useryear)
							<option value="{{$useryear->year}}">{{$useryear->year}}</option>
						@endforeach
						</select>
					</div>
					<canvas id="userschart" class="users-canvas"></canvas>
				</div>
			</div>
		</div>
	</div>
	@endif
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">{{ trans('labels.earning') }}</h4>
			</div>
			<div class="card-body">
				<div class="card-block">
					<div class="chart-info mb-3 ml-3">
						<select name="earningsyear" class="form-control-sm rounded float-right col-auto" id="earningsyear" data-url="{{ URL::to('/admin/dashboard') }}">
							@foreach($earnings_years as $earnings)
								<option value="{{$earnings->year}}">{{$earnings->year}}</option>
							@endforeach
						</select>
					</div>
					<canvas id="earningschart" height="80px"></canvas>
				</div>
			</div>
		</div>
	</div>
  
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!--- orders-chart-script --->
<script type="text/javascript">
    var orderschart = null;
    var labels = {{Js::from($orderlabels)}};
    var deliverydata = {{Js::from($deliverydata)}};
    var pickupdata = {{Js::from($pickupdata)}};
    var year = {{Js::from($year)}};
    createOrdersChart(labels, deliverydata, pickupdata, year);
    $('#getyear').on('change', function() {
        "use strict";
        let year = $("#getyear").val();
        let myurl = $("#getyear").attr('data-url');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: myurl,
            method: "GET",
            data: {
                getyear: year
            },
            dataType: "JSON",
            success: function(data) {
                createOrdersChart(data.orderlabels, data.deliverydata, data.pickupdata, year)
            },
            error: function(data) {
                alert("Something went wrong!!");
                console.log(data);
            }
        });
    });
    function createOrdersChart(labels, deliverydata, pickupdata, month) {
        "use strict";
        const chartdata = {
            labels: labels,
            datasets: [{
                label: '{{trans("labels.order_type")}} : {{trans("labels.delivery")}}',
                backgroundColor: ['#87CEEB', '#BA55D3', '#28C667', '#4C3F90', '#DC59C7', '#374A1A',
                    '#FFE690', '#F58840', '#F33D80', '#F6BF08', '#CCFFCC', '#3DF37A'
                ],
                borderColor: ['#87CEEB', '#BA55D3', '#28C667', '#4C3F90', '#DC59C7', '#374A1A', '#FFE690',
                    '#F58840', '#F33D80', '#F6BF08', '#CCFFCC', '#3DF37A'
                ],
                // borderWidth: 2,
                data: deliverydata,
            }, {
                label: '{{trans("labels.order_type")}} : {{trans("labels.pickup")}}',
                backgroundColor: ['#FF7F50', '#A52A2A', '#FFE690', '#F58840', '#F33D80', '#F6BF08',
                    '#CCFFCC', '#3DF37A', '#87CEEB', '#BA55D3', '#28C667', '#4C3F90'
                ],
                borderColor: ['#FF7F50', '#A52A2A', '#FFE690', '#F58840', '#F33D80', '#F6BF08', '#CCFFCC',
                    '#3DF37A', '#87CEEB', '#BA55D3', '#28C667', '#4C3F90'
                ],
                // borderWidth: 2,
                data: pickupdata,
            }]
        };
        const config = {
            type: 'bar',
            data: chartdata
        };
        if (orderschart != null) {
            orderschart.destroy();
        }
        orderschart = new Chart(document.getElementById('orderschart'), config);
    }
</script>
<!--- users-chart-script --->
<script type="text/javascript">
    var userschart = null;
    var labels = {{Js::from($userslabels)}};
    var userdata = {{Js::from($userdata)}};
    var year = {{Js::from($year)}};
    createUsersChart(labels, userdata, year);
    $('#useryear').on('change', function() {
        "use strict";
        let year = $("#useryear").val();
        let myurl = $("#useryear").attr('data-url');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: myurl,
            method: "GET",
            data: {
                useryear: year
            },
            dataType: "JSON",
            success: function(data) {
                createUsersChart(data.userslabels, data.userdata, year)
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
    function createUsersChart(labels, userdata, year) {
        "use strict";
        const chartdata = {
            labels: labels,
            datasets: [{
                label: 'Users ',
                backgroundColor: ['rgba(54, 162, 235, 0.4)', 'rgba(255, 150, 86, 0.4)',
                    'rgba(140, 162, 198, 0.4)', 'rgba(255, 206, 86, 0.4)', 'rgba(255, 99, 132, 0.4)',
                    'rgba(255, 159, 64, 0.4)', 'rgba(255, 205, 86, 0.4)', 'rgba(75, 192, 192, 0.4)',
                    'rgba(54, 170, 235, 0.4)', 'rgba(153, 102, 255, 0.4)', 'rgba(201, 203, 207, 0.4)',
                    'rgba(255, 159, 64, 0.4)',
                ],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 150, 86, 1)', 'rgba(140, 162, 198, 1)',
                    'rgba(255, 206, 86, 1)', 'rgba(255, 99, 132, 1)', 'rgba(255, 159, 64, 1)',
                    'rgba(255, 205, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(54, 170, 235, 1)',
                    'rgba(153, 102, 255, 1)', 'rgba(201, 203, 207, 1)', 'rgba(255, 159, 64, 1)',
                ],
                borderWidth: 2,
                data: userdata,
            }]
        };
        const config = {
            type: 'doughnut',
            data: chartdata,
            options: {}
        };
        if (userschart != null) {
            userschart.destroy();
        }
        userschart = new Chart(document.getElementById('userschart'), config);
    }
</script>
<!--- earnings-chart-script --->
<script type="text/javascript">
    var earningschart = null;
    var labels = {{Js::from($earningslabels)}};
    var earningsdata = {{Js::from($earningsdata)}};
    var year = {{Js::from($year)}};
    createEarningsChart(labels, earningsdata, year);
    $('#earningsyear').on('change', function() {
        "use strict";
        let year = $("#earningsyear").val();
        let myurl = $("#earningsyear").attr('data-url');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: myurl,
            method: "GET",
            data: {
                earningsyear: year
            },
            dataType: "JSON",
            success: function(data) {
                createEarningsChart(data.earningslabels, data.earningsdata, year)
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
    function createEarningsChart(labels, earningsdata, year) {
        "use strict";
        const chartdata = {
            labels: labels,
            datasets: [{
                label: 'Earnings ' + year,
                backgroundColor: ['#FF7F50'],
                borderColor: ['#FF7F50'],
                pointStyle: 'circle',
                pointRadius: 5,
                pointHoverRadius: 10,
                data: earningsdata,
            }]
        };
        const config = {
            type: 'line',
            data: chartdata,
            options: {}
        };
        if (earningschart != null) {
            earningschart.destroy();
        }
        earningschart = new Chart(document.getElementById('earningschart'), config);
    }
</script>

<link rel="stylesheet" type="text/css" href="{{asset('resources/views/admin/dashboard/home.css')}}">
@endsection