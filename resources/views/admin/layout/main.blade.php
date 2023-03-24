<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>@if (Auth::user()->type == 1) Admin @else Vendor @endif | @yield('page_title')</title>
   <link rel="icon" href='{{Helper::admininfo()->favicon}}' type="image/x-icon">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/fonts/feather/style.min.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/fonts/simple-line-icons/style.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/fonts/font-awesome/css/font-awesome.min.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/vendors/css/perfect-scrollbar.min.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/vendors/css/prism.min.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/vendors/css/chartist.min.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/vendors/css/tables/datatable/datatables.min.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/css/app.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/js/sweet-alert/plugins/sweetalert/css/sweetalert.css') }}">

   <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900|Montserrat:300,400,500,600,700,800,900" rel="stylesheet">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.css')}}">
   <meta name="csrf-token" content="{{ csrf_token() }}" />
   @yield('styles')
</head>
<body>
   @include('admin.layout.header.header_navbar')
   @include('admin.layout.main_menu')
   <div class="main-panel">
      <div class="main-content">
         <div class="content-wrapper">
            <?php
            $checkplan = Helper::checkplan(Auth::user()->id);
            $v = json_decode(json_encode($checkplan));
            if ($v->original->status == "2") {
               $infomsg = $v->original->message;
            }
            ?>
            @if(isset($infomsg))
            <div class="alert alert-warning" role="alert">
               {{$infomsg}} <u><a href="{{ URL::to('/vendor/plans') }}">{{trans('labels.click_here')}}</a></u> {{trans('labels.to_upgrade')}}.
            </div>
            @endif
            @yield('content')
         </div>
      </div>
   </div>
   </div>
   </div>
</body>
</html>
{{-- Edit Profile Modal Start --}}
<div class="modal fade" id="bootstrap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title" id="myModalLabel35"> {{trans('labels.update_profile')}} </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form class="form" id="myProfileEditForm" action="{{ URL::to('admin/profile/edit/'.Auth::user()->id)}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-body">
               <div class="form-group col-md-12">
                  <div class="d-flex align-items-start align-items-sm-center gap-4">
                     <img src="{{ asset('storage/app/public/admin-assets/img/portrait/avatars/'.Auth::user()->avatar) }}" class="d-block w-px-100 h-px-100 rounded" alt="user-avatar" id="uploadedAvatar">
                     <div class="button-wrapper">
                        <label for="avatar-upload" class="btn btn-primary me-2 mb-3 waves-effect waves-light" tabindex="0">
                          <span class="d-none d-sm-block">Carregar nova foto</span>
                          <i class="ti ti-upload d-block d-sm-none"></i>
                          <input type="file" id="avatar-upload" class="account-file-input" name="avatar-image" hidden="" accept="image/png, image/jpeg, image/jpg" onchange="uploadImage(event)">
                        </label>
                        <button type="button" class="btn btn-label-secondary account-image-reset mb-3 waves-effect" id="avatar-reset">
                          <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                          <span class="d-none d-sm-block">Reset</span>
                        </button>

                        <div class="text-muted">Permitido JPG, GIF e PNG. Max size of 400K</div>
                        @error('avatar-image_error') <span class="text-danger" id="avatar-image_error">Image Error!!!</span> @enderror
                     </div>
                  </div>
               </div>
               <hr class="my-0">
               <div class="form-group col-md-12">
                  <label for="name"> {{trans('labels.name')}} </label>
                  <input type="text" id="name" class="form-control @error('name_error') is-invalid @enderror" name="name" value="{{Auth::user()->name}}">
                  @error('name_error') <span class="text-danger" id="name_error"></span> @enderror
               </div>
               <div class="form-group col-md-12">
                  <label for="name"> {{trans('labels.email')}} </label>
                  <input type="email" id="email" class="form-control @error('email_error') is-invalid @enderror" name="email" value="{{Auth::user()->email}}" @if(Auth::user()->type == 2) readonly @endif>
                  @error('email_error') <span class="text-danger" id="email_error"></span> @enderror
               </div>
               <hr class="my-0">
               <div class="modal-footer">
                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">{{trans('labels.close')}}</button>
                  @if (env('Environment') == 'sandbox')
                  <button type="button" id="btn_update_profile" class="btn btn-raised btn-primary" onclick="myFunction()"> <i class="ft-edit"></i> {{trans('labels.update')}} </button>
                  @else
                  <button type="submit" id="btn_update_profile" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{trans('labels.update')}} </button>
                  @endif
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
{{-- Change Password Modal Start --}}
<div class="modal fade text-left change_password_modal" id="change_password_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title" id="myModalLabel35"> {{trans('labels.change_password')}} </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
         <form class="form" id="change_password_form" action="{{ URL::to('admin/changepassword')}}" method="POST">
            @csrf

            <div class="form-body">
               <div class="form-group col-md-12">
                  <label for="old_password"> {{trans('labels.old_password')}} </label>
                  <div class="controls">
                     <input type="password" name="old_password" id="old_password" class="form-control  @error('pass_error') is-invalid @enderror">
                     @error('pass_error') <span class="text-danger" id="pass_error"></span> @enderror

                  </div>
               </div>
               <hr class="gray">
               <div class="form-group col-md-12">
                  <label for="new_password"> {{trans('labels.new_password')}} </label>
                  <div class="controls">
                     <input type="password" name="new_password" id="new_password" class="form-control  @error('new_password') is-invalid @enderror">
                  </div>
               </div>
               <div class="form-group col-md-12">
                  <label for="c_new_password"> {{trans('labels.confirm_password')}} </label>
                  <div class="controls">
                     <input type="password" name="c_new_password" id="c_new_password" class="form-control  @error('c_new_password') is-invalid @enderror">
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">{{trans('labels.close')}}</button>
                  @if (env('Environment') == 'sandbox')
                  <button type="button" id="btn_update_profile" class="btn btn-raised btn-primary" onclick="myFunction()"> <i class="ft-edit"></i> {{trans('labels.update')}} </button>
                  @else
                  <input type="submit" id="btn_update_password" class="btn btn-raised btn-primary" value="{{trans('labels.change')}}">
                  @endif

               </div>
            </div>
         </form>
      </div>
   </div>
