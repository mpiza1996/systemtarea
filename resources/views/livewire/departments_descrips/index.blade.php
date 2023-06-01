@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h4 style="display:inline;">Departamento - Tarea (Listado)</h4>
            <div class="btn-group float-right">
                <div class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createDataModal">
                    <i class="fa fa-plus"></i>  Agregar
                </div>
            </div>
          </div>
        </div>
    </div>
</section>
@livewire('departments_descrips')
@endsection