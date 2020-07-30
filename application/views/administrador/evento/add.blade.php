@extends('blades/index')

@section('title', ' Agregar Evento')

@section('content')
<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-7">
        <div class="card text-white">
            <div class="card-body">
                <h2 class="card-title text-center text-megna">Agregar Eventos</h2>
                <h4 class="card-title text-center">Edutek E-learning</h4>
                {{ form_open('evento/addaction')}}
                    <form class="form p-t-20">
                        <div class="form-group">
                            <label for="exampleInputuname">Curso del evento</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <select name="curso_id" id="curso_id" class="form-control" style="color:white;">
                                    <option value="" disabled selected hidden>Seleccionar curso</option>
                                    @foreach ($cursos as $item)
                                        <option value="{{ $item->id }}" id="{{$item->id}}" >{{$item->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputuname">No de evento</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="ti-agenda"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" style="color:white;" name="no_evento" id="exampleInputuname" placeholder="xxxx-2019">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputuname">Fecha de inicio</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="date" class="form-control" style="color:white;" name="fecha_inicio" id="exampleInputuname" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputuname">Fecha de finalización</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="date" class="form-control" style="color:white;" name="fecha_final" id="exampleInputuname" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputuname">Asignar instructor</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <select name="instructor_id" id="instructor_id" class="form-control" style="color:white;">
                                    <option value="" disabled selected hidden>Seleccionar instructor</option>
                                    @foreach ($instructores as $item)
                                        <option value="{{ $item->id }}" id="{{$item->id}}" >{{$item->nombre_instructor}} {{$item->apellido_instructor}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputuname">No. de horas</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="number" class="form-control" style="color:white;" name="no_horas" id="no_horas" placeholder="# de horas" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <button type="submit" class="btn bg-megna waves-effect waves-light m-r-10" style="color:white">Guardar</button>
                                <button type="submit" class="btn btn-inverse waves-effect waves-light">Cancelar</button>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{ base_url() }}instructor/agregar" class="btn btn-inverse waves-effect waves-light">Instructor <i class="mdi mdi-account-plus"></i></a>
                            </div>
                        </div>
                        
                    </form>
                {{ form_close() }}
            </div>
            </div>        
        </div>
    </div>

@endsection