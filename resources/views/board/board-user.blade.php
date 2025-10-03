@extends('voyager::master')

@section('page_title', 'Viendo Registros')

@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <h1 class="page-title">
                    <i class="voyager-list"></i> Lista de Registros
                </h1>  
                <a type="button" data-toggle="modal" href="{{route('day.index')}}" class="btn btn-warning btn-add-new">
                        <i class="voyager-list"></i> <span>Volver a la lista</span>
                </a>   
                <a type="button" data-toggle="modal" target="_blank" href="{{route('day.tv', $id)}}" class="btn btn-dark btn-add-new">
                    <i class="voyager-tv"></i> <span>Proyectar</span>
                </a>           
            </div>
            <div class="col-sm-6 col-md-6 text-right" style="margin-top: 30px">
                <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#modal-next" title="Siguiente">Siguiente <i class="voyager-forward"></i></button>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <span class="input-group-text texto" style="font-size:200%"><b> Categoria:<br> {{$next->category}}</b></span> 
            </div>
            <div class="col-sm-6 col-md-3">
                <span class="input-group-text texto" style="font-size:200%"><b> Lote:<br> {{$next->lote}}</b></span> 
            </div>
            <div class="col-sm-6 col-md-3">
                <span class="input-group-text texto" style="font-size:200%"><b> Cantidad:<br> {{$next->quantity}}</b></span> 
            </div>
            <div class="col-sm-6 col-md-3">
                {!! Form::open(['route' => 'day.board-update','class' => 'was-validated', 'id' => 'form-board-updte'])!!}
                {{ csrf_field() }}
                <span class="input-group-text texto" style="font-size:200%"><b> Precio ({{ $day->type == 1 || $day->type == 3 ? '$us' : 'Bs.' }}):<br></b></span>
                <div class="input-group">
                    <input type="text" class="form-control" style="font-size: 25px;" name="price" id="input-price" value="{{$next->price}}">
                    <div class="input-group-btn">
                        @if($day->type == 2)
                        <button class="btn btn-danger btn-change" data-value="-0.05" title="-5 centavos" type="button" title="Actualizar" style="margin-top: 0px">
                            <b style="padding: 0px 5px"> -5 </b>
                        </button>
                        <button class="btn btn-success btn-change" data-value="0.05" title="+5 centavos" type="button" title="Actualizar" style="margin-top: 0px">
                            <b style="padding: 0px 5px"> +5 </b>
                        </button>
                        @endif
                        <button class="btn btn-primary" type="submit" title="Actualizar" style="margin-top: 0px">
                            <i class="voyager-refresh"></i>
                        </button>
                    </div>
                </div>
                <input type="hidden" name="commission" value="{{ $day->percentage }}">
                <input type="hidden" name="id" value="{{$next->ready_id}}">
                <input type="hidden" name="day_id" value="{{$id}}">
                {!! Form::close()!!}
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
                        <div id="ready-list"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal para pasar al siguiente --}}
    {!! Form::open(['route' => 'day.board-next','class' => 'was-validated'])!!}
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{$next->ready_id}}">
        <input type="hidden" name="day_id" value="{{$id}}">
        <div class="modal modal-success fade" tabindex="-1" id="modal-next" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-forward"></i> Desea pasar al siguiente?</h4>
                    </div>            
                    <div class="modal-footer text-right">
                        <label class="checkbox-inline"><input type="checkbox" name="defending" value="1">Es una defensa</label> <br><br>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-success" value="Sí, aceptar">
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close()!!}

    <form action="{{ route('ready.update.total_weight') }}" id="form-editar-peso" class="form-submit" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $next->ready_id }}">
        <div class="modal modal-success fade" tabindex="-1" id="modal-editar-peso" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-edit"></i> Registra peso total</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="total_weight"></label>
                            <input type="number" class="form-control" name="total_weight" min="0" required>
                        </div>
                    </div>
                    <div class="modal-footer text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-success btn-submit" value="Actualizar">
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('css')
    <style>
        .select2{
            width: 100% !important;
        }

        #detalles {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        #detalles td, #detalles th {
        border: 1px solid #ddd;
        padding: 8px;
        }

        #detalles tr:nth-child(even){background-color: #f2f2f2;}

        #detalles tr:hover {background-color: #ddd;}

        #detalles th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }

        .form-control .select2{
            border-radius: 5px 5px 5px 5px;
            color: #000000;
            border-color: rgb(63, 63, 63);
        }
    </style>
@stop

@section('javascript')
    <script src="{{ url('js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.4.0/socket.io.js" integrity="sha512-nYuHvSAhY5lFZ4ixSViOwsEKFvlxHMU2NHts1ILuJgOS6ptUmAGt/0i5czIgMOahKZ6JN84YFDA+mCdky7dD8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const socket = io("localhost:3031");
    </script>
    <script>
        $(document).ready(function() {
            // $(".select2").select2({theme: "classic"});
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
                        order: [[ 0, 'asc' ]],
                    })

            $('#select-checkcategoria_id').select2();

            // $('#select-checkcategoria_id').on('change', function_divs);

            getReady();

            @if($next->total_weight == 0 || $next->total_weight == '')
                // $('#modal-editar-peso').modal('show');
            @endif

            $('#form-board-updte').submit(function(e){
                e.preventDefault();
                $.post($(this).attr('action'), $(this).serialize(), function(res){
                    getReady();
                    socket.emit('pull', 1);
                    $("#input-price").select();
                });
            });

            $('#form-editar-peso').submit(function(e){
                e.preventDefault();
                $.post($(this).attr('action'), $(this).serialize(), function(res){
                    getReady();
                    socket.emit('pull', 1);
                    if(res.success){
                        $('#modal-editar-peso').modal('hide');
                        toastr.success('Peso actualizado');
                    }else{
                        toastr.error('Ocurrió un error');
                    }
                });
            });

            $('.btn-change').click(function(){
                let value = parseFloat($(this).data('value'));
                let price = parseFloat($('#input-price').val());
                $('#input-price').val(parseFloat(price + value).toFixed(2));
                $('#form-board-updte').trigger('submit');
            });
        });

        $("#input-price").on("click", function () {
            $(this).select();
        });


        $('#modal_edit').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) //captura valor del data-empresa=""

                var id = button.data('id')
                var category = button.data('name')
                var lote = button.data('lote')
                var precio = button.data('precio')
                var cantidad = button.data('cant')
                // alert(category)

                var modal = $(this)
                modal.find('.modal-body #select-checkcategoria_id').val(category).trigger('change')
                modal.find('.modal-body #id').val(id)
                modal.find('.modal-body #lote').val(lote)
                modal.find('.modal-body #precio').val(precio)
                modal.find('.modal-body #cantidad').val(cantidad)
                
        });
        $('#modal_delete').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) //captura valor del data-empresa=""

                var id = button.data('id')
                
                var modal = $(this)
                modal.find('.modal-body #id').val(id)
                
        });

        function getReady(){
            let id = "{{ $id }}";
            $.get("{{ url('admin/day') }}/"+id+"/ready", function(res){
                $('#ready-list').html(res);
                socket.emit('pull', 1);
            });
        }
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
