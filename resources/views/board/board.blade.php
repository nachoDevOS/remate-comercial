
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Remate-Comercial</title>

    <!-- Favicon -->
    <?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>

        <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" type="image/png">

        <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">


    <!-- <link href="https://fonts.googleapis.com/css?family=Noto+Sans&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min-alt.css') }}" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Noto Sans', sans-serif;
            background: url("{{ url('storage/'.setting('auxiliares.fondo_tickets')) }}") no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            overflow-y:hidden;
            margin: 0;
            padding: 0;
        }
        .title{
            font-size: 50px;
            color: white;
            margin-top: 20px
        }
        .dark-mask{
            position: absolute;
            top:0px;
            bottom: 0px;
            left:0px;
            background-color:rgba(251, 0, 0, 0.5);
            width: 100%;
            height: 100 hv;
            z-index: 1;
        }
        .footer{
            position:fixed;
            bottom:0px;
            left:0px;
            width: 100%;
            background-color:rgba(0, 0, 0, 0.7);
            z-index: 10000;
        }
        .footer-content{
            margin: 10px 20px;
            color: white;
            font-size: 20px;
        }
        iframe{
            background-color: rgb(249, 249, 249)
        }

        body{
            font-family: "Archivo Black", sans-serif;
            font-weight: 900;
            font-style: normal;
        }
        #watermark{
            width: 100%;
            margin: 0;
            position: fixed;
            z-index: -1;
            top: 50%;
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            text-align: center;
            opacity: 0.1;
        }
        .footer-image{
            position:fixed;
            bottom: 50px;
            z-index:100000000;
            width:100%;
            height: 200px;
            background-image: url('/corral/public/images/footer.png');
            background-repeat: repeat-x;
        }
    </style>
