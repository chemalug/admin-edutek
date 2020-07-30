@php
  defined('BASEPATH') OR exit('No direct script access allowed')
@endphp
 

@include('auth/email_blade/header')

@yield('body')

@include('auth/email_blade/footer')
