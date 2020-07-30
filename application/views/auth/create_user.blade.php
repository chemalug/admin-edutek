@php
  defined('BASEPATH') OR exit('No direct script access allowed')
@endphp
 
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>IDi | @yield('title', ' Crear Usuario')</title>
  
  @includeIf('blades/_meta')

  @include('blades/_css')
  
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <?php echo lang('create_user_heading'); ?>
  </div>
  @if (isset($message))
    <div class="alert alert-warning alert-dismissible" id="infoMessage">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Alerta!</h4>
        {{ $message }}
    </div>
  @endif
  

  <div class="register-box-body">
    <p class="login-box-msg">{{ lang('create_user_subheading') }}</p>

    <?php echo form_open("auth/create_user"); ?>
      <div class="form-group has-feedback">
        <?php echo form_input(array_merge($first_name, array("class" => "form-control", "placeholder" => lang('create_user_fname_label')))); ?>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <?php echo form_input(array_merge($last_name, array("class" => "form-control", "placeholder" => lang('create_user_lname_label')))); ?>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <?php echo form_input(array_merge($email, array("class" => "form-control", "placeholder" => lang('create_user_email_label')))); ?>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>

    @if (app('ion_auth')->is_admin())
      <div class="form-group has-feedback">
        <select name="set_centro" id="set_centro" class="form-control">
          <option value="" disabled selected hidden>Seleccionar Centro:</option>
          @foreach($all_centros as $item)
              <option value="{{$item->id}}" id="{{$item->id}}" >{{$item->nombre}}</option>
          @endforeach
        </select>
      </div>

    @else
    <input type="hidden" name="set_centro" value="{{ $user->centro_id }}" />
    @endif
      <div class="row">
        <div class="col-xs-6">
          <div class="checkbox icheck">
            <p>Al crear el usuario, se estará enviando por email el password</p>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat"><?php echo lang('create_user_submit_btn'); ?></button>
        </div>
        <div class="row row-no-gutters">
        </div>
        <div class="col-xs-6">
          <button type="button" name="submit" class="btn btn-danger btn-block btn-flat"><?php echo lang('cancel_btn'); ?></button>
        </div>
        <!-- /.col -->
      </div>
    <?php echo form_close(); ?>


    <!--<a href="/auth/login" class="text-center">Ya poseo una cuenta</a>-->
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 3 -->
<script src="/assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="/assets/plugins/iCheck/icheck.min.js"></script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/59f2c7554854b82732ff7f3d/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>