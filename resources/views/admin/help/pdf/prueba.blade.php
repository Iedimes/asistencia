<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Asistencia</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #222222;
            margin: 10px 15px;
        }

        .imagencentro {
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 15px;
        }

        h2.section-title {
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 15px;
            margin-bottom: 10px;
            color: #111111;
        }

        table.pdf-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #b0b0b0;
            margin-bottom: 15px;
        }

        table.pdf-table th {
            background-color: #f2f4f7;
            color: #111111;
            font-weight: bold;
            font-size: 10.5px;
            padding: 6px 8px;
            border: 1px solid #b0b0b0;
            text-align: left;
            text-transform: uppercase;
        }

        table.pdf-table td {
            padding: 6px 8px;
            font-size: 10.5px;
            border: 1px solid #c5c5c5;
            vertical-align: top;
            line-height: 1.4;
        }

        .problem-cell {
            padding: 8px !important;
            background-color: #ffffff;
        }

        .problem-text {
            text-align: left !important;
            font-size: 10.5px;
            color: #111111;
            line-height: 1.45;
            word-wrap: break-word;
            white-space: normal;
        }

        .solution-text {
            text-align: left !important;
            font-size: 10.5px;
            color: #111111;
            line-height: 1.4;
            word-wrap: break-word;
            white-space: normal;
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    @if(file_exists(storage_path('images/MUVHOF.jpg')))
        <img src="{{ storage_path('images/MUVHOF.jpg') }}" class="imagencentro" width="690">
    @endif

    @include('admin.help.pdf.header')
    @include('admin.help.pdf.footer')
</body>
</html>

