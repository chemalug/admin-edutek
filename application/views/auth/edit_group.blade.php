@extends('blades/index')

@section('title', ' Usuarios')

@section('h1', lang('edit_group_heading'))

@section('h2', lang('edit_group_subheading'))

@section('content')

<div class="box box-primary">

<div class="box-header with-border">
  <h3 class="box-title">Editar</h3>
</div>
<!-- /.box-header -->
<!-- form start -->

<div id="infoMessage">{{ $message }}</div>
<div class="box-body">


<div id="infoMessage">{{ $message}}</div>

{{ form_open(current_url())}}

<p>
    {{ lang('edit_group_name_label', 'group_name')}} <br />
    {{ form_input($group_name)}}
</p>

<p>
    {{ lang('edit_group_desc_label', 'description')}} <br />
    {{ form_input($group_description)}}
</p>

<p>{{ form_submit('submit', lang('edit_group_submit_btn'))}}</p>

{{ form_close()}}
</div>
</div>
@endsection