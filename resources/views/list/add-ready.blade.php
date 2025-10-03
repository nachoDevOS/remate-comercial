@extends('voyager::master')

@section('page_title', 'Viendo Registros')

@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="voyager-list"></i> Lista de Registros
                </h1>
                @if ($day->status == 2)
                    <a type="button" data-toggle="modal" data-target="#modal_create" class="btn btn-success btn-add-new">
                        <i class="voyager-plus"></i> <span>Crear</span>
                    </a>
                @endif
                @if ($day->status == 2)
                    <a type="button" data-toggle="modal" href="{{route('day.show', $day->id)}}"  class="btn btn-dark" style="border: 0px; margin-top: 2px"><i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver Tablero</span></a>
                @endif
                <a type="button" data-toggle="modal" href="{{route('day.index')}}" class="btn btn-warning btn-add-new">
                    <i class="voyager-list"></i> <span>Volver a la lista</span>
                </a>
                @if ($day->status == 1)
                    <a type="button" target="_blank" href="{{route('day.prinf', $day->id)}}"  class="btn btn-primary" style="margin-top: 2px"><i class="fa fa-print"></i> <span class="hidden-xs hidden-sm">Imprimir</span></a>
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
                                        <th class="text-center">Categoria.</th>
                                        <th class="text-center">Lote.</th>
                                        <th class="text-center">Cantidad.</th>
                                        @if($day->type == 1)
                                        <th class="text-center">Precio Unitario.</th>
                                        @else
                                        <th class="text-center">Precio por Kg.</th>
                                        <th class="text-center">Peso Total.</th>
                                        @endif
                                        <th class="text-center">Subtotal.</th>
                                        <th class="text-center">Comisión.</th>
                                        <th class="text-center">Total.</th>
                                        <th class="text-center">Estado.</th>
                                        @if ($day->status == 2)
                                        <th class="text-center">Acciones.</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ready as $item)
                                        <tr class="text-center">
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->category->name }}</td>
                                            <td>{{ $item->lote }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->price }}</td>
                                            @if($day->type == 1)
                                            <td>{{ $item->quantity * $item->price }}</td>
                                            @else
                                            <td>{{ $item->total_weight }}</td>
                                            <td>{{ number_format($item->price * $item->total_weight, 2, '.', '') }}</td>
                                            @endif
                                            <td>{{ $item->price_add ?? 0 }}</td>
                                            @if($day->type == 1)
                                            <td>{{ ($item->quantity * $item->price) + $item->price_add }}</td>
                                            @else
                                            <td>{{ number_format(($item->price * $item->total_weight) + $item->price_add, 2, '.', '') }}</td>
                                            @endif
                                            <td class="text-right">
                                                @if ($item->defending == 1)
                                                    <label class="label label-warning">Defensa</label>
                                                @endif
                                                @if ($item->status == 1)
                                                    <label class="label label-success">Activo</label>
                                                @else
                                                    <label class="label label-success">Finalizado</label>
                                                @endif
                                            </td>
                                            @if ($day->status == 2)
                                            <td class="actions text-right dt-not-orderable sorting_disabled text-center">
                                                <a type="button" data-toggle="modal" data-target="#modal_edit" data-id="{{ $item->id}}" data-name="{{$item->category->id}}" data-lote="{{$item->lote}}" data-cant="{{$item->quantity}}" data-precio="{{$item->price}}" data-peso="{{ $item->total_weight }}" class="btn btn-primary"><i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Editar</span></a>
                                                <a type="button" data-toggle="modal" data-target="#modal_delete" data-id="{{ $item->id}}" class="btn btn-danger"><i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Borrar</span></a>                                    
                                            </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center">No hay registros</td>
                                        </tr>
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
                {!! Form::open(['route' => 'ready.store', 'method' => 'POST']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-list"></i> Registrar</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="day_id" id="id" value="{{$id}}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Categoria:</b></span>
                            </div>
                            <select name="category_id" class="form-control" id="select-category_id" required>
                                <option value="">Seleccione la categoría</option>
                                @foreach($category as $data)
                                    <option value="{{$data->id}}">{{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>       
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Lote:</b></span>
                            </div>
                            <input type="lote" class="form-control" name="lote" onkeypress='return validaNumericos(event)' maxlength="5"> 
                        </div>
                        <div class="col-md-6">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Cantidad:</b></span>
                            </div>
                            <input type="quantity" class="form-control" name="quantity" onkeypress='return validaNumericos(event)' maxlength="5"> 
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>@if($day->type == 2) Precio por Kg.: @else Precio unitario: @endif</b></span>
                            </div>
                            <input type="price" class="form-control" name="price" value="0" onkeypress='return validaNumericos(event)' maxlength="5"> 
                        </div>
                        @if($day->type == 2)
                        <div class="col-md-6">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Peso total:</b></span>
                            </div>
                            <input type="number" class="form-control" name="total_weight" value="0"> 
                        </div>
                        @endif
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
                {!! Form::open(['route' => 'ready.update','class' => 'was-validated'])!!}
                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" name="day_id"  value="{{$id}}">
                    <input type="hidden" name="ready_id"  id="id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Categoria:</b></span>
                            </div>
                            <select name="category_id" id="select-checkcategoria_id" class="form-control" required>
                                <option value="">Seleccione la categoría</option>
                                @foreach($category as $data)
                                    <option value="{{$data->id}}">{{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>       
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Lote:</b></span>
                            </div>
                            <input type="lote" class="form-control" name="lote" id="lote" onkeypress='return validaNumericos(event)' maxlength="5"> 
                        </div>
                        <div class="col-md-6">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Cantidad:</b></span>
                            </div>
                            <input type="quantity" class="form-control" name="quantity" id="cantidad" onkeypress='return validaNumericos(event)' maxlength="5"> 
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>@if($day->type == 2) Precio por Kg.: @else Precio unitario: @endif</b></span>
                            </div>
                            <input type="price" class="form-control" name="price" id="precio" onkeypress='return validaNumericos(event)' maxlength="5"> 
                        </div>
                        @if($day->type == 2)
                        <div class="col-md-6">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Peso total:</b></span>
                            </div>
                            <input type="number" class="form-control" name="total_weight" id="peso"> 
                        </div>
                        @endif
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
                {!! Form::open(['route' => 'ready.delete', 'method' => 'DELETE']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> Desea eliminar el siguiente registro?</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="day_id" value="{{$id}}">

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
@stop

@section('css')
    <style>
        .select2{
            width: 100% !important;
            border: 1px solid #e4eaec !important;
        }
    </style>
@stop

@section('javascript')
    <script src="{{ url('js/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#select-category_id").select2({dropdownParent: $('#modal_create')});
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

            $('#select-checkcategoria_id').select2();

          

            $('#select-checkcategoria_id').on('change', function_divs);
        });

        $('#modal_edit').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) //captura valor del data-empresa=""

                var id = button.data('id')
                var category = button.data('name')
                var lote = button.data('lote')
                var precio = button.data('precio')
                var cantidad = button.data('cant')
                var peso = button.data('peso')

                var modal = $(this)
                modal.find('.modal-body #select-checkcategoria_id').val(category).trigger('change')
                modal.find('.modal-body #id').val(id)
                modal.find('.modal-body #lote').val(lote)
                modal.find('.modal-body #precio').val(precio)
                modal.find('.modal-body #cantidad').val(cantidad)
                modal.find('.modal-body #peso').val(peso)
        });
        $('#modal_delete').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) //captura valor del data-empresa=""

                var id = button.data('id')
                
                var modal = $(this)
                modal.find('.modal-body #id').val(id)
                
        });

    </script>
    <script type="text/javascript">
        function validaNumericos(event) {
            if(event.charCode >= 48 && event.charCode <= 57){
              return true;
            }
            return false;        
        }
      </script>
@stop