</head>
<body>
    <div class="container-fluid">  
        <div class="row multimedia">
            <div id="watermark">
                <img src="{{ asset('images/icon.png') }}" alt="GADBENI" class="img-fluid center" width="50%">  
            </div>
            <div class="col-12 board" style="padding: 10px 50px">
                <div class="row" style="text-center">
                    <div class="col-12 padre mt-3 mb-3" id="categoria"></div>
                </div> 
                <div class="row">
                    <div class="col-4 leter mt-5" id="lote"></div>
                    <div class="col-4 leter mt-5" id="cantidad"></div>
                    <div class="col-4 leter mt-5" id="precio"></div>
                </div>
                @if($day->type == 1)
                <div class="row">
                    <div class="col-6 leter mt-5" id="percentage"></div>
                    <div class="col-6 leter mt-5" id="total"></div>
                </div>
                @elseif($day->type == 2)
                <div class="row">
                    <div class="col-4 leter mt-5" id="peso_total"></div>
                    <div class="col-4 leter mt-5" id="peso_promedio"></div>
                    <div class="col-4 leter mt-5" id="precio_promedio"></div>
                </div>
                <div class="row">
                    <div class="col-4 leter mt-5" id="monto_total"></div>
                    <!-- <div class="col-4 leter mt-5" id="monto_comision"></div> -->
                    <div class="col-4 leter mt-5" id="total"></div>
                    <div class="col-4 leter mt-5" id="total-dollar"></div>
                </div>
                @else
                <div class="row">
                    <div class="col-4 leter mt-5" id="percentage"></div>
                    <div class="col-8 leter mt-5" id="total_pagar"></div>
                </div>
                @endif
                <div class="row">
                    <div class="col-12 text-right mt-5">
                        <span style="font-size: 3em; color: #229954">Tasa de cambio {{ setting('tasa-de-cambio.dollar') }} Bs.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-image"></div>
        <div class="footer">
            <div class="footer-content">
                Remate Comercial - <span style="color: {{ env('APP_COLOR') }}">Trinidad-Beni-Bolivia</span>
            </div>
        </div>
    </div>
    

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <style>
        .card{
            background-color:rgba(186, 175, 175, 0.7);
            color:white;
            border: 10px solid rgba(0, 0, 0, 0.7);
        }
        .ticket-active{
            animation: colorchange 3s infinite; /* animation-name followed by duration in seconds*/
             /* you could also use milliseconds (ms) or something like 2.5s */
            -webkit-animation: colorchange 3s infinite; /* Chrome and Safari */
        }
        .col-4, .col-8 {
            padding: 5px !important;
            display: flex;
            justify-content: space-between;
            flex-direction: column
        }
        .multimedia{
            position: fixed;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100vh;
            z-index: 10000;
            background-color: rgb(0, 0, 0, .9)
        }
        .board{

        }
        .texto{
            text-align: center;
            border-radius: 10px 10px 10px 10px;
            color: #fff;
            border-color: rgb(63, 63, 63);
            background-color: rgb(225, 225, 225)
        }

        .padre {
            /* IMPORTANTE */
            text-align: center;
        }
        .lote {
            /* IMPORTANTE */
            text-align: center;
        }

        @keyframes colorchange
        {
            0%  {border: 10px solid rgba(0, 0, 0, 0.7);}
            20%   {border: 10px solid {{ env('APP_COLOR') }};}
            80%  {border: 10px solid rgba(0, 0, 0, 0.7);}
        }
        @-webkit-keyframes colorchange /* Safari and Chrome - necessary duplicate */
        {
            0%  {border: 10px solid rgba(0, 0, 0, 0.7);}
            25%   {border: 10px solid {{ env('APP_COLOR') }};}
            75%  {border: 10px solid rgba(0, 0, 0, 0.7);}
        }


        /* Slider */
        @keyframes slide {
            0% { transform: translateX(0); }
            50% { transform: translateX(0); }

            51% { transform: translateX(-100%); }
            100% { transform: translateX(-100%); }
        }

        .wrapper {
            width: 100%;
            position: relative;
            z-index: 10;
        }

        .slider {
            width: 100%;
            position: relative;
        }

        .slides {
            width: 100%;
            position: relative;
            display: flex;
            overflow: hidden;
            padding: 0px
        }

        .slide {
            width: 100%;
            flex-shrink: 0;
            animation-name: slide;
            animation-duration: 60s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
            list-style: none
        }

        .slides:hover .slide {
            animation-play-state: paused;
        }

        .slide img {
            width: 100%;
            vertical-align: top;
        }

        .slide a {
            width: 100%;
            display: inline-block;
            position: relative;
        }

        .slide:target {
            animation-name: none;
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            z-index: 50;
        }

        .slider-controler {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            text-align: center;
            /* padding: 5px; */
            background-color: rgba(0,0,0,0.5);
            z-index: 100;
        }

        .slider-controler li {
            margin: 0 0.5rem;
            display: inline-block;
            vertical-align: top;
        }

        .slider-controler a {
            display: inline-block;
            vertical-align: top;
            text-decoration: none;
            color: white;
            font-size: 1.5rem;
        }
        .input-group-text{
            background-color:transparent !important;
            border: 0.1em solid white;
            color: white
        }
    </style>

    <script>
        var day = @json($day);
        var dollar = "{{ setting('tasa-de-cambio.dollar') }}";
        $(document).ready(function(){
            getBoard();
        });

        function getBoard() {       
            $.get('{{route('board.board')}}', function(data){
                // alert();
                var fee = day.fee ?? 14;
                let type = "{{ $day->type }}";
                let moneda = "{{ $day->type == 1 || $day->type == 3 ? '$us' : 'Bs.' }}";
                var categoria ='<span class="texto" style="font-size:{{ setting("interface.font") *5 }}em;background-color: transparent" id="cant"><b>'+data[0].category+'</b></span>'
                var cantidad = '<b style="font-size:{{ setting("interface.font") *2.5 }}em; color: white">CANTIDAD:</b><br><span class="input-group-text texto" style="font-size:{{ setting("interface.font") *5 }}em"><b>'+data[0].quantity+'</b></span>'
                var lote = '<b style="font-size:{{ setting("interface.font") *2.5 }}em; color: white">LOTE:</b><span class="input-group-text texto" style="font-size:{{ setting("interface.font") *5 }}em"><b>'+data[0].lote+'</b></span>'
                var precio ='<b style="font-size:{{ setting("interface.font") *2.5 }}em; color: white">'+(day.type == 1 || day.type == 3 ? (day.type == 3 ? 'CUOTA (2+2+'+(fee-4)+'='+fee+')' : 'PRECIO') : 'PRECIO POR KG.')+' ('+moneda+'):</b><br><span class="input-group-text texto" style="font-size:{{ setting("interface.font") *5 }}em"><b>'+(day.type == 1 || day.type == 2 ? data[0].price : data[0].price)+'</b></span>'
                let comission = 0;
                if(type == 1){
                    comission = data[0].price * (day.percentage /100) * data[0].quantity;
                }else if(type == 2){
                    comission = data[0].total_weight * (day.percentage /100) * data[0].price;
                }else{
                    comission = data[0].price * fee * (day.percentage /100);
                }
                
                var percentage ='<b style="font-size:{{ setting("interface.font") *2.5 }}em; color: white">COMISION ('+moneda+'):</b><br><span class="input-group-text texto" style="font-size:{{ setting("interface.font") *5 }}em"><b>'+comission.toFixed(2)+'</b></span>'

                let peso_total = '<b style="font-size:{{ setting("interface.font") *2.5 }}em;color: white">PESO TOTAL (Kg.):</b><span class="input-group-text texto" style="font-size:{{ setting("interface.font") *5 }}em"><b>'+parseInt(data[0].total_weight)+'</b></span>';
                let peso_promedio = '<b style="font-size:{{ setting("interface.font") *2.5 }}em;color: white">PESO PROMEDIO (Kg.):</b><span class="input-group-text texto" style="font-size:{{ setting("interface.font") *5 }}em"><b>'+parseInt(data[0].total_weight / data[0].quantity)+'</b></span>';
                let precio_promedio_monto = (data[0].total_weight / data[0].quantity) * data[0].price;
                let precio_promedio = '<b style="font-size:{{ setting("interface.font") *2.5 }}em;color: white">PRECIO PROMEDIO ('+moneda+'):</b><span class="input-group-text texto" style="font-size:{{ setting("interface.font") *5 }}em"><b>'+parseFloat(precio_promedio_monto).toFixed(1)+'</b></span>';
                let total_pagar = '<b style="font-size:{{ setting("interface.font") *2.5 }}em;color: white">TOTAL A PAGAR ('+moneda+'):</b><span class="input-group-text texto" style="font-size:{{ setting("interface.font") *5 }}em"><b>'+parseFloat((data[0].price *data[0].quantity*fee) + comission).toFixed(2)+'</b></span>';

                var monto_total = '';
                var monto_comision = '';
                var total = '';
                var total_dollar = '';
                if(day.type == 1){
                    total = '<b style="font-size:{{ setting("interface.font") *2.5 }}em; color: white">TOTAL A PAGAR ('+moneda+'):</b><br><span class="input-group-text texto" style="font-size:{{ setting("interface.font") *5 }}em;color: white"><b>'+((data[0].price *data[0].quantity) + comission).toFixed(2)+'</b></span>';
                }else{
                    monto_total = '<b style="font-size:{{ setting("interface.font") *2.5 }}em; color: white">MONTO TOTAL ('+moneda+'):</b><br><span class="input-group-text texto" style="font-size:{{ setting("interface.font") *5 }}em;color: white"><b>'+(data[0].price *data[0].total_weight).toFixed(2)+'</b></span>';
                    monto_comision = '<b style="font-size:{{ setting("interface.font") *2.5 }}em; color: white">COMISION ('+moneda+'):</b><br><span class="input-group-text texto" style="font-size:{{ setting("interface.font") *5 }}em;color: white"><b>'+(comission).toFixed(2)+'</b></span>';
                    total = '<b style="font-size:{{ setting("interface.font") *2.5 }}em; color: white">TOTAL A PAGAR ('+moneda+'):</b><br><span class="input-group-text texto" style="font-size:{{ setting("interface.font") *5 }}em;color: white"><b>'+((data[0].price *data[0].total_weight) +comission).toFixed(2)+'</b></span>';
                    total_dollar = '<b style="font-size:{{ setting("interface.font") *2.5 }}em; color: white">PRECIO PROMEDIO ($us.):</b><br><div class="input-group-text texto" style="font-size:{{ setting("interface.font") *5 }}em; background-color: white !important; color: black !important"><b>'+parseFloat(precio_promedio_monto > 0 ? precio_promedio_monto / dollar : 0).toFixed(1)+'</b></div>';
                }

                // alert(1)

                $('#categoria').html(categoria);
                $('#precio').html(precio);
                $('#lote').html(lote);
                $('#cantidad').html(cantidad);
                $('#percentage').html(percentage);
                $('#peso_total').html(peso_total);
                $('#peso_promedio').html(peso_promedio);
                $('#precio_promedio').html(precio_promedio);
                $('#monto_total').html(monto_total);
                $('#monto_comision').html(monto_comision);
                $('#total').html(total);
                $('#total-dollar').html(total_dollar);
                $('#total_pagar').html(total_pagar);
            });
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.4.0/socket.io.js" integrity="sha512-nYuHvSAhY5lFZ4ixSViOwsEKFvlxHMU2NHts1ILuJgOS6ptUmAGt/0i5czIgMOahKZ6JN84YFDA+mCdky7dD8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const socket = io("rematecomercial-server.soluciondigital.dev");
        socket.on('get_pull', data => {
            getBoard();
        });
    </script>

</body>
</html>