 {{-- Navbar (Header) Start --}}
<link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/vendor/fonts/fontawesome.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/vendor/fonts/tabler-icons.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/assets/css/demo.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/vendor/css/rtl/core.css') }}" class="template-customizer-core-css">
<link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/vendor/css/rtl/theme-default.css') }}" class="template-customizer-core-css">
<link rel="stylesheet" type="text/css" href="{{ asset('resources/views/admin/layout/header/header.css') }}">
<!-- <script type="text/javascript" src="{{ asset('storage/app/public/vendor/js/template-customizer.js') }}"></script> -->
<script src="{{ asset('storage/app/public/vendor/js/bootstrap.js') }}" type="text/javascript"></script>

<div class="layout-page layout-navbar-fixed layout-menu-fixed">
   <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
         <button type="button" data-toggle="collapse" class="navbar-toggle d-lg-none float-left"><span class="sr-only">{{ trans('labels.toggle_navigation') }}</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
         </button>
      </div>

      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
         <div class="navbar-nav align-items-center">
          <div class="nav-item navbar-search-wrapper mb-0">
            <a class="nav-item nav-link search-toggler d-flex align-items-center px-0" href="javascript:void(0);">
              <i class="ti ti-search ti-md me-2"></i>
              <!-- <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span> -->
            </a>
          </div>
        </div>

         <ul class="navbar-nav flex-row align-items-center ms-auto">
            
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
               <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                 <i class="ti ti-bell ti-md"></i>
                 <span class="badge rounded-pill badge-notifications" id="notify_count">0</span>
               </a>
               
               <ul class="dropdown-menu dropdown-menu-end py-0">
                  <li class="dropdown-menu-header border-bottom">
                   <div class="dropdown-header d-flex align-items-center py-3">
                     <h5 class="text-body mb-0 me-auto">{{ trans('labels.notifications') }}</h5>
                     <a id="notify_markasread" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Mark all as read" data-bs-original-title="Mark all as read"><i class="ti ti-mail-opened fs-4"></i></a>
                   </div>
                 </li>

                  <li class="dropdown-notifications-list scrollable-container ps">
                    <ul class="list-group list-group-flush" id="notify_items">
                       <!-- <li class="list-group-item list-group-item-action-notify dropdown-notifications-item" id="notify_item">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <img src="../../assets/img/avatars/1.png" alt="" class="h-auto rounded-circle">
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-1">Congratulation Lettie 🎉</h6>
                              <p class="mb-0">Won the monthly best seller gold badge</p>
                              <small class="text-muted">1h ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="ti ti-x"></span></a>
                            </div>
                          </div>
                        </li> -->
                    </ul>
                 </li>
                 
                 <li class="dropdown-menu-footer border-top">
                  @if(Auth::user()->type == 1)
                     <a href="{{URL::to('/admin/notifications')}}" class="dropdown-item d-flex justify-content-center text-primary p-2 h-px-40 mb-1 align-items-center">
                  @elseif(Auth::user()->type == 2)
                     <a href="{{URL::to('/vendor/notifications')}}" class="dropdown-item d-flex justify-content-center text-primary p-2 h-px-40 mb-1 align-items-center">
                  @endif
                        {{ trans('labels.view_all_notifications') }}
                     </a>
                  </li>
               </ul>
            </li>

            <li class="nav-item navbar-dropdown dropdown-user dropdown">
               <a id="dropdownBasic3" href="#" data-toggle="dropdown" class="nav-link dropdown-toggle hide-arrow">
                  <div class="avatar avatar-online">
                     <img src="{{ asset('storage/app/public/admin-assets/img/portrait/avatars/'.Auth::user()->avatar) }}" alt="" class="h-auto rounded-circle">
                  </div>
               </a>
               <ul class="dropdown-menu dropdown-menu-end py-0" data-bs-popper>
                  <li>
                   <a class="dropdown-item" href="#">
                     <div class="d-flex">
                       <div class="flex-shrink-0 me-3">
                         <div class="avatar avatar-online">
                           <img src="{{ asset('storage/app/public/admin-assets/img/portrait/avatars/'.Auth::user()->avatar) }}" alt="" class="h-auto rounded-circle">
                         </div>
                       </div>
                       <div class="flex-grow-1">
                        @if(Auth::user()->type == 1)
                           <span class="fw-semibold d-block">{{Auth::user()->name}}</span>
                           <small class="text-muted">{{ trans('labels.admin_title') }}</small>
                        @elseif(Auth::user()->type == 2)
                           <span class="fw-semibold d-block">{{Auth::user()->name}}</span>
                           <small class="text-muted">{{ trans('labels.vendor') }}</small>
                        @endif
                         
                       </div>
                     </div>
                   </a>
                 </li>
                 <li>
                   <div class="dropdown-divider"></div>
                 </li>
                 <li>
                   <a class="dropdown-item" data-toggle="modal" data-target="#bootstrap">
                     <i class="ft-edit mr-2"></i>
                     <span class="align-middle">{{ trans('labels.edit_profile') }}</span>
                   </a>
                 </li>
                 <li>
                   <a class="dropdown-item" data-toggle="modal" data-target="#change_password_modal">
                     <i class="fa fa-key mr-2"></i>
                     <span class="align-middle">{{ trans('labels.change_password') }}</span>
                   </a>
                 </li>
                 <li>
                   <div class="dropdown-divider"></div>
                 </li>
                 @if(Auth::user()->type == 2)
                    <li>
                      <a class="dropdown-item" href="{{ URL::to(Auth::user()->slug)}}" target="_blank">
                        <i class="fa-solid fa-shop fa-fw mr-2"></i>
                        <span class="align-middle">{{ trans('labels.see_product_catalog') }}</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                  @endif
                 <li>
                   <a class="dropdown-item" href="{{ URL::to('admin/logout') }}">
                     <i class="ti ti-logout me-2 ti-sm"></i>
                     <span class="align-middle">{{ trans('labels.logout') }}</span>
                   </a>
                 </li>
               </ul>
            </li>
         </ul>
      </div>
   </nav>
</div>
<!-- Navbar (Header) Ends