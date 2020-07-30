@php
defined('BASEPATH') OR exit('No direct script access allowed')
@endphp

@include('blades/_init')

@includeIf('blades/_meta')

@section('css_content')
@include('blades/_css')
@show
</head>
<!--oncontextmenu="return false" onkeydown="return false"-->
<body class="fix-header fix-sidebar card-no-border" >
  <div class="main-wrapper">
    @include('blades/_header')
    @include('blades/navigation')
    @include('blades/content')
    @include('blades/footer')
  </div>

  @includeIf('blades/_js')

</body>

</html>