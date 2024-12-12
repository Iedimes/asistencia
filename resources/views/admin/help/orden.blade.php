<div class="row">
    <!-- Contenedor para Orden de Atención -->
    <div class="col-md-2">
        <div class="card mb-3">
            <div class="card-header text-center">
                <h5 style="color: red; font-weight: bold; text-transform: uppercase; margin-bottom: 0px;">Orden de Atención</h5>

            </div>

            <div class="card-body" style="padding: 8px;">
                @if($ordersBeingAttended->isEmpty())
                    <p class="text-muted text-center" style="margin: 0;">No hay órdenes en atención actualmente.</p>
                @else
                    <ul class="list-unstyled" id="order-list" style="margin-bottom: 0;">
                        @foreach($ordersBeingAttended as $order)
                            <li class="mb-2">
                                <div class="border p-2 rounded " style="background-color: #f1ebeb;">
                                    <strong style="color: black;">Ticket: <span style="color: red;">{{ $order->id }}</span></strong><br>
                                    <strong style="color: black;">Posición: <span style="color: #5cb85c;">{{ $order->position }}</span></strong>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>


<script>
    function fetchOrders() {
        fetch('{{ url('fetch-orders') }}')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                const orderList = document.getElementById('order-list');
                orderList.innerHTML = ''; // Limpiar la lista existente

                if (data.orders.length === 0) {
                    orderList.innerHTML = '<p class="text-muted text-center" style="margin: 0;">No hay órdenes en atención actualmente.</p>';
                } else {
                    data.orders.forEach(order => {
                        const li = document.createElement('li');
                        li.className = 'mb-2';
                        li.innerHTML = `
                            <div class="border p-2 rounded" style="background-color: #f1ebeb;">
                                <strong style="color: black;">Ticket: <span style="color: red;">${order.id}</span></strong><br>
                                <strong style="color: black;">Posición: <span style="color: #5cb85c;">${order.position}</span></strong>
                            </div>
                        `;
                        orderList.appendChild(li);
                    });
                }
            })
            .catch(error => console.error('Error fetching orders:', error));
    }

    setInterval(fetchOrders, 60000); // Actualizar cada 1 minuto
    fetchOrders(); // Llamar la función una vez al cargar la página
</script>
