# ADR 001: Estrategia de Paginación para el Sistema de Asistencia Técnica (`asistencia`)

## Contexto

El **Sistema de Asistencia Técnica (`asistencia`)** gestiona un volumen creciente de solicitudes de tickets (`Help` / `DetailHelp`) efectuadas por funcionarios y usuarios del sistema. La interfaz administrativa basada en Craftable 7 / Laravel requiere consultar listados de tickets activos (estados 1 y 2), tickets finalizados (estado 4), así como el padrón de funcionarios de RRHH y Usuarios.

Para mantener la respuesta fluida en la consola de administración y en las peticiones AJAX de Vue/Craftable, se requiere definir una estrategia de paginación uniforme en la capa de servicio utilizando `LengthAwarePaginator` y `AdminListing`.

---

## Alternativas Evaluadas

### 1. Paginación Basada en LengthAwarePaginator (Offset y Límite)
Consiste en utilizar la paginación estándar de Laravel (`LengthAwarePaginator` / `AdminListing::processRequestAndGet`), calculando el total de páginas, página actual y elementos por página.
- **Ventajas:** Integración nativa con Craftable 7, DataTables de Vue.js y controladores de Laravel. Permite construir componentes de UI con numeración de páginas explícita (1, 2, 3...) y conocer el total acumulado de tickets.
- **Desventajas:** Escaneo con `OFFSET` en la base de datos PostgreSQL/SQL Server cuando el número de páginas es muy elevado.

### 2. Paginación Basada en Cursores (Cursor-based Pagination)
Utiliza punteros opacos basados en `id` o timestamps para traer registros siguientes.
- **Ventajas:** Rendimiento $O(1)$ constante sin penalidad por `OFFSET`.
- **Desventajas:** No soporta navegación directa a páginas aleatorias ni metadatos de paginación completos requeridos por las tablas de Craftable.

---

## Decisión Adoptada

Se adopta **Paginación Estándar Basada en LengthAwarePaginator (con desacoplamiento en 3 capas)** para el módulo `Helps`, `Funcionarios`, `Categories` y `States`.

### Implementación en 3 Capas:
1. **Repository:** Ejecuta las consultas base filtradas y optimizadas en PostgreSQL / SQL Server.
2. **Service:** Construye las instancias de `LengthAwarePaginator` preservando metadatos (`total`, `per_page`, `current_page`, `last_page`).
3. **Controller:** Devuelve el array serializado `['data' => $paginator]` para respuestas AJAX de Craftable o la vista Blade.

---

## Consecuencias Positivas

- **Compatibilidad 100% con Frontend:** Mantiene compatibilidad total con la UI de Craftable 7 sin necesidad de modificar los componentes de Vue.js.
- **Consistencia en Pruebas Unitarias:** Facilita la verificación estricta en PHPUnit mediante assertions `assertInstanceOf(LengthAwarePaginator::class, $result)`.
- **Desacoplamiento:** La lógica de paginación vive en `App\Services\*Service`, desligada del framework de transporte HTTP.

---

## Condición de Revisión

Este ADR deberá revisarse si el volumen de tickets supera los 500,000 registros activos y el tiempo de respuesta de las consultas con `OFFSET` elevado excede los 500ms en el entorno local/producción.
