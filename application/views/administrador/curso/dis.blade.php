@extends('blades/index')

@section('title', ' Editar curso')

@section('content')
<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body text-white">
                <h4 class="card-title text-center">Editar curso</h4>
                <h6 class="card-title text-center">Edutek E-learning</h6>
                {{ form_open_multipart('curso/editaction') }}
                    <form class="form p-t-20">
                        <div class="form-group">
                          <input type="text" class="form-control" name="id" id="id" hidden value="{{ $datos->id }}" >
                                <br>
                            <label for="exampleInputuname">Nombre del curso</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="ti-agenda"></i>
                                    </span>
                                </div>
                            <input type="text" class="form-control" style="color:white;" name="nombre" id="nombre" placeholder="Nombre" style="color:white;" value="{{ $datos->nombre }}" disabled >
                            </div>
                        </div>
                          <div class="form-group">
                            <br>
                            <label for="exampleInputuname">Descripción del curso</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="ti-receipt"></i>
                                    </span>
                                </div>
                                <textarea class="form-control" style="color:white;" name="descripcion" id="descripcion" placeholder="Descripción" maxlength="1500" disabled>{{ $datos->descripcion }}</textarea>
                            </div>
                            <div class="form-group">
                                    <br>

                                    <div class="form-group">

                                    <label for="exampleInputuname">Categoria:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="ti-receipt"></i>
                                            </span>
                                        </div>
                                        @php
                                            $sql = "SELECT * FROM categorias;";
                                            $resultado = $this->db->query($sql) or die;
                                        @endphp

                                        <select class="form-control" style="color:white;" name="categoria_id" id="categoria_id" disabled>
                                            @php
                                           foreach ($resultado->result_array() as $row)
                                                {
                                                        echo "<option value='"  . $row['id']     . "'> " . $row['nombre'] . "</option>";

                                                }
                                            @endphp
                                        </select>

                                    </div>
                                    <br/>
                                <label for="exampleInputuname">Objetivos</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="ti-receipt"></i>
                                        </span>
                                    </div>
                                    <textarea class="form-control" style="color:white;" name="objetivos" id="objetivos" placeholder="Objetivos" maxlength="1500" disabled>{{ $datos->objetivos }}</textarea>
                                </div>

                                <div class="form-group">
                                        <br>
                                    <label for="exampleInputuname">Duración en horas</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="ti-receipt"></i>
                                            </span>
                                        </div>
                                        <input type="number" class="form-control" style="color:white;" name="duracion" id="duracion" placeholder="" value="20" min="10" max="120" value="{{ $datos->duracion }}" disabled>
                                    </div>
                                    <div class="form-group">
                                            <br>
                                        <label for="exampleInputuname">Requisitos</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="ti-receipt"></i>
                                                </span>
                                            </div>
                                            <textarea class="form-control" style="color:white;" name="requisitos" id="requisitos" placeholder="Requisitos" maxlength="1500" disabled>{{ $datos->requisitos }}</textarea>
                                        </div>
                                        <div class="form-group">
                                                <br>
                                            <label for="exampleInputuname">Dirigido a: </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <i class="ti-receipt"></i>
                                                    </span>
                                                </div>
                                                <textarea class="form-control" style="color:white;" name="dirigido_a" id="dirigido_a" placeholder="Dirigido a ..." maxlength="1500" disabled>{{ $datos->dirigido }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                    <br>
                                                <label for="exampleInputuname">Código del plan de formación</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">
                                                            <i class="ti-receipt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control" style="color:white;" name="codigo_plan" id="codigo_plan" placeholder="Código del plan de formación" value="{{ $datos->codigo_plan_formacion }}" disabled>
                                                </div>


                        </div>


                        <a href="{{ base_url() }}evento/listar" class="btn btn-success waves-effect waves-light m-r-10">Regresar</a>
                        
                    </form>
                {{ form_close() }}
            </div>
            </div>
        </div>
    </div>

@endsection
