@extends('blades/index')

@section('title', ' Usuarios')

@section('h1', lang('otp_activation_heading'))

@section('h2', lang('index_subheading'))

@section('content')

<div class="box box-primary">

<div class="box-header with-border">
  <h3 class="box-title">Editar</h3>
</div>
<!-- /.box-header -->
<!-- form start -->

<div id="infoMessage">{{ $message }}</div>
<div class="box-body">

<div id="otp">

    <img src="{{$google_chart_url}}" alt="QR Code"><br>
    <p>
        {{lang('otp_activation_scan')}}<br>
        {{lang('otp_activation_scan_alt')}} <span id="otp_secret_key">{{$otp_secret_key}}</span>
    </p>
    <p>
        {{lang('otp_activation_backup_codes')}}
    <div id="backup_codes">
        @foreach ($backup_codes as $backup_code)
            {{$backup_code . '<br>'}}
        @endforeach
    </div>
</p>
</div>
</div>
</div>
@endsection