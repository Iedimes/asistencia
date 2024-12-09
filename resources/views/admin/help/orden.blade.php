<div class="row">
    <!-- Contenedor para Orden de Atención -->
    <div class="col-md-2">
        <div class="card mb-2">
            <div class="card-header">
                <h5>ORDEN DE ATENCION</h5>
                <hr>
            </div>
            <div class="card-body" style="padding: 5px;">
                @if($ordersBeingAttended->isEmpty())
                    <p class="text-muted">No hay órdenes en atención actualmente.</p>
                @else
                    <ul class="list-unstyled" id="order-list">
                        @foreach($ordersBeingAttended as $order)
                            <li class="mb-2">
                                <div class="border p-2 rounded" style="background-color: #f8f9fa;">
                                    <strong>Nro de Ticket:</strong> <span class="text-primary">{{ $order->id }}</span> <br>
                                    <strong>Posición:</strong> <span class="text-success">{{ $order->position }}</span>
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
        fetch('{{ url('fetch-orders') }}') // Asegúrate de que la URL sea correcta
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
                    orderList.innerHTML = '<p class="text-muted">No hay órdenes en atención actualmente.</p>';
                } else {
                    data.orders.forEach(order => {
                        const li = document.createElement('li');
                        li.className = 'mb-2';
                        li.innerHTML = `
                            <div class="border p-2 rounded" style="background-color: #f8f9fa;">
                                <strong>Nro de Ticket:</strong> <span class="text-primary">${order.id}</span> <br>
                                <strong>Posición:</strong> <span class="text-success">${order.position}</span>
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
