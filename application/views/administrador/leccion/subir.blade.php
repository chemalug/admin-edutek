@extends('blades/index')

@section('title', ' Listado de Instructores')

@section('encabezado','Agregar contenido')

@section('content')
 {{ form_open_multipart( 'leccion/subiendo ')}}
<div class="container-fluid text-white">
  <div class="wrapper">
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title text-center">
              Subir archivo
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="custom-file">
                  <input class="custom-file-input" type="text" name="id" value="{{ $id }}" hidden>
                  
                  <input  class="custom-file-input"type="file" name="uploadedFile" />
                  <label class="custom-file-label form-control" for="imagen" aria-describedby="imagen">Seleccione un archivo</label>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="input-group">
                <div class="custom-file">
                  <input class="btn bg-megna" type="submit" name="uploadBtn" value="Upload" style="color:white" />
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    
  </div>
</div>
    <div>
    </div>
 
  {{ form_close() }}

@endsection