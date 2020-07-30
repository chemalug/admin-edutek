@extends('blades/index')

@section('title', ' Principal')

@section('h1', ' Oppsss...')

@section('content')
    @if (isset($message))
        <div class="alert alert-warning alert-dismissible" id="infoMessage">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> Alerta!</h4>
            {{$message}}
        </div>
    @endif
@endsection