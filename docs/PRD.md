# Product Requirements Document (PRD) — Sistema de Asistencia Técnica y Mesa de Ayuda

## 1. Visión General del Producto
El **Sistema de Asistencia Técnica y Mesa de Ayuda (sistencia)** es una plataforma web desarrollada en **Laravel 8** y **Craftable 7** diseñada para gestionar el ciclo de vida completo de los tickets de soporte técnico, solicitudes de asistencia de funcionarios institucionales, asignación de técnicos, trazabilidad de patrimonios y generación de reportes operativos e imprimibles.

---

## 2. Objetivos del Sistema
1. **Centralizar la Gestión de Tickets (Helps / DetailHelps):** Permitir el registro rápido de solicitudes de soporte vinculadas a la cédula de identidad del funcionario.
2. **Integración con Recursos Humanos (RHM006 / Usuario):** Autocompletar datos del funcionario (Nombre, Apellido, Dependencia) consultando de forma transparente la base de datos externa de personal (sqlsrv / RHM006).
3. **Trazabilidad y Auditoría:** Registrar cada cambio de estado, técnico asignado, solución aplicada y bien patrimonial mediante OwenIt\Auditing.
4. **Gestión de Adjuntos:** Permitir la subida y almacenamiento seguro de documentos de respaldo por ticket mediante Spatie MediaLibrary.
5. **Generación de Reportes e Impresión:** Emitir reportes detallados y consolidados en formato PDF (arryvdh/laravel-dompdf).

---

## 3. Arquitectura y Stack Tecnológico

### Stack Actual:
* **Backend:** Laravel 8.75 (PHP ^7.3 / ^8.0).
* **Panel Administrativo:** Craftable 7.0 (rackets/craftable + rackets/admin-generator).
* **Bases de Datos:**
  * MySQL (Base de datos principal para helps, detail_helps, categories, states, users).
  * SQL Server (sqlsrv) para la consulta de personal institucional (RHM006).
* **Auditoría & Media:** owen-it/laravel-auditing, spatie/laravel-medialibrary.
* **Exportación PDF:** arryvdh/laravel-dompdf.

### Target Architecture (Diplomado / Clean Architecture):
Para garantizar mantenibilidad, testabilidad y escalabilidad, el sistema migrará a un esquema de 3 capas:
`
[ HTTP Router / Controller ] ──> [ Service Layer (Negocio) ] ──> [ Repository Layer (DB/External) ]
                                           │                                    │
                                  (Valida Reglas)                      (Eloquent / SQLSrv)
`

---

## 4. Módulos y Requisitos Funcionales

### 4.1. Módulo de Tickets y Asistencia (Helps & DetailHelps)
* **RF-1.1:** Registro de Ticket (Helps): Captura CI, nombre, teléfono, dependencia, descripción del problema y adjunto opcional.
* **RF-1.2:** Autocompletado por Cédula: Endpoint AJAX /cedula/{ced} que consulta la tabla RHM006 o Usuario y retorna el nombre completo y dependencia activa del funcionario.
* **RF-1.3:** Seguimiento de Estado (DetailHelps): Permite a los administradores/técnicos asignar categoría, estado (Abierto, En Proceso, Finalizado), patrimonio y solución técnica.
* **RF-1.4:** Adjuntos y Documentos: Permitir adjuntar y eliminar documentos de soporte técnico vinculados al ticket (Medium / Media).
* **RF-1.5:** Cierre de Ticket: Al marcar estado finalizado (Estado 4), disparar modal de confirmación y redirección correspondiente.

### 4.2. Módulo de Funcionarios (Funcionarios)
* **RF-2.1:** Consulta y sincronización de lista de funcionarios activos (FuncNro, FuncNom, FUsuCod).
* **RF-2.2:** Integración multi-conexión sin acoplar código HTTP.

### 4.3. Módulo de Reportes e Impresión (Reportes)
* **RF-3.1:** Filtro y generación de reportes por fecha, categoría, técnico y estado.
* **RF-3.2:** Exportación a PDF de la ficha de atención o reporte consolidado usando laravel-dompdf.

### 4.4. Módulo de Seguridad y Permisos (AdminUsers)
* **RF-4.1:** Autenticación de usuarios administrativos (dmin_users).
* **RF-4.2:** Control de acceso basado en roles y permisos individuales por módulo (ill_permissions_for_*).

---

## 5. Requisitos No Funcionales y Calidad de Código (TDD)

1. **Cobertura de Pruebas Automatizadas (TDD):**
   * El sistema debe contar con pruebas unitarias (Unit) para la capa de Services y Repositories.
   * El sistema debe contar con pruebas de integración (Feature) para verificar respuestas HTTP (200 OK, 422 Unprocessable Entity, 401 Unauthorized).
2. **Desacoplamiento de Controladores (Clean Controllers):**
   * Ningún controlador debe contener consultas directas a Eloquent o DB SQL Server.
   * Toda la lógica de negocio debe residir en App\Services\....
3. **Cero Falsos Verdes:**
   * Las pruebas deben validar contratos exactos de respuesta JSON y cambios en la base de datos real o en memoria (sqlite :memory:).

---

## 6. Hoja de Ruta de Refactorización (Fases)

| Fase | Descripción | Entregable |
| :--- | :--- | :--- |
| **Fase 1** | Documentación y Configuración del Entorno TDD | PRD.md, AGENTS.md y phpunit.xml ajustado con SQLite :memory:. |
| **Fase 2** | Módulo Piloto: Categories / States | Implementación de CategoryService, CategoryRepository y Tests de Feature. |
| **Fase 3** | Módulo Core: Funcionarios & Búsqueda por Cédula | Abstracción de consulta a SQL Server RHM006 en FuncionarioRepository + Unit Tests. |
| **Fase 4** | Módulo Core: Helps & DetailHelps | Refactorización de HelpsController a HelpService, manejo de adjuntos y colas + Tests completos. |
| **Fase 5** | Módulo de Reportes | Refactorización de ReporteService y generación de PDF testeadas. |
