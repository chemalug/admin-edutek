@extends('blades/index')

@section('title', ' Usuarios')

@section('h1', lang('index_heading'))

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
{{ form_open(uri_string()) }}

<p>
    {{ lang('edit_user_fname_label', 'first_name') }} <br />
    {{ form_input($first_name) }}
</p>

<p>
    {{ lang('edit_user_lname_label', 'last_name') }} <br />
    {{ form_input($last_name) }}
</p>
<p>
    {{ lang('edit_user_email_label', 'email') }} <br />
    {{ form_input($email) }}
</p>
@if ($this->ion_auth->is_admin() )

    <h3>{{ lang('edit_user_groups_heading') }}</h3>
    <div class="form-group">
    @foreach ($groups as $group)
        <div class="checkbox">
        <label class="checkbox">
            @php
            $gID = $group['id'];
            $checked = null;
            $item = null;
            foreach ($currentGroups as $grp) {
                if ($gID == $grp->id) {
                    $checked = ' checked="checked"';
                    break;
                }
            }
            @endphp
            <input type="checkbox" name="groups[]" value="{{ $group['id'] }}"{{ $checked }}>
            {{ htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8') }}
        </label>
        </div>
    @endforeach
    </div>
    
@endif

{{ form_hidden('id', $user->id) }}
{{ form_hidden($csrf) }}

<p>{{ form_submit('submit', lang('edit_user_submit_btn')) }}</p>

{{ form_close() }}


</div>
</div>
@endsection

