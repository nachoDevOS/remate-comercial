<div class="table-responsive">
    <table id="detalles" class="dataTables table table-hover">
        <thead>
            <tr>
                <th class="text-center">Categoria.</th>
                <th class="text-center">Lote.</th>
                <th class="text-center">Cantidad.</th>
                @if($day->type == 1)
                <th class="text-center">Precio Unitario.</th>
                @elseif($day->type == 2)
                <th class="text-center">Peso Total.</th>
                <th class="text-center">Peso Promedio.</th>
                <th class="text-center">Precio por Kg.</th>
                @else
                <th class="text-center">Cuota.</th>
                @endif
                <th style="width: 50px"></th>
            </tr>
        </thead>
        <tbody>
            @php
                $i =0;
            @endphp
            @forelse($day->readys as $item)
                <tr class="text-center">
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->lote }}</td>
                    <td>{{ $item->quantity }}</td>
                    @if($day->type == 1 || $day->type == 3)
                    <td>{{ $item->price }}</td>
                    @else
                    <td>{{ intval($item->total_weight) }}</td>
                    <td>{{ intval($item->total_weight / $item->quantity) }}</td>
                    @endif
                    <td>
                        @if($day->type == 2 && $next->ready_id == $item->id)
                        <a type="button" href="#" data-toggle="modal" data-target="#modal-editar-peso" class="btn btn-info btn-sm btn-editar-peso" data-id="{{ $item->id }}" title="Editar peso total">
                            <i class="voyager-edit"></i>
                        </a>
                        @endif
                        <a type="button" href="{{route('day.manual',['id'=>$item->id,'i'=>$i, 'day'=>$id] )}}" class="btn btn-success btn-sm" title="Siguiente">
                            <i class="voyager-forward"></i>
                        </a>
                    </td>
                </tr>
                @php
                    $i++;
                @endphp
            @empty
                <tr>
                    <td colspan="5" class="text-center">No hay registros</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function(){
        $('.btn-editar-peso').click(function(){
            $('#form-editar-peso input[name="id"]').val($(this).data('id'));
        });
    });
</script>
