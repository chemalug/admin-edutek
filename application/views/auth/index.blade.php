@extends('blades/index')

@section('title', ' Usuarios')

@section('h1', lang('index_heading'))

@section('h2', lang('index_subheading'))

@section('content')

<!-- Default box -->
<div class="box">

  <div class="box-body">

  <table id="table_principal" class="table table-bordered table-striped">
    <thead>
      <tr>
          <th class="text-center hidden-xs">{{lang('index_fname_th')}}</th>
          <th class="text-center hidden-xs">{{lang('index_lname_th')}}</th>
          <th class="text-center">{{lang('index_email_th')}}</th>
          <th class="text-center">{{lang('index_action_th')}}</th>
          @if ($this->ion_auth->in_group('pedagogico'))
            <th class="text-center">Eventos</th>
          @endif
          
      </tr>
      </thead>
      <tbody>
      @foreach ($users as $user)
          <tr>
              <td class="text-center hidden-xs">{{htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8')}}</td>
              <td class="text-center hidden-xs">{{htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8')}}</td>
              <td class="text-center">{{htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8')}}</td>
              <td class="text-center">{{anchor("auth/edit_user/" . $user->id, 'Editar')}}
              @if ($this->ion_auth->in_group('admin'))
                | {{anchor("auth/delete_user/" . $user->id, 'Eliminar')}}
              @endif
              </td>
              @if ($this->ion_auth->in_group('pedagogico'))
                <td class="text-center">{{anchor("Evento/eventos/" . $user->id, 'Ver')}} </td>
              @endif
              
          </tr>
      @endforeach
    </tbody>
  </table>


  </div>
  <!-- /.box-body -->
  @if (app('ion_auth')->get_users_groups()->row()->id == 1)
    <div class="box-footer">
      <p>{{anchor('auth/create_user', lang('index_create_user_link'))}}</p>
    </div>    
  @endif
  
  <!-- /.box-footer-->
</div>
<!-- /.box -->
@endsection