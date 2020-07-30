<div class="page-wrapper" style='background: url(" {{ base_url() }}public_images/fondo1.jpg") no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover;-o-background-size: cover;background-size: cover;'>
    @include('blades/_message')    
    <!--<div class="container-fluid" style='background: url("https://thumbs.dreamstime.com/z/repetitive-violet-pattern-27005060.jpg") fixed;  width: 100%; '>-->
    <div class="container-fluid">
        <section>
            @yield('content')
        </section>
    </div>
</div>