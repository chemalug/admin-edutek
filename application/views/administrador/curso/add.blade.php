@extends('blades/index')

@section('title', ' Agregar curso')

@section('content')
<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Agregar curso</h4>
                <h6 class="card-title text-center">Edutek E-learning</h6>
                {{ form_open_multipart('curso/addaction') }}
                    <form class="form p-t-20">
                        <div class="form-group">
                            <label for="exampleInputuname">Nombre del curso</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="ti-agenda"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control"  name="nombre" id="nombre" placeholder="Nombre" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputuname">Descripción del curso</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="ti-receipt"></i>
                                    </span>
                                </div>
                                <textarea class="form-control"  name="descripcion" id="descripcion" placeholder="Descripción" maxlength="1500"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputuname">Grados:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="ti-receipt"></i>
                                    </span>
                                </div>
                                <select class="form-control"  name="categoria_id" id="categoria_id">
                                    <option selected disabled hidden>Seleccionar grado</option>
                                    <option value="1">Primero</option>
                                    <option value="1">Segundo</option>
                                    <option value="1">Tercero</option>
                                    <option value="1">Cuarto</option>
                                    <option value="1">Quinto</option>
                                    <option value="1">Sexto</option>
                                </select>    
                            </div>
                        </div>
                            <div class="form-group">
                                <label for="exampleInputuname">Objetivos</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="ti-receipt"></i>
                                        </span>
                                    </div>
                                    <textarea class="form-control"  name="objetivos" id="objetivos" placeholder="Objetivos" maxlength="1500"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputuname">Requisitos</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="ti-receipt"></i>
                                        </span>
                                    </div>
                                    <textarea class="form-control"  name="requisitos" id="requisitos" placeholder="Requisitos" maxlength="1500"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputuname">Dirigido a: </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="ti-receipt"></i>
                                        </span>
                                    </div>
                                    <textarea class="form-control"  name="dirigido_a" id="dirigido_a" placeholder="Dirigido a ..." maxlength="1500"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <td>Imagen del curso: ( 270 px X 90 px )</td> <td><div class="custom-file">
                                <input type="file" class="custom-file-input" id="archivo" name="archivo" accept="image/x-png,image/gif,image/jpeg" >
                                <label class="custom-file-label form-control" for="imagen" aria-describedby="imagen">Seleccione un archivo</label>
                                </td>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Guardar</button>
                        <button type="submit" class="btn btn-inverse waves-effect waves-light">Cancelar</button>
                    </form>
                {{ form_close() }}
            </div>
            </div>        
        </div>
    </div>

@endsection