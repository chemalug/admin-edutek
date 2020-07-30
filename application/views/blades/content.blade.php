
        <div class="page-wrapper">
            @include('blades/_message')
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="m-b-0 m-t-0">@yield('encabezado')</h3>
                    </div>
                  
                </div>
                
                <div class="row">
                    <div class="col-12">
                        
                                  <section>
                                    @yield('content')
                                  </section>
                                  <!-- /.content -->
                        
                    </div>
                </div>
            </div>
        </div>