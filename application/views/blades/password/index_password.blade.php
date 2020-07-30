@php
  defined('BASEPATH') OR exit('No direct script access allowed')
@endphp
 
@include('blades/password/_init')
  
@includeIf('blades/_meta')

@section('css_content')
	@include('blades/_css')
@show
</head>

<body class="fix-header fix-sidebar card-no-border">
  <div class="main-wrapper">
    @include('blades/_header')
    @include('blades/password/navigation')
    @include('blades/est/content')
    @include('blades/footer')
  </div>

@section('js_content')
  
@show

</body>
</html>