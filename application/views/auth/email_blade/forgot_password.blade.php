@extends('auth/email_blade/index')

@section('img_logo', base_url().'assets/dist/img/mail_logo.png' )

@section('img_header', base_url().'assets/dist/img/mail_banner.png')

@section('button_href',  base_url().'auth/reset_password/'.$forgotten_password_code)

@section('button_txt', 'Reiniciar contraseña')

@section('mail_title', 'Recuperacion de Contraseña')

@section('mail_txt', 'Usted ha solicitado recuperar la contraseña de la Plataforma IDi, si es correcto favor de seguir el enlace del boton de abajo para crear una nueva.')

@section('mail_txt2', 'si usted no ha solicitado esta informacion, favor de ignorar este mensaje. <br> si el boton de arriba no funciona copiar y pegar en el navegador el siguiente texto:<br>'.base_url().'auth/reset_password/'.$forgotten_password_code)

@section('body')

    <!-- 1 Column Text + Button : BEGIN -->
    <tr>
        <td bgcolor="#ffffff">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td style="padding: 40px; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555;">
                        <h1 style="margin: 0 0 10px 0; font-family: sans-serif; font-size: 24px; line-height: 125%; color: #333333; font-weight: normal;">@yield('mail_title')</h1>
                        <p style="margin: 0;">@yield('mail_txt')</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0 40px; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555;">
                        <!-- Button : BEGIN -->
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" style="margin: auto;">
                            <tr>
                                <td style="border-radius: 3px; background: #222222; text-align: center;" class="button-td">
                                    <a href="@yield('button_href')" style="background: #222222; border: 15px solid #222222; font-family: sans-serif; font-size: 13px; line-height: 110%; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
                                        <span style="color:#ffffff;" class="button-link">&nbsp;&nbsp;&nbsp;&nbsp;@yield('button_txt')&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <!-- Button : END -->
                    </td>
                </tr>
                <tr>
                    <td style="padding: 40px; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555;">
                        <h2 style="margin: 0 0 10px 0; font-family: sans-serif; font-size: 18px; line-height: 125%; color: #333333; font-weight: bold;">@yield('mail_title2')</h2>
                        <p style="margin: 0;">@yield('mail_txt2')</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- 1 Column Text + Button : END -->
 @endsection