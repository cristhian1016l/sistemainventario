<?php setlocale(LC_ALL,'es_PE'); ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}">     -->
    <title>Solicitud</title>
    <style>
        body {
            margin: -30px;
            font-family: "Nunito", sans-serif;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #212529;
            text-align: left;
            background-color: #fff;
        }        
        @font-face {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 600;
            src: local('Inter Bold'), local('Inter-Bold'), url(https://fonts.googleapis.com/css2?family=Inter:wght@600&display=swap) format('truetype');
        }   
        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            /* width: 100%; */
            /* margin: 0 auto; */
            width: 100%;  /* Este será el ancho que tendrá tu columna */
            /* background-color: #CCCCCC;  Aquí pon el color del fondo que quieras para este lateral */
            float:left; /* Aquí determinas de lado quieres quede esta "columna" */
        }        

        #table td, #table th {
            
            padding: 0.5px;
        }

        
        #table th {
            font-family: 'Inter', sans-serif;
            font-size: 12px; 
            text-align: center; 
            padding: 0.5px;                        
            /* background-color: #000;
            color: white; */
        }
        #table tbody tr:nth-child(even) {
            background: #d4d4d4;
        }
        .td{
            font-family: 'Inter', sans-serif; 
            font-size: 10px; 
            text-align: center; 
            padding: 0.5px;
            border: 1px solid #d2d2d2;
        }

        #data {
            width: 30%;  /* Este será el ancho que tendrá tu columna */
            /* background-color: #CCCCCC;  Aquí pon el color del fondo que quieras para este lateral */
            float:right; /* Aquí determinas de lado quieres quede esta "columna" */
        }        

        #right {
            width: 50%;  /* Este será el ancho que tendrá tu columna */
            /* background-color: #CCCCCC;  Aquí pon el color del fondo que quieras para este lateral */
            float:right; /* Aquí determinas de lado quieres quede esta "columna" */
        }

        #left {
            width: 50%;
            float: left;
            background-color: #FFFFFF;
            /* border:#000000 1px solid; ponemos un donde para que se vea bonito */
        }

        /* table */
        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            /* width: 100%; */
            /* margin: 0 auto; */
            width: 100%;  /* Este será el ancho que tendrá tu columna */
            /* background-color: #CCCCCC;  Aquí pon el color del fondo que quieras para este lateral */
            float:left; /* Aquí determinas de lado quieres quede esta "columna" */            
        }        
        #table td, #table th {
            
            padding: 0.5px;
        }
        
        #table th {
            font-family: 'Inter', sans-serif;
            font-size: 12px; 
            text-align: center; 
            padding: 0.5px;                        
            /* background-color: #000;
            color: white; */
        }
        #table tbody tr:nth-child(even) {
            background: #d4d4d4;
        }
        #watermark {
            position: fixed;
            top: 20%;
            width: 110%;
            text-align: center;
            opacity: .1;
            /* transform: rotate(10deg); */
            transform-origin: 50% 50%;
            /* z-index: -1000; */
        }
    </style>
</head>
<body>
    <div id="watermark">
        @switch($header[0]->company)
            @case('PRODUCCIONES 89 S.A.C')
                <img src="{{URL::asset('/images/logoproducciones89.png')}}" alt="Producciones 89" height="500" width="500">
                @break
            @case('UNSIHUAY RECORDS S.A.C.')
                <img src="{{URL::asset('/images/logounishuayrecords.png')}}" alt="Unsihuay Records" height="500" width="500">
                @break
            @case('PONCE PRODUCCIONES S.A.C')
                <img src="{{URL::asset('/images/logoponceproducciones.png')}}" alt="Ponce Producciones" height="500" width="500">
                @break
            @default
                <img alt="Ponce Producciones" height="500" width="500">
        @endswitch        
    </div>
    <div>
    <table style="margin-top: 60px">
        <tr>
            <td>
                <span style="margin-left: 75px; font-family: monospace; font-size: 12px; sans-serif; font-weight: bold; text-align: center">
                <?php 
                    echo date('d-m-y h:i A');
                ?>
                </span>
            </td>                
        </tr>
    </table>
        <table style="margin-left: 75px; margin-top: 50px; font-family: monospace; font-size: 15px">
            <tr>
                <td style="width: 220px: text-align: bottom">
                    <b>COD. REQ.: </b>{{ $header[0]->cod_request }}
                </td>
                <td style="text-align: top">
                    <b>FECHA DE ENT.: </b>{{ \Carbon\Carbon::parse($header[0]->since_date)->format('d-m-Y') }}
                </td>
                <td style="padding-left: 70px" rowspan="2">
                    @switch($header[0]->company)
                        @case('PRODUCCIONES 89 S.A.C')
                            <img src="{{URL::asset('/images/logoproducciones89.png')}}" alt="Producciones 89" height="100" width="100">
                            @break
                        @case('UNSIHUAY RECORDS S.A.C.')                            
                            <img src="{{URL::asset('/images/logounishuayrecords.png')}}" alt="Ponce Producciones" height="100" width="100">
                            @break
                        @case('PONCE PRODUCCIONES S.A.C')
                            <img src="{{URL::asset('/images/logoponceproducciones.png')}}" alt="Ponce Producciones" height="100" width="100">
                            @break
                        @default
                            <img alt="Ponce Producciones" height="100" width="100">
                    @endswitch                                     
                </td>                
            </tr>

            <tr>
                <td style="width: 220px">
                    <b>¿ENTREGÓ?: </b>
                    <?php

                        if($header[0]->was_entered == 0){
                            echo 'NO ENTREGADO';
                        }else{
                            echo \Carbon\Carbon::parse($header[0]->deadline)->format('d-m-Y');
                        }

                    ?>                    
                </td>
                <td >
                    <b>FECHA DE DEV.: </b>{{ \Carbon\Carbon::parse($header[0]->to_date)->format('d-m-Y') }}
                </td>                
            </tr>            
        </table>
    </div>
    
    <div>        
        <p style="margin-top: 50px; font-family: monospace; font-size: 20px; font-weight: bold; text-align: center; text-decoration: underline">SOLICITUD DE MEMORIAS</p>
        <!-- <br> -->
        <p style="font-family: monospace; margin-left: 75px; margin-right: 75px; text-align: justify">
            POR EL PRESENTE DOCUMENTO, YO <b>{{ $header[0]->name }}</b>, DE 
            NACIONALIDAD PERUANA, IDENTIFICADO CON DOCUMENTO NACIONAL DE IDENTIDAD 
            NÚMERO <b>{{ $header[0]->document }}</b>; EN MI CALIDAD DE TRABAJADOR 
            CON CARGO DE PRODUCTOR DESIGNADO DE LA SOCIEDAD DENOMINADA
            <b>“{{ $header[0]->company }}”.</b> DECLARO BAJO JURAMENTO
            HABER RECIBIDO EL BIEN QUE A CONTINUACIÓN SE DETALLA.
        </p>    
        <p style="font-family: monospace; font-weight: bold; text-decoration: underline; margin-left: 75px; margin-top: 50px">DESCRIPCIÓN DE LOS BIENES:</p>    
        <ul style="font-family: monospace; font-weight: bold; text-decoration: none; margin-left: 75px; margin-right: 75px; text-align: justify">
            @foreach($details as $detail)
            <li>{{ $detail->amount }} | {{ $detail->product_name }} - {{ $detail->name }} - {{ $detail->color }}</li>
            @endforeach
        </ul>
        <p style="font-family: monospace; margin-left: 75px; margin-right: 75px; margin-top: 50px; text-align: justify">            
            EL TRABAJADOR(A) DECLARA QUE TODOS LOS BIENES PATRIMONIALES DETALLADOS 
            SE ENCUENTRAN EN BUEN ESTADO. EL TRABAJADOR ES RESPONSABLE DIRECTO DE 
            LA EXISTENCIA, PERMANENCIA, CONSERVACION Y BUEN USO DE CADA UNO DE LOS 
            BIENES DESCRITOS Y MOSTRADOS. POR LO QUE SE RECOMIENDA TOMAR LAS 
            PROVIDENCIAS DEL CASO PARA EVITAR PERDIDA, SUSTRACCIONES, DETERIORO, 
            ETC. QUE LUEGO PUEDE SER CONSIDERADO COMO DESCUIDO Y NEGLIGECENCIA Y 
            DE SER ASI SE PROCEDERA AL DESCUENTO POR EL VALOR ESTIMADO. 
        </p>    

        <p style="font-family: monospace; margin-left: 50px; margin-right: 50px; margin-top: 120px; text-align: center">
            <b>{{ $header[0]->name }}</b><br>
            <b>DNI: {{ $header[0]->document }}</b><br>
            <b>EL TRABAJADOR(A)</b>
        </p>
    </div>

</body>