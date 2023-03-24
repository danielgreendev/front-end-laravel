@extends('admin.layout.main')

@section('page_title')
    {{trans('labels.payment_configuration')}} | {{trans('labels.update')}}
@endsection

@section('content')

<section id="basic-form-layouts">
    <div class="row">
        <div class="col-11 mt-3 mb-1">
            <h4 class="content-header">{{$pdata->payment_name}} {{trans('labels.payment_configuration')}} </h4>
        </div>
        <div class="col-1 mt-3 mb-1">
            <div class="dropdown">
                <button class="btn p-0" type="button" id="earningReportsTabsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsTabsId" style="">
                    <a class="dropdown-item" href="{{URL::to('/documents/index')}}" target="_blank">Configuração de Pagamento</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-md-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                </div>

                <div class="card-body">
                    <div class="px-3">
                        <form class="form" method="POST" action="{{URL::to('admin/payments/update-'.$pdata->_id)}}" enctype="multipart/form-data">
                            @csrf  
                            <div class="form-body">
                                <input type="hidden" name="id" id="id" value="{{$pdata->id}}" class="form-control">
                                
                                @if($pdata->payment_name != "Bank transfer")
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>{{trans('labels.public_key')}}</label>
                                        <input type="text" name="public_key" class="form-control" placeholder="{{trans('labels.enter_public_key')}}" value="{{$pdata->public_key}}">@error('public_key')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
                                    </div>
                                
                                    <div class="form-group col-md-6">
                                        <label>{{trans('labels.secret_key')}}</label>
                                        <input type="text" name="secret_key" class="form-control" placeholder="{{trans('labels.enter_secret_key')}}" value="{{$pdata->secret_key}}">@error('secret_key')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                @else
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>{{trans('labels.bank_name')}}</label>
                                        <input type="text" name="bank_name" class="form-control" placeholder="{{trans('labels.enter_bank_name')}}" value="{{$pdata->bank_name}}">@error('bank_name')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
                                    </div>
                                
                                    <div class="form-group col-md-6">
                                        <label>{{trans('labels.account_number')}}</label>
                                        <input type="text" name="account_number" class="form-control" placeholder="{{trans('labels.enter_account_number')}}" value="{{$pdata->account_number}}">@error('account_number')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>{{trans('labels.account_holder_name')}}</label>
                                        <input type="text" name="account_holder_name" class="form-control" placeholder="{{trans('labels.enter_account_holder_name')}}" value="{{$pdata->account_holder_name}}">@error('account_holder_name')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
                                    </div>
                                
                                    <div class="form-group col-md-6">
                                        <label>{{trans('labels.ifsc')}}</label>
                                        <input type="text" name="ifsc" class="form-control" placeholder="{{trans('labels.enter_ifsc')}}" value="{{$pdata->ifsc}}">@error('ifsc')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                </div>
                            </div>
                                    
                            <div class="form-actions center">
                                <a type="button" class="btn btn-raised btn-warning mr-1" href="{{ URL::to('/admin/payments')}}"><i class="ft-x btn_icon"></i> {{trans('labels.cancel')}}</a>
                                @if (env('Environment') == 'sandbox')
                                    <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"><i class="fa fa-check-square-o btn_icon"></i> {{trans('labels.update')}} </button>
                                @else
                                    <button type="submit" class="btn btn-raised btn-primary"><i class="fa fa-check-square-o btn_icon"></i> {{trans('labels.update')}} </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" type="text/css" href="{{asset('resources/views/admin/payments/index.css')}}">

@endsection