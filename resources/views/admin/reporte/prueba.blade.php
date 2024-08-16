<!DOCTYPE html>
<html>
<head>
    <style>
        hr {
            border-top: 0.5px solid rgb(182, 180, 180);
        }






    </style>
       <center><img src="{{storage_path('images/MUVHOF.jpg')}}" class="imagencentro" width="950" height="140"></center>

    </head>
<body>
<center><h3>REPORTE DE ASISTENCIAS</h3></center>
<table style="font-size: 13px;" CELLPADDING=5 CELLSPACING=0 width="750">


        <tr>
        <td style="border: 1px solid; width:50px">
            <b>N°</b>
        </td>
        <td style="border: 1px solid; width:250px">
            <b>NOMBRE Y APELLIDO</b>
        </td>
        <td style="border: 1px solid; width:300px">
            <b>SOLUCION</b>
        </td>

        <td style="border: 1px solid; width:100px">
            <b>FECHA</b>
        </td>

        <td style="border: 1px solid; width:50px">
            <b>ESTADO</b>
        </td>

        </tr>
        @foreach ($dhelps as $item)
        <tr>
            <td style="border: 1px solid"> {{ $item->help_id}}</td>
            <td style="border: 1px solid"> {{ $item->user->first_name}} {{ $item->user->last_name}}</td>
            <td style="border: 1px solid"> {{ $item->solution }}</td>
            <td style="border: 1px solid"> {{ $item->updated_at }}</td>
            <td style="border: 1px solid"> {{ $item->state->name }}</td>
        </tr>
        @endforeach
</table>
<p style="font-weight: bold;">TOTAL DE ASISTENCIAS: {{$contar}}</p>
</body>
</html>
