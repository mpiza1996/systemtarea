@extends('layouts.app')

@section('content')


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h4 style="display:inline;">Gestión de Tareas</h4>
            <div class="btn-group float-right">
              <a  href="{{ route('tasks.create') }}"
                  class="btn btn-sm btn-primary">
                  <i class="fas fa-plus"></i> Agregar
              </a>
            </div>
          </div>
        </div>
    </div>
</section>


<!-- TABLA DE CONTENIDO -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-body">        
              @if (count($tasks)) 
                <table id="tableuser" class="table table-bordered table-striped table-sm" style="font-size:12px">
                    <thead>
                        <tr>
                            <th width="10px" style="text-align: center">ID</th>
                            <th width="500px" style="text-align: center">Asunto</th>
                            <th width="120px" style="text-align: center">Fecha de Solicitud</th>
                            <th width="200px" style="text-align: center">Departamento</th>
                            <th width="500px" style="text-align: center">Usuario Solicitante</th>
                            <th width="350px" style="text-align: center">Estado</th>
                            <th style="text-align: center">&nbsp;</th>
                        </tr>
                    </thead>

                    <tbody style="text-align: center">
                        @foreach($tasks as $prodc)
                        <tr>
                            <td>{{ $prodc->id }}</td>
                            <td>{{ $prodc->asunto }}</td>
                            <td>{{ $prodc->fecha_entrega }}</td>
                            <td>{{ $prodc->namedt }}</td>
                            <td>{{ $prodc->ApellidoSoli }} {{ $prodc->NombreSoli }}</td>   
                            <td>{{$prodc->estado }}</td> 


                            <td width="5px">
                              <div class="text-center">
                                <div class="btn-group">

                                  @if()

                                  @ifelse()

                                  
                                    <a href="{{ route('tasks.edit', $prodc->id) }}"
                                    class="btn-sm btn btn-outline-primary">
                                        Consultar
                                    </a>

                                </div>
                              </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

              @else
                  <div class="text-center text-muted">No existen registros</div> 
              @endif   

              </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function confirmation(ev) {
  ev.preventDefault();
  var urlToRedirect = ev.currentTarget.getAttribute('href'); 
  console.log(urlToRedirect); 
  swal({
    title: "¿Estás seguro?",
    text: "Desactivar este registro.",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      swal(
        "Registro Desactivado Correctamente!", {
        icon: "success",
      });
      window.location.href = urlToRedirect;
          } else {
      swal("Cancelando Acción", {
        icon: "warning",
      });
    }
  });
  }
</script>


@endsection

