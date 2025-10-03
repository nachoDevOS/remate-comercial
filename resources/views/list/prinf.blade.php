<html mmoznomarginboxes="" mozdisallowselectionprint="">
    <head>
        <title>Comprobante Ingreso</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/print.style.css') }}" media="print">
        <style type="text/css">
            html
            {
                background-color: #FFFFFF; 
                margin: 0px;  /* this affects the margin on the html before sending to printer */
            }
            body {
                font-size: 14px !important;
            }
            table {
                font-size: 10px !important;
            }
            .centrar{
                width: 240mm;
                margin-left: auto;
                margin-right: auto;
                /*border: 1px solid #777;*/
                display: grid;
                padding: 10mm !important;
                -webkit-box-shadow: inset 2px 2px 46px 1px rgba(209,209,209,1);
                -moz-box-shadow: inset 2px 2px 46px 1px rgba(209,209,209,1);
                box-shadow: inset 2px 2px 46px 1px rgba(209,209,209,1);
            }
            /*For each sections*/
            .box-section {
                margin-top: 1mm;
                border: 1px solid #000;
                padding: 8px;
            }
            .alltables {
                width: 100%;
            }
            .alltables td{
                padding: 2px;
            }
            .box-margin {
                border: 1px solid #000;
                width: 120px;
            }
            .caja {
                border: 1px solid #000;
            }
        </style>
    </head>
    <body>
        <div class="noImprimir text-center">
            <button onclick="javascript:window.print()" class="btn btn-link">
                IMPRIMIR
            </button>
        </div>
        <div class="centrar">
            {{-- ENCABEZADO --}}
            <table class="alltables text-center">
                <tbody>
                    <tr>
                        <td><img src="{{ asset('images/icon.png') }}" width="100px"></td>
                        <td>
                            <table class="alltables">
                                <tr>
                                    <td  class="text-center">
                                        <h4 style="font-size: 25px;"><strong>REPORTE</strong></h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="width: 80%">
                                        <span style="font-size: 20px;">
                                            <strong>{{$day->title}} - {{\Carbon\Carbon::parse($day->date)->format('d/m/Y')}}</strong>
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                </tbody>
            </table>
            <br>
           
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th class="text-center">Categoria</th>
                        <th class="text-center">Lote</th>
                        <th class="text-center">Cantidad</th>
                        @if($day->type == 1)
                        <th class="text-center">Precio Unitario</th>
                        @elseif($day->type == 2)
                        <th class="text-center">Precio Kg.</th>
                        <th class="text-center">Peso Total</th>
                        @else
                        <th class="text-center">Cuota</th>
                        @endif
                        <th class="text-center">Subtotal</th>
                        <th class="text-center">Comisión</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i=1;
                        $quantity=0;
                        $price=0;
                        $peso=0;
                        $subtotal=0;
                        $price_add=0;
                        $total=0;
                    ?>
                    @foreach($readys as $item)       
                    <tr @if($item->defending) style="background-color: #FEF9E7" @endif>
                        <td>{{$i}}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->lote }}</td>
                        <td style="text-align: right">{{ $item->quantity }}</td>
                        <td style="text-align: right">{{ $item->price }}</td>
                        @if($day->type == 1)
                        <td style="text-align: right">{{ $item->quantity * $item->price }}</td>
                        @elseif($day->type == 2)
                        <td style="text-align: right">{{ $item->total_weight }}</td>
                        <td style="text-align: right">{{ number_format($item->price * $item->total_weight, 2, '.', '') }}</td>
                        @else
                        <td style="text-align: right">{{ $item->quantity * $item->price * $day->fee }}</td>
                        @endif
                        <td style="text-align: right">{{ $item->price_add ?? 0 }}</td>
                        @if($day->type == 1)
                        <td style="text-align: right">{{ ($item->quantity * $item->price) + $item->price_add }}</td>
                        @elseif($day->type == 2)
                        <td style="text-align: right">{{ number_format(($item->price * $item->total_weight) + $item->price_add, 2, '.', '') }}</td>
                        @else
                        <td style="text-align: right">{{ ($item->quantity * $item->price * $day->fee) + $item->price_add }}</td>
                        @endif
                    </tr>   
                    <?php
                        $i++;
                        $quantity+=$item->quantity;
                        $price+=$item->price;
                        $peso+=$item->total_weight;
                        // $subtotal+=$day->type == 1 ? $item->quantity * $item->price : $item->price * $item->total_weight;
                        $price_add+=$item->price_add;
                        // $total+=$day->type == 1 ? ($item->quantity * $item->price) + $item->price_add : ($item->price * $item->total_weight) + $item->price_add;

                        if($day->type == 1){
                            $subtotal += $item->quantity * $item->price;
                            $total += ($item->quantity * $item->price) + $item->price_add;
                        }elseif($day->type == 1){
                            $subtotal += $item->price * $item->total_weight;
                            $total += ($item->price * $item->total_weight) + $item->price_add;
                        }else{
                            $subtotal += $item->quantity * $item->price * $day->fee;
                            $total += ($item->quantity * $item->price * $day->fee) + $item->price_add;
                        }
                    ?>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right"><b>TOTAL</b></td>
                        <td style="text-align: right"><b>{{ $quantity }}</b></td>
                        <td style="text-align: right"><b>{{ $price }}</b></td>
                        @if($day->type == 1  || $day->type == 3)
                        <td style="text-align: right"><b>{{ $subtotal }}</b></td>
                        @else
                        <td style="text-align: right"><b>{{ $peso }}</b></td>
                        <td style="text-align: right"><b>{{ $subtotal }}</b></td>
                        @endif
                        <td style="text-align: right"><b>{{ $price_add }}</b></td>
                        <td style="text-align: right"><b>{{ $total }}</b></td>
                    </tr>
                </tfoot>
            </table>




            {{-- end section body --}}
            <!-- <div class="text-center">
                <p style="font-size: 13px;"><b>NOTA:</b> Este reporte muestra a detalle los productos egresados de fecha .</p>
            </div> -->
            <div>
                <table style="width: 100%;">
                    <tr>
                        <td class="text-left" style="font-size: 10px;"></td>
                        <td class="text-right" style="font-size: 10px;"></td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>