<body data-col="2-columns" class=" 2-columns ">
   <div class="wrapper">
      <!-- main menu-->
      <div data-active-color="white" data-background-color="black" data-image="{{ asset('storage/app/public/admin-assets/img/sidebar-bg/04.jpg') }}" class="app-sidebar">
         <!-- main menu header-->
         <div class="sidebar-header">
            <div class="logo clearfix">
               
               <a href="#" class="logo-text float-left">
                  <span class="text align-middle">
                     @if (Auth::user()->type == 1)
                     {{trans('labels.admin_title')}}
                     @endif

                     @if (Auth::user()->type == 2)
                     {{trans('labels.menu_digital')}}
                     @endif

                  </span>
               </a>
            </div>
         </div>
         <!-- / main menu header-->
         <!-- main menu content-->
         <div class="sidebar-content">
            <div class="nav-container">
               <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
                  @if (Auth::user()->type == 1)
                  <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                     <a href="{{ URL::to('/admin/dashboard')}}" class="menu-item"><i class="ft-home"></i><span data-i18n="" class="menu-title">{{ trans('labels.home') }}</span></a>
                  </li>
                  <li class="{{ request()->is('admin/restaurants*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/admin/restaurants')}}" class="menu-item"><i class="ft-align-justify"></i><span data-i18n="" class="menu-title">{{ trans('labels.providers') }}</span></a>
                  </li>
                  <li class="{{ request()->is('admin/plans*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/admin/plans')}}" class="menu-item"><i class="fa fa-usd"></i><span data-i18n="" class="menu-title">{{ trans('labels.pricing_plans') }}</span></a>
                  </li>
                  @if (App\Models\SystemAddons::where('unique_identifier', 'payment')->first() != null && App\Models\SystemAddons::where('unique_identifier', 'payment')->first()->activated)
                  <li class="{{ request()->is('admin/payments*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/admin/payments')}}" class="menu-item"><i class="fa fa-credit-card"></i><span data-i18n="" class="menu-title">{{ trans('labels.payments') }}</span><span class="tag badge badge-pill badge-danger float-right mr-1 mt-1">Adic...</span></a>
                  </li>
                  @endif

                  @if (App\Models\SystemAddons::where('unique_identifier', 'coupons')->first() != null && App\Models\SystemAddons::where('unique_identifier', 'coupons')->first()->activated)
                  <li class="{{ request()->is('admin/coupons*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/admin/coupons')}}" class="menu-item"><i class="ft-tag"></i><span data-i18n="" class="menu-title">{{ trans('labels.coupons') }}</span><span class="tag badge badge-pill badge-danger float-right mr-1 mt-1">Adic...</span></a>
                  </li>
                  @endif

                  <!-- <li class="{{ request()->is('admin/whatsapp*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/admin/whatsapp')}}" class="menu-item"><i class="fa fa-exchange"></i><span data-i18n="" class="menu-title">{{ trans('labels.whatsapp') }}</a>
                  </li> -->

                  <li class="{{ request()->is('admin/transaction*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/admin/transaction')}}" class="menu-item"><i class="fa fa-exchange"></i><span data-i18n="" class="menu-title">{{ trans('labels.transaction') }}</a>
                  </li>


                  <li class="{{ request()->is('admin/settings*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/admin/settings')}}" class="menu-item"><i class="ft-settings"></i><span data-i18n="" class="menu-title">{{ trans('labels.settings') }}</span></a>
                  </li>
                  <li class="{{ request()->is('admin/apps*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/admin/apps')}}" class="menu-item"><i class="fa fa-puzzle-piece"></i><span data-i18n="" class="menu-title">{{ trans('labels.apps') }}</span><span class="tag badge badge-pill badge-danger float-right mr-1 mt-1">Adic...</span></a>
                  </li>
                  <li class="{{ request()->is('admin/clear-cache*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/admin/clear-cache')}}" class="menu-item"><i class="fa fa-refresh"></i><span data-i18n="" class="menu-title">{{ trans('labels.clear_cache') }}</span></a>
                  </li>
                  @endif


                  @if (Auth::user()->type == 2)
                  <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                     <a href="{{ URL::to('/admin/dashboard')}}" class="menu-item"><i class="ft-home"></i><span data-i18n="" class="menu-title">{{ trans('labels.home') }}</span></a>
                  </li>
                  <li class="{{ request()->is('vendor/menus*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/vendor/menus')}}" class="menu-item"><i class="ft-list"></i><span data-i18n="" class="menu-title">{{ trans('labels.menus') }}</span></a>
                  </li>
                  <li class="{{ request()->is('vendor/orders*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/vendor/orders')}}" class="menu-item"><i class="fa fa-shopping-cart"></i><span data-i18n="" class="menu-title">{{ trans('labels.orders') }}</span></a>
                  </li>
                  <li class="{{ request()->is('vendor/delivery-area*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/vendor/delivery-area')}}" class="menu-item"><i class="fa fa-map-marker"></i><span data-i18n="" class="menu-title">{{ trans('labels.delivery_area') }}</span></a>
                  </li>
                  <li class="{{ request()->is('vendor/working-hours*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/vendor/working-hours')}}" class="menu-item"><i class="ft-clock"></i><span data-i18n="" class="menu-title">{{ trans('labels.working_hours') }}</span></a>
                  </li>
                  <li class="{{ request()->is('vendor/plans*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/vendor/plans')}}" class="menu-item"><i class="fa fa-usd"></i><span data-i18n="" class="menu-title">{{ trans('labels.pricing_plans') }}</span></a>
                  </li>
                  @if (App\Models\SystemAddons::where('unique_identifier', 'payment')->first() != null && App\Models\SystemAddons::where('unique_identifier', 'payment')->first()->activated)
                  <li class="{{ request()->is('vendor/payments*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/vendor/payments')}}" class="menu-item"><i class="fa fa-credit-card"></i><span data-i18n="" class="menu-title">{{ trans('labels.payments') }}</span><span class="tag badge badge-pill badge-danger float-right mr-1 mt-1">Adic...</span></a>
                  </li>
                  @endif


                  <!-- @if (App\Models\SystemAddons::where('unique_identifier', 'coupons')->first() != null && App\Models\SystemAddons::where('unique_identifier', 'coupons')->first()->activated)
                  <li class="{{ request()->is('vendor/coupons*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/vendor/coupons')}}" class="menu-item"><i class="ft-tag"></i><span data-i18n="" class="menu-title">{{ trans('labels.coupons') }}</span><span class="tag badge badge-pill badge-danger float-right mr-1 mt-1">Adic...</span></a>
                  </li>
                  @endif -->

                  <li class="{{ request()->is('vendor/transaction*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/vendor/transaction')}}" class="menu-item"><i class="fa fa-exchange"></i><span data-i18n="" class="menu-title">{{ trans('labels.transaction') }}</a>
                  </li>


                  <li class="{{ request()->is('vendor/settings*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/vendor/settings')}}" class="menu-item"><i class="ft-settings"></i><span data-i18n="" class="menu-title">{{ trans('labels.settings') }}</span></a>
                  </li>
                  <li class="has-sub nav-item {{ Request::routeIs('privacypolicy') ? 'open' : '' }}">
                     <a href="#">
                        <i class="ft-shield"></i>
                        <span class="menu-title">{{ trans('labels.cms_pages') }}</span>
                     </a>
                     <ul class="menu-content">
                        <li class="{{ Request::routeIs('privacypolicy') ? 'active is-shown' : '' }}">
                           <a href="{{ URL::to('/vendor/privacypolicy')}}">
                              <span class="menu-title">{{ trans('labels.privacypolicy') }}</span>
                           </a>
                        </li>
                        <li class="{{ Request::routeIs('terms') ? 'active is-shown' : '' }}">
                           <a href="{{ URL::to('/vendor/terms')}}">
                              <span class="menu-title">{{ trans('labels.terms') }}</span>
                           </a>
                        </li>
                     </ul>
                  </li>
                  <li class="{{ request()->is('vendor/table*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/vendor/table')}}" class="menu-item"><i class="fa fa-ticket"></i><span data-i18n="" class="menu-title">{{ trans('labels.book_table') }}</span></a>
                  </li>
                  <li class="{{ request()->is('vendor/share*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/vendor/share')}}" class="menu-item"><i class="ft-share"></i><span data-i18n="" class="menu-title">{{ trans('labels.share') }}</span></a>
                  </li>
                  </li>
                  @endif


               </ul>
            </div>
         </div>
         <!-- main menu content-->
         <div class="sidebar-background"></div>
      </div>
      <!-- / main menu-->