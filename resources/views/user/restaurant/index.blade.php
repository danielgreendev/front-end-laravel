@extends('user.main')

@section('header')

@include('user.main_resourse')

@endsection('header')

@section('content')

@include('front.landing.layout.header')

<section>
	<div class="rest_header section">
		
	</div>
</section>

<section>
	<div class="list_body section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<form class="hero__form v2 filter">
            <div class="row">
              <div class="col-lg-4 col-md-12" style="display: grid;">
                <input class="hero__form-input custom-select" type="text" name="place-event" id="place-event" placeholder="What are you looking for?">
              </div>
              <div class="col-lg-3 col-md-12">
                <select class="hero__form-input  custom-select" id="search_locate" style="display: none;">
                  <option>Select Location </option>
                  <option>New York</option>
                  <option>California</option>
                  <option>Washington</option>
                  <option>New Jersey</option>
                  <option>Los angeles</option>
                  <option>Florida</option>
                 </select>

                 <div class="nice-select hero__form-input custom-select" tabindex="0">
                 	<span class="current">Select Location</span>
                 	<ul class="list">
                 		<li data-value="Select Location" class="option selected focus">Select Location</li>
                 		<li data-value="New York" class="option">New York</li>
                 		<li data-value="California" class="option">California</li>
                 		<li data-value="Washington" class="option">Washington</li>
                 		<li data-value="New Jersey" class="option">New Jersey</li>
                 		<li data-value="Los angeles" class="option">Los angeles</li>
                 		<li data-value="Florida" class="option">Florida</li>
                 	</ul>
                 	<i class="lni lni-chevron-down"></i>
                 </div>
                  
              </div>
              <div class="col-lg-3 col-md-12">
                <select class="hero__form-input  custom-select" id="search_category" style="display: none;">
                    <option>Select Categories</option>
                    <option>Art's</option>
                    <option>Health</option>
                    <option>Hotels</option>
                    <option>Real Estate</option>
                    <option>Rentals</option>
                </select>

                <div class="nice-select hero__form-input custom-select" tabindex="0">
                	<span class="current">Select Categories</span>
                	<ul class="list">
                		<li data-value="Select Categories" class="option selected focus">Select Categories</li>
                		<li data-value="Art's" class="option">Art's</li>
                		<li data-value="Health" class="option">Health</li>
                		<li data-value="Hotels" class="option">Hotels</li>
                		<li data-value="Real Estate" class="option">Real Estate</li>
                		<li data-value="Rentals" class="option">Rentals</li>
                	</ul>
                	<i class="lni lni-chevron-down"></i>
                </div>
            	</div>
            	
            	<div class="col-lg-2 col-md-12">
                <div class="submit_btn text-right md-left" id="btn_search">
                  <button class="btn v3  mar-right-5"><i class="lni lni-search-alt" aria-hidden="true"></i> Search</button>
                </div>
              </div>
            </div>
          </form>
				</div>

				<div class="row pad-tb-50 align-items-center">
					<div class="col-lg-7"></div>
					<div class="col-lg-2 col-sm-4 col-12"></div>
					<div class="col-lg-3 col-sm-8 col-12">
						<div class="item-element res-box  text-right xs-left">
              <p>Showing <span>1-10 of 69</span> Listings</p>
            </div>
					</div>
				</div>

				<div class="col-md-12">
					<div id="list_view" class="tab-pane product-list">
					@foreach($settings as $key => $setting)
						<div class="row trending-place-item">
							<div class="col-md-6 no-pad-lr">
								<div class="trending-img">
									<img src="{{Helper::webinfo(@$setting->restaurant)->og_image}}">
									<span class="trending-rating-green">1</span>
									<span class="save-btn">
										<i class="lni lni-heart-filled"></i>
									</span>
								</div>
							</div>
							<div class="col-md-6 no-pad-lr">
								<div class="trending-title-box">
									<h4><a href="{{ URL::to($setting->slug)}}">{{$setting->website_title}}</a><span class="founder">{{trans('labels.founder')}}: {{$setting->name}}</span></h4>
									<div class="customer-review">
										<div class="rating-summary float-left">
											<div class="rating-result" title="60%">
												<ul class="product-rating">
													<li class="lni lni-star-filled"></li>
													<li class="lni lni-star-filled"></li>
													<li class="lni lni-star-filled"></li>
													<li class="lni lni-star-half"></li>
													<li class="lni lni-star-half"></li>
												</ul>
											</div>
										</div>
										<div class="customer-review float-right">
											<p><a href="#">3 {{trans('labels.reviews')}}</a></p>
										</div>
									</div>
									<ul class="trending-address">
										<li>
											<i class="bi bi-geo-alt"></i>
											<p>{{$setting->address}}</p>
										</li>
										<li>
											<i class="lni lni-phone"></i>
											<p>{{$setting->contact}}</p>
										</li>
										<li>
											<i class="lni lni-world"></i>
											<p>{{$setting->email}}</p>
										</li>
									</ul>
									<div class="trending-bottom mar-top-15 pad-bot-30">
										<div class="trend-left float-left">
											<p>{{trans('labels.brief')}}:</p>
										</div>
										<div class="trend-right float-right">
											<div class="trend-open"><i class="lni lni-alarm-clock"></i>
												@if (Helper::is_store_closed($setting->restaurant) == 2)
													Open <p>till {{Helper::restaurant_time_today($setting->id)}}</p>
												@else
													Closed
												@endif
											</div>
										</div>
									</div>
									<div class="desc_brief">
										<p>
											<?php 
												$str = $setting->description; 
												if(strlen($str) > 200) 
													$str = substr($str, 0, 197).'...';
											?>{{$str}}
										</p>
									</div>
								</div>
							</div>
						</div>
					@endforeach
					</div>
				</div>
				
				<div class="post-nav nav-res pad-top-10">
          <div class="row">
            <div class="col-md-8 offset-md-2  col-xs-12 ">
              <div class="page-num text-center">
                <ul>
                  <li class="page-active" id="btn_page1"><a href="#">1</a></li>
                  <li id="btn_page2"><a href="#">2</a></li>
                  <li id="btn_page3"><a href="#">3</a></li>
                  <li id="btn_page4"><a href="#">4</a></li>
                  <li><a href="#" id="btn_page_next"><i class="lni lni-chevron-right"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
			</div>	
		</div>
	</div>
</section>

@endsection

@section('scripts')
	<script type="text/javascript" src="{{asset('resources/views/user/restaurant/restaurant.js')}}"></script>
  <link rel="stylesheet" type="text/css" href="{{asset('resources/views/user/restaurant/restaurant.css')}}">
@endsection