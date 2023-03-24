<!DOCTYPE html>
<html lang="en" class="loading">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
   <meta name="author" content="Gravity Infotech">
   <title>{{trans('labels.login')}}</title>
   <link rel="icon" href='{{Helper::admininfo()->favicon}}' type="image/x-icon">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/css/app.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.css')}}">
</head>
<body data-col="1-column" class=" 1-column  blank-page blank-page">
   <div class="wrapper">
      <div class="main-panel">
         <div class="main-content">
            <div class="content-wrapper">
               <!--Login Page Starts-->
               <section id="login">
                  <div class="container-fluid">
                     <div class="row full-height-vh">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                           <div class="card bg-dark text-center width-400">
                              <div class="card-img overlap">
                                 <img alt="element 06" class="mb-1" src="{{Helper::admininfo()->image}}" width="190">
                              </div>
                              <div class="card-body">
                                 <div class="card-block">
                                    <form action="{{ route('check-admin')  }}" method="POST">
                                       @csrf

                                       <h2 class="white">{{trans('labels.login')}}</h2>
                                       <div class="form-group">
                                          <div class="col-md-12">
                                             <input type="email" class="form-control" name="email" id="email" placeholder="{{trans('labels.enter_email')}}" required>
                                             @error('email')<span class="text-danger text-left" id="email_error">{{ $message }}</span>@enderror

                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <div class="col-md-12">
                                             <input type="password" class="form-control" name="password" id="password" placeholder="{{trans('labels.enter_password')}}" required>
                                             @error('password')<span class="text-danger text-left" id="AuthPasswordError">{{ $message }}</span>@enderror
 
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <div class="col-md-12">
                                             <input type="submit" value="{{trans('labels.login')}}" class="btn btn-success w-100">
                                          </div>
                                       </div>
                                    </form>
                                    @if (env('Environment') == 'sandbox')
                                    <table class="table table-bordered">
                                       <tbody>
                                          <tr>
                                             <td class="white">Admin<br>admin@gmail.com</td>
                                             <td class="white">123456</td>
                                             <td><button class="btn btn-info" onclick="AdminFill()">{{trans('labels.copy')}}</button></td>
                                          </tr>
                                          <tr>
                                             <td class="white">Vendor<br>vendor@yopmail.com</td>
                                             <td class="white">123456</td>
                                             <td><button class="btn btn-info" onclick="VendorFill()">{{trans('labels.copy')}}</button></td>
                                          </tr>
                                       </tbody>
                                    </table>
                                    @endif


                                 </div>
                              </div>
                              <div class="card-footer">
                                 <div class="float-left"><a href="{{ URL::to('/admin/forgot-password') }}" class="white">{{trans('labels.recover_password')}}</a></div>
                                 <div class="float-right"><a href="{{ URL::to('/admin/register') }}" class="white">{{trans('labels.new_user')}}</a></div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </section>
               <!--Login Page Ends-->
            </div>
         </div>
      </div>
   </div>
</body>

<script src="{{ asset('storage/app/public/admin-assets/js/jquery-3.6.0.js')}}"></script>
<script src="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.js')}}" type="text/javascript"></script>
<script>
   @if(Session::has('success'))
   toastr.options = {
         "closeButton": true,
         "progressBar": true

      },
      toastr.success("{{ session('success') }}");
   @endif


   @if(Session::has('error'))
   toastr.options = {
         "closeButton": true,
         "progressBar": true,
         "timeOut": 10000

      },
      toastr.error("{{ session('error') }}");
   @endif


   function AdminFill() {
      $('#email').val('admin@gmail.com');
      $('#password').val('123456');
   }
   function VendorFill() {
      $('#email').val('vendor@yopmail.com');
      $('#password').val('123456');
   }
</script>

</html>