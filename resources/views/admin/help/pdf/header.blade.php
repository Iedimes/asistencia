<h2 class="section-title">SOLICITUD DE ASISTENCIA</h2>

<table class="pdf-table">
    <tbody>
        <tr>
            <td style="width: 20%;"><strong>NÚMERO:</strong> {{ $help->id }}</td>
            <td style="width: 50%;"><strong>NOMBRE:</strong> {{ $help->name }}</td>
            <td style="width: 30%;"><strong>CÉDULA:</strong> {{ $help->ci }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>DEPENDENCIA:</strong> {{ $help->dependency }}</td>
            <td><strong>ESTADO:</strong> {{ optional(optional($help->statuses)->state)->name ?? 'SOLICITADO' }}</td>
        </tr>
        <tr>
            <td colspan="3"><strong>TELÉFONO:</strong> {{ $help->fone }}</td>
        </tr>
        <tr>
            <td colspan="3" class="problem-cell">
                <strong style="display: block; margin-bottom: 4px;">DESCRIPCIÓN SOLICITUD:</strong>
                <div class="problem-text">{!! nl2br(e($help->problem)) !!}</div>
            </td>
        </tr>
    </tbody>
</table>

<h2 class="section-title" style="margin-top: 20px;">DETALLE DE ASISTENCIA</h2>

<table class="pdf-table">
    <thead>
        <tr>
            <th style="width: {{ $colWidths['user'] ?? '22%' }};">TÉCNICO</th>
            <th style="width: {{ $colWidths['solution'] ?? '44%' }};">ACCIÓN REALIZADA</th>
            <th style="width: {{ $colWidths['date'] ?? '14%' }};">FECHA ASISTENCIA</th>
            <th style="width: {{ $colWidths['category'] ?? '10%' }};">CATEGORÍA</th>
            <th style="width: {{ $colWidths['patrimony'] ?? '10%' }};">PATRIMONIO</th>
        </tr>
    </thead>
    <tbody>
        @php $hasDetails = false; @endphp
        @foreach ($detalle as $item)
            @if (optional($item->user)->id !== 1)
                @php $hasDetails = true; @endphp
                <tr>
                    <td>{{ optional($item->user)->full_name ?? '' }}</td>
                    <td class="solution-text">{!! nl2br(e($item->solution)) !!}</td>
                    <td class="text-center">
                        @php
                            $formattedDateTime = '-';
                            if (!empty($item->date)) {
                                $parsedDate = \Carbon\Carbon::parse($item->date);
                                if ($parsedDate->format('H:i') !== '00:00') {
                                    $formattedDateTime = $parsedDate->format('d/m/Y H:i');
                                }
                            }
                            if ($formattedDateTime === '-' && !empty($item->created_at)) {
                                $parsedCreatedAt = \Carbon\Carbon::parse($item->created_at);
                                $formattedDateTime = $parsedCreatedAt->format('d/m/Y H:i');
                            }
                            if ($formattedDateTime === '-' && !empty($item->date)) {
                                $formattedDateTime = \Carbon\Carbon::parse($item->date)->format('d/m/Y H:i');
                            }
                        @endphp
                        {{ $formattedDateTime }}
                    </td>
                    <td>{{ optional($item->category)->name ?? '' }}</td>
                    <td class="text-center">{{ $item->patrimony }}</td>
                </tr>
            @endif
        @endforeach

        @if (!$hasDetails)
            <tr>
                <td colspan="5" class="text-center" style="color: #777777; font-style: italic;">
                    No se registran acciones realizadas adicionales.
                </td>
            </tr>
        @endif
    </tbody>
</table>

