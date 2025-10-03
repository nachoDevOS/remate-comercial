@extends('voyager::master')

@section('page_title', 'Viendo Registros')

@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="voyager-calendar"></i> Dias de Remates
                </h1>
                {{-- @if($count == 0) --}}
                @if(true)
                    <a type="button" data-toggle="modal" data-target="#modal_create" class="btn btn-success btn-add-new">
                        <i class="voyager-plus"></i> <span>Crear</span>
                    </a>
                @endif
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        
                        <div class="table-responsive">
                            <table id="dataTable" class="dataTable table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Id&deg;</th>
                                        <th class="text-center">Tipo.</th>
                                        <th class="text-center">Fecha.</th>
                                        <th class="text-center">Descripcion.</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($day as $item)
                                    @php
                                        
                                    @endphp
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            @if($item->type == 1)
                                            Al bulto
                                            @elseif($item->type == 2)
                                            Al peso
                                            @else
                                            De elite
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>
                                            @if ($item->status == 2)
                                                <label class="label label-danger">Pendiente</label>
                                            @endif

                                            @if ($item->status == 1)
                                                <label class="label label-success">Finalizado</label>
                                            @endif
                                        </td>

                                        <td class="actions text-right dt-not-orderable sorting_disabled">
                                            @if ($item->status == 2)
                                                <a type="button" data-toggle="modal" href="{{route('day.show', $item->id)}}"  class="btn btn-dark"><i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver Tablero</span></a>
                                            @endif
                                            <a type="button" data-toggle="modal" href="{{route('ready.show', $item->id)}}"  class="btn btn-success"><i class="voyager-check"></i> <span class="hidden-xs hidden-sm">{{$item->status == 2? 'Agregar':'Ver Detalle'}}</span></a>
                                            @if ($item->status == 1)
                                                <a type="button" target="_blank" href="{{route('day.prinf', $item->id)}}"  class="btn btn-primary"><i class="fa fa-print"></i> <span class="hidden-xs hidden-sm">Imprimir</span></a>
                                            @endif
                                            @if ($item->status == 2)
                                                <a type="button" data-toggle="modal" data-target="#modal_finalize" data-id="{{ $item->id}}"  class="btn btn-dark"><i class="voyager-dollar"></i> <span class="hidden-xs hidden-sm">Finalizar</span></a>
                                                <a type="button" data-toggle="modal" data-target="#modal_edit" data-id="{{ $item->id}}" data-date="{{$item->date}}" data-title="{{$item->title}}" class="btn btn-primary"><i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Editar</span></a>
                                            @endif 
                                                <a type="button" data-toggle="modal" data-target="#modal_delete" data-id="{{ $item->id}}" class="btn btn-danger"><i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Borrar</span></a>                                                
                                        </td>
                                    </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-success fade" tabindex="-1" id="modal_create" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['route' => 'day.store', 'method' => 'POST']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-calendar"></i> Registrar</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Tipo:</b></span>
                            </div>
                            <select name="type" id="select-type" class="form-control">
                                <option value="1" data-percentage="3">Al bulto</option>
                                <option value="2" data-percentage="3">Al peso</option>
                                <option value="3" data-percentage="6">De elite</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Fecha:</b></span>
                            </div>
                            <input type="date" class="form-control" name="date" required>
                        </div>
                    </div>    
                    
                    <div class="row">   
                        <div class="col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Titulo:</b></span>
                            </div>
                            <textarea id="title" class="form-control" name="title" rows="3"></textarea>
                        </div>                
                    </div>

                    <div class="row">   
                        <div class="col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Comisión %:</b></span>
                            </div>
                            <input type="number" class="form-control" id="input-percentage" min="0" step="0.1" max="100" name="percentage" value="3" required>
                        </div>                
                    </div>

                    <div class="row" id="div-fee" style="display: none">   
                        <div class="col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Cantidad de cuotas:</b></span>
                            </div>
                            <input type="number" class="form-control" id="input-fee" min="0" step="1" max="100" name="fee">
                        </div>                
                    </div>

                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-dark" value="Sí, Crear">
                </div>
                {!! Form::close()!!} 
            </div>
        </div>
    </div>

    {{-- modal para editar --}}
    <div class="modal modal-info fade" tabindex="-1" id="modal_edit" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-edit"></i> Editar</h4>
                </div>
                {!! Form::open(['route' => 'day.edit','class' => 'was-validated'])!!}
                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Fecha:</b></span>
                            </div>
                            <input type="date" class="form-control" name="date" required>
                        </div>
                    </div>    
                    
                    <div class="row">   
                        <div class="col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Titulo:</b></span>
                            </div>
                            <textarea id="title" class="form-control" name="title" cols="77" rows="3"></textarea>
                        </div>                
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer justify-content-between">
                    <button type="button text-left" class="btn btn-default" data-dismiss="modal" data-toggle="tooltip" title="Volver">Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm" title="Registrar..">
                        Actualizar
                    </button>
                </div>
                {!! Form::close()!!} 
                
            </div>
        </div>
    </div>

    {{-- modal para eliminar --}}
    <div class="modal modal-danger fade" tabindex="-1" id="modal_delete" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['route' => 'day.delete', 'method' => 'DELETE']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> Desea eliminar el siguiente registro?</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">

                    <div class="text-center" style="text-transform:uppercase">
                        <i class="voyager-trash" style="color: red; font-size: 5em;"></i>
                        <br>
                        
                        <p><b>Desea eliminar el siguiente registro?</b></p>
                    </div>
                    {{-- <div class="row">   
                        <div class="col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Observacion:</b></span>
                            </div>
                            <textarea id="observacion" class="form-control" name="observacion" cols="77" rows="3"></textarea>
                        </div>                
                    </div> --}}
                </div>                
                <div class="modal-footer">
                    
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="Sí, eliminar">
                    
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
                </div>
                {!! Form::close()!!} 
            </div>
        </div>
    </div>

    <div class="modal modal-primary fade" tabindex="-1" id="modal_finalize" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['route' => 'day.finalize', 'method' => 'POST']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-check"></i> Finalizar</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">

                    <div class="text-center" style="text-transform:uppercase">
                        <i class="voyager-check" style="color: green; font-size: 5em;"></i>
                        <br>
                        <p><b>Desea finalizar el tablero....!</b></p>
                    </div>
                    {{-- <div class="row">    
                        <div class="col-md-12">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><b>Fecha Salida:</b></span>
                            </div>
                            <input type="date" step="any" class="form-control" id="fentregar" name="fentregar" required>
                        </div>                                                                         
                    </div>
                    <div class="row">   
                        <div class="col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Observacion:</b></span>
                            </div>
                            <textarea id="observacion" class="form-control" name="observacion" cols="77" rows="3"></textarea>
                        </div>                
                    </div> --}}
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-dark" value="Sí, finalizar">
                </div>
                {!! Form::close()!!} 
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('javascript')
    <script src="{{ url('js/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.dataTable').DataTable({
                        language: {
                            // "order": [[ 0, "desc" ]],
                            sProcessing: "Procesando...",
                            sLengthMenu: "Mostrar _MENU_ registros",
                            sZeroRecords: "No se encontraron resultados",
                            sEmptyTable: "Ningún dato disponible en esta tabla",
                            sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
                            sSearch: "Buscar:",
                            sInfoThousands: ",",
                            sLoadingRecords: "Cargando...",
                            oPaginate: {
                                sFirst: "Primero",
                                sLast: "Último",
                                sNext: "Siguiente",
                                sPrevious: "Anterior"
                            },
                            oAria: {
                                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                            },
                            buttons: {
                                copy: "Copiar",
                                colvis: "Visibilidad"
                            }
                        },
                        order: [[ 0, 'desc' ]],
                    })
        });

        $('#select-type').change(function(){
            let percentage = $('#select-type option:selected').data('percentage');
            $('#input-percentage').val(percentage);

            if($('#select-type option:selected').val() == 1 || $('#select-type option:selected').val() == 2){
                $('#div-fee').fadeOut();
                $('#input-fee').val('');
            }else{
                $('#div-fee').fadeIn();
                $('#input-fee').val(14);
            }
        });

        $('#modal_edit').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) //captura valor del data-empresa=""

                var id = button.data('id')
                var date = button.data('date')
                var title = button.data('title')
                var modal = $(this)
                modal.find('.modal-body #id').val(id)
                modal.find('.modal-body #date').val(date)
                modal.find('.modal-body #title').val(title)
                
        });
        $('#modal_delete').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) //captura valor del data-empresa=""

                var id = button.data('id')
                var modal = $(this)
                modal.find('.modal-body #id').val(id)
                
        });
        $('#modal_finalize').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) //captura valor del data-empresa=""

                var id = button.data('id')
                var modal = $(this)
                modal.find('.modal-body #id').val(id)
                
        });

    </script>
@stop
