<!-- Contenedor para Orden de Atención en Vivo -->
<div class="col-xl-3 col-lg-3 col-md-4 mb-4">
    <div class="card shadow-sm overflow-hidden" style="border: 1px solid #cbd5e1 !important; border-radius: 1rem !important; background: #ffffff;">
        <div class="card-header border-0 py-3 px-3 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white;">
            <h6 class="mb-0 font-weight-bold text-uppercase tracking-wider" style="font-size: 0.85rem; letter-spacing: 0.5px;">Orden de Atención</h6>
            <span class="badge bg-danger rounded-pill px-2 py-1 d-flex align-items-center gap-1" style="font-size: 0.68rem;">
                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" style="width: 0.45rem; height: 0.45rem;"></span>
                EN VIVO
            </span>
        </div>

        <div class="card-body p-3">
            <div id="order-list-container">
                @if($ordersBeingAttended->isEmpty())
                    <div class="text-center py-4 text-muted">
                        <i class="fa fa-check-circle-o fa-2x mb-2 text-success opacity-75"></i>
                        <p class="small mb-0 font-weight-bold">Sin órdenes pendientes</p>
                        <span class="text-xs text-secondary">La cola está al día</span>
                    </div>
                @else
                    <ul class="list-unstyled mb-0" id="order-list">
                        @foreach($ordersBeingAttended as $order)
                            <li class="mb-2">
                                <div class="p-2 px-3 d-flex justify-content-between align-items-center" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.75rem; transition: all 0.2s ease;">
                                    <div>
                                        <span class="fw-bold text-dark font-weight-bold" style="font-size: 0.95rem; color: #0f172a;">#{{ $order->id }}</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-dark rounded-pill px-3 py-1 font-weight-bold" style="font-size: 0.85rem;">#{{ $order->position }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        <div class="card-footer bg-light border-0 text-center py-2">
            <small class="text-muted" style="font-size: 0.72rem;">
                <i class="fa fa-refresh fa-spin text-primary me-1"></i> Actualización cada 30s
            </small>
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
                const orderListContainer = document.getElementById('order-list-container');

                if (!data.orders || data.orders.length === 0) {
                    orderListContainer.innerHTML = `
                        <div class="text-center py-4 text-muted">
                            <i class="fa fa-check-circle-o fa-2x mb-2 text-success opacity-75"></i>
                            <p class="small mb-0 font-weight-bold">Sin órdenes pendientes</p>
                            <span class="text-xs text-secondary">La cola está al día</span>
                        </div>
                    `;
                } else {
                    let html = '<ul class="list-unstyled mb-0" id="order-list">';
                    data.orders.forEach(order => {
                        html += `
                            <li class="mb-2">
                                <div class="p-2 px-3 d-flex justify-content-between align-items-center" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.75rem; transition: all 0.2s ease;">
                                    <div>
                                        <span class="fw-bold text-dark font-weight-bold" style="font-size: 0.95rem; color: #0f172a;">#${order.id}</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-dark rounded-pill px-3 py-1 font-weight-bold" style="font-size: 0.85rem;">#${order.position}</span>
                                    </div>
                                </div>
                            </li>
                        `;
                    });
                    html += '</ul>';
                    orderListContainer.innerHTML = html;
                }
            })
            .catch(error => console.error('Error fetching orders:', error));
    }

    setInterval(fetchOrders, 30000); // Actualizar cada 30 segundos
</script>
