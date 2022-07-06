<center><h2>SOLICITUD DE ASISTENCIA </h2></center>


<table>
        <tbody>
            <br>
            <tr>
                <td><strong> NUMERO:</strong> {{ $help->id }}</td>
                <td colspan="2"><strong>NOMBRE:</strong> {{ $help->name }}</td>
                <td><strong>CEDULA:</strong> {{ $help->ci }}</td>



            </tr>
            <br>
            <tr>
                <td colspan="3"><strong>DEPENDENCIA:</strong> {{ $help->dependency }}</td>

                 <td><strong>ESTADO:</strong> {{ $help->statuses->state->name}} </td>
            </tr>
            <br>
            <tr>
                <td colspan="3"><strong>DESCRIPCION SOLICITUD:</strong> {{ $help->problem}} </td>
                <td><strong>TELEFONO:</strong> {{ $help->fone}}</td>
            </tr>

            <br>

        </tbody>
    </table>
<br>
<center><h2>DETALLE DE ASISTENCIA </h2></center>
<<br>
<table>
    <tbody>
        <br>
        <tr>
        <td>
            TECNICO
        </td>
        <td>
            ACCION REALIZADA
        </td>
        <td>
            FECHA ASISTENCIA
        </td>
        <td>
            CATEGORIA
        </td>
        <td>
            PATRIMONIO
        </td>

        </tr>
        @foreach ($detalle as $item)
        @if ($item->user->id !== 1)


        <tr>
            <td> {{ $item->user->full_name}}</td>
            <td> {{ $item->solution }}</td>
            <td> {{ $item->date }}</td>
            <td> {{ $item->category->name }}</td>
            <td> {{ $item->patrimony }}</td>
        </tr>
        @else

        @endif
        @endforeach
        <br>

        </tbody>
</table>
<br><br><br>