</div>
<script src="{{ asset('storage/app/public/admin-assets/js/jquery-3.6.0.js')}}"></script>
<script src="{{ asset('storage/app/public/admin-assets/vendors/js/core/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/vendors/js/core/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/vendors/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/vendors/js/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/vendors/js/jquery.matchHeight-min.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/vendors/js/screenfull.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/vendors/js/pace/pace.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/vendors/js/datatable/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/js/app-sidebar.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/js/notification-sidebar.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/js/customizer.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/js/data-tables/datatable-basic.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/js/sweet-alert/plugins/sweetalert/js/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/js/jquery.validate.js')}}" type="text/javascript"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
   // Toaster Success/error Message Start
   toastr.options = {
      "closeButton": true,
      "progressBar": true
   }

   @if(Session::has('success'))
   toastr.options = {
      "closeButton": true,
      "progressBar": true
   }
   toastr.success("{{ session('success') }}");
   @endif

   @if(Session::has('error'))
   toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "timeOut": 10000
   }
   toastr.error("{{ session('error') }}");
   @endif

   // Pusher.logToConsole = true;

   // var pusher = new Pusher('2f9ada63fb2c26d046f9', {
   //    cluster: 'sa1'
   // });

   // var channel = pusher.subscribe('my-channel');
   // channel.bind('my-event', function(data) {
   //    alert(JSON.stringify(data));
   // });

   // Change Password Form Validation 
   $("#change_password_form").validate({
      rules: {
         "old_password": {
            required: true
         },
         "new_password": {
            required: true
         },
         "c_new_password": {
            required: true,
            equalTo: "#new_password"
         }
      },
      messages: {
         "old_password": {
            required: "{{trans('labels.enter_old_password')}}"
         },
         "new_password": {
            required: "{{trans('labels.enter_new_password')}}"
         },
         "c_new_password": {
            required: "{{trans('labels.enter_confirm_password')}}",
            equalTo: "{{trans('labels.not_match_password')}}"
         }
      }
   });
   
   $(document).on("submit", "#change_password_form", function(e) {
      var old_password = $("#old_password").val();
      var new_password = $("#new_password").val();
      var c_new_password = $("#c_new_password").val();
      if (old_password != new_password) {
         if (new_password == c_new_password) {
            return true;
         } else {
            alert("{{trans('labels.new_confirm_password_match')}}");
            return false;
         }
      } else {
         alert("{{trans('labels.new_old_password_different')}}");
         return false;
      }
   })
   function myFunction() {
      toastr.error("Erro!", "Permission disabled for demo mode");
   }
   function paymentError(str) {
      toastr.error("Erro!", str);
   }
   $('.list-group-item-action').click(function() {
      $('.list-group-menu .active').removeClass('active');
      $(this).addClass('active');
      $('body').animate({
         scrollTop: eval($('#' + $(this).attr('target')).offset().top - 70)
      }, 1000);
   });

   $('#btn_paypal').click(function(event) {
      event.preventDefault();

      var amount = $("#amount_paypal").val();
      var business = $("#business").val();
      var plan = $("#item_name").val();
      var plan_period = $('#plan_period').val();
      var payer_email = $("#payer_email").val();
      var payer_name = $("#payer_name").val();
      var item_number = $("#item_number").val(); // payment_id
      var no_shopping = $("#no_shipping").val();
      var currency_code = $("#currency_code").val();
      var notify_url = $("#notify_url").val();
      var cancel_return = $("#cancel_return").val();
      var return_pay = $("#return_pay").val();
      var payment_type = $('input[name="payment"]:checked').attr("data-payment_type");

      $.ajax({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         url: "{{ URL::to('/vendor/plans/notify/reset') }}",
         type: 'POST',
         dataType: 'json',
         data: {
            payment_id: item_number,
            business: business,
            amount: amount,
            payer_email: payer_email,
            payer_name: payer_name,
            no_shopping: no_shopping,
            currency_code: currency_code,
            payment_type: payment_type,
            plan: plan,
            plan_period: plan_period,
            notify_url: notify_url,
            cancel_return: cancel_return,
            return_pay: return_pay
         },
         success: function(response) {
            if (response.status == 1) {
               var message = JSON.parse(response.message);
               $("#return_pay").val(message.url);
               $("#item_number").val(message.id);
               $('#payment-form').submit();
               return true;
            }
         },
         error: function(error) {
            paymentError("{{trans('messages.payment_error')}}");
            window.location.href = "{{ URL::to('/vendor/plans/cancel')}}";
            return false;
         }
      });
   });

   $('#DataTables_Table_0').DataTable({
      "language": {
       "sProcessing": "Processing ...",
       "sLengthMenu": "Mostrar _MENU_ entradas",
       "sZeroRecords": "No matching records found",
       "sEmptyTable": "No data available in table",
       "sInfo": "Mostrando _START_ to _END_ of _TOTAL_ entradas",
       "sInfoEmpty": "Mostrando 0 to 0 of 0 entradas",
       "sInfoFiltered": "(filtered from _MAX_ total entries)",
       "sInfoPostFix": "",
       "sSearch": "Procurar:",
       "sUrl": "",
       "sInfoThousands": ",",
       "sLoadingRecords": "Loading...",
       "oPaginate": {
         "sFirst": "First", "sLast": "Last", "sNext": "Próximo", "sPrevious": "Anterior"
       },
       "oAria": {
         "sSortAscending": ": activate to sort column ascending", "sSortDescending": ": activate to sort column descending"
       }
  }
   })

   $("#notify_item").click(function(e) {
      e.preventDefault();
   })

   var notifies = {
      delete_cnt: 0,
      read_cnt: 0,
      data: []
   };
   var notify_index = 0;
   var notification_permission = false;

   function notifyItems() {
      var items = '';
      notifies.data.forEach((item) => {
         if (!item.is_deleted) {
            items += `<li class="list-group-item list-group-item-action-notify dropdown-notifications-item ${item.is_read ? 'marked-as-read' : ''}" id="notify_item_${item.id}">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar">
                    <span class="avatar-initial rounded-circle bg-label-success"><i class="ti ti-shopping-cart"></i></span>
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-1">Uau! Você tem um novo pedido. 🛒 </h6>
                  <p class="mb-0">${item.data['sender']} fez um pedido</p>
                  <small class="text-muted">${item.data['period']} ago</small>
                </div>
                <div class="flex-shrink-0 dropdown-notifications-actions">
                  <a onClick="notifyItemRead(${item.id})" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                  <a onClick="notifyItemClose(${item.id})" class="dropdown-notifications-archive"><span class="ti ti-x"></span></a>
                </div>
              </div>
            </li>`;
         }
      });

      $("#notify_items").html(items);

      $("#notify_count").addClass('bg-danger');
      $("#notify_count").text(notifies.data.length - notifies.read_cnt - notifies.delete_cnt);

      if (notifies.data.length - notifies.read_cnt - notifies.delete_cnt == 0) {
         $("#notify_count").removeClass('bg-danger');
      }
   }

   function notifyFunc(str) {
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
                  notifies.data.push({
                     id: notify_index++,
                     is_read: false,
                     is_deleted: false,
                     data: item
                  });
               });

               $("#notify_count").addClass('bg-danger');
               $("#notify_count").text(notifies.data.length - notifies.read_cnt - notifies.delete_cnt);
               
               notifyItems();
            }
         },
         error: function(error) {
            //console.log(error);
         }
      });
   }

   $(document).ready(function() {

      function notifyEvent() {
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
               type: 'event'
            },
            success: function(response) {
               if (response.status == 1) {
                  toastr.options = {
                     "closeButton": true,
                     "progressBar": true,
                     "timeOut": 30000
                  }

                  toastr.info('info', 'Você recebeu um novo pedido!!!');

                  playSound("{{ asset('storage/app/public/assets/mp3/Error.mp3') }}");

                  if (notification_permission) {
                     const text = `{{Auth::user()->name}}! Você recebeu um novo pedido. Por favor check.`;
                     const notification = new Notification('OneOutlet', { body: text});
                  }

                  response.message.forEach(item => {
                     notifies.data.push({
                        id: notify_index++,
                        is_read: false,
                        is_deleted: false,
                        data: item
                     });
                  });
                  toastr.options = {
                     "closeButton": true,
                     "progressBar": true,
                  }
                  $("#notify_count").addClass('bg-danger');
                  $("#notify_count").text(notifies.data.length - notifies.read_cnt - notifies.delete_cnt);
                  notifyItems();
               }
            },
            error: function(error) {
               //console.log(error);
            }
         })
      }

      checkPermission();

      //playSound("{{ asset('storage/app/public/assets/mp3/Error.mp3') }}");

      notifyFunc('onload');

      setInterval(notifyEvent, 20000);
   });

   function notifyItemClick(event) {
   }

   function checkPermission() {
      Notification.requestPermission(function (status) {
         if (Notification.permission !== status) {
            Notification.permission = status;
         }
         if (Notification.permission === 'granted') {
            notification_permission = true;
         } else if (Notification && Notification.permission !== "denied") {
            notification_permission = true;
         } else {
            notification_permission = false;
         }
      });
   }

   function notifyItemRead(id) {
      if ($("#notify_item_" + id).hasClass('marked-as-read')) {
         notifies.read_cnt--;
         notifies.data[id].is_read = false;
         $("#notify_item_" + id).removeClass('marked-as-read');
      }
      else {
         $("#notify_item_" + id).addClass('marked-as-read');
         notifies.read_cnt++;
         notifies.data[id].is_read = true;
      }

      $("#notify_count").addClass('bg-danger');
      $("#notify_count").text(notifies.data.length - notifies.read_cnt - notifies.delete_cnt);

      if (notifies.data.length - notifies.read_cnt - notifies.delete_cnt == 0) {
         $("#notify_count").removeClass('bg-danger');
      }
   }

   function notifyItemClose(id) {
      var x = 0;
      notifies.data.forEach(item => {
         if (item.id == id) {
            notifies.data[x].is_deleted = true;
            notifies.data[x].is_read = true;
            notifies.delete_cnt ++;
            return false;
         }
         x++;
      })
      
      if ($("#notify_item_" + id).hasClass('marked-as-read')) {
         notifies.read_cnt--;
      }

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
            data: notifies.data[x].data['timestamp']
         },
         success: function(response) {
            if (response.status == 1) {
            }
         },
         error: function(error) {
         }
      });

      notifyItems();
   }

   $("#notify_markasread").click(function () {
      notifies.data.forEach(item => {
         item.is_read = true;
      })
      notifies.read_cnt = notifies.data.length - notifies.delete_cnt;

      notifyItems();  
   });

   function playSound(url) {
     var audio = new Audio(url);
     audio.oncanplaythrough = (event) => {
         var playedPromise = audio.play();
         if (playedPromise) {
            playedPromise.catch((e) => {
               if (e.name === 'NotAllowedError' || e.name === 'NotSupportedError') { 
               }
            }).then(() => {
            });
        }
      }
   }

   window.onbeforeunload = function(event)
   {
      var data = [];
      notifies.data.forEach(item => {
         if (item.is_read == true && item.is_deleted == false) {
            data.push(item.data['timestamp']);
         }
      });

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
            type: 'update',
            data: data
         },
         success: function(response) {
            if (response.status == 1) {
            }
         },
         error: function(error) {
         }
      });
     //return confirm("Confirm refresh");
   };

   function uploadImage(evt) {
      console.log('hello');
      let file = evt.target.files[0];
      if (file.size !== undefined) {
         if (file.type !== "image/png" && file.type !== "image/jpg" && file.type !== "image/jpeg")
         {
            toastr.error('erro!!', 'Os formatos de arquivo de imagem são apenas png, jpeg, jpg');
            clearFileInput("avatar-upload");
            return;
         }

         if (file.size / 1024 > 400) {
            toastr.error('erro!!', 'Image File is bigger than 400KB');
            clearFileInput("avatar-upload");
            return;
         }

         let reader = new FileReader();

         reader.readAsDataURL(file);

         reader.onload = function() {
            $("#uploadedAvatar").attr("src", reader.result);
         };

         reader.onerror = function() {
            clearFileInput("avatar-upload");
            $("#uploadedAvatar").attr("src", "{{ asset('storage/app/public/admin-assets/img/portrait/avatars/'.Auth::user()->avatar) }}");
         };
      }
   }

   $("#avatar-reset").click(function() {
      $("#uploadedAvatar").attr("src", "{{ asset('storage/app/public/admin-assets/img/portrait/avatars/'.Auth::user()->avatar) }}");
      clearFileInput("avatar-upload");
   });

   function clearFileInput(id) 
   { 
       var oldInput = document.getElementById(id); 

       var newInput = document.createElement("input"); 

       newInput.type = "file"; 
       newInput.id = oldInput.id; 
       newInput.name = oldInput.name; 
       newInput.className = oldInput.className; 
       newInput.style.cssText = oldInput.style.cssText;
       newInput.hidden = oldInput.hidden;
       newInput.accept = oldInput.accept;
       newInput.onchange = oldInput.onchange;
       oldInput.parentNode.replaceChild(newInput, oldInput); 
   }

   $("#myProfileEditForm").submit(function(e) {
      e.preventDefault();
      var formData = new FormData(this);

      $.ajax({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         url: "{{ URL::to('admin/profile/edit/'.Auth::user()->id)}}",
         type: 'POST',
         data: formData,
         cache:false,
         contentType: false,
         processData: false,
         success: function(response) {
            if (response.status == 1) {
               toastr.success('succsso!', "{{trans('messages.success')}}");
               window.location.reload();
            }
         },
         error: function(error) {
            var message = JSON.parse(error.responseText);
            if (message.status == 1) {
               toastr.error('erro!!', message.message);
            }
         }
      })
   });

</script>

@yield('scripts')