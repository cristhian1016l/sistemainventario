<?php setlocale(LC_ALL,'es_PE'); ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}">     -->
    <title>Reporte de Productos</title>
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
    </style>
</head>
<body>
    <!-- <img src="{{ asset('dist/img/logo.png') }}" alt="Logo" width="50" height="50" align="right"> -->        
    <div>
        <table>
            <tr>
                <td>
                    <span style="font-family: 'Inter', sans-serif; font-size: 8pt; font-weight: bold; text-align: center">
                    <?php 
                        echo date('Y-m-d');
                    ?>
                    </span>
                </td>
                <td>
                    <span style="font-family: 'Inter', sans-serif; font-size: 8pt; font-weight: bold; text-align: center">  
                    <?php 
                        echo date('H:i:s a');
                        // 3:26 p.m.
                    ?>
                    </p>
                </td>
            </tr>
        </table>
        <p style="margin-top: -8px; font-family: 'Inter', sans-serif; font-size: 20px; font-weight: bold; text-align: center;">LISTADO DE ACTIVOS REGISTRADOS</p>        
        <br>                 
        <hr style="border: 0 none; border-top: 2px dashed #332f32; background: none; height: 0; margin-top: -5px;">
        <table id="table">
            <thead>
                <tr>
                    <td style="text-align: center">
                        <span style="font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: bold; text-align: center;">N°</span>
                    </td>
                    <td>
                        <span style="font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: bold; text-align: center;">Producto</span>
                    </td>
                    <td>
                        <span style="font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: bold; text-align: center;">Categoría</span>
                    </td>
                    <td style="text-align: center">
                        <span style="font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: bold; text-align: center;">Precio</span>
                    </td>
                    <td style="text-align: center">
                        <span style="font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: bold; text-align: center;">Stock</span>
                    </td>
                </tr>
            </thead>
            <tbody> 
                <?php $i=1;
                ?>
                @foreach($products as $product)
                    <tr>         
                        <td style="text-align: center">
                            <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold">{{ $i }}</span>
                        </td>                        
                        <td>
                            <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold">{{ $product->product_name }}</span>
                        </td>                        
                        <td>
                            <span style="text-align: center; font-family: 'Inter', sans-serif; font-size: 9px; text-align: center">{{ $product->category }}</span>
                        </td>
                        <td style="text-align: center">
                            <span style="text-align: center; font-family: 'Inter', sans-serif; font-size: 9px; text-align: center">S/. {{ $product->price }}</span>
                        </td>
                        <td style="text-align: center">
                            <span style="text-align: center; font-family: 'Inter', sans-serif; font-size: 9px; text-align: center">{{ $product->stock }}</span>
                        </td>
                    </tr>   
                    <?php $i++ ?>
                @endforeach
            </tbody>                            
        </table>                
    </div>
</body>