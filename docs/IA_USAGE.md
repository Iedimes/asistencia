# Bitácora de Uso de IA y Gobernanza (`IA_USAGE.md`)

Este documento registra de forma transparente las intervenciones, refactorizaciones, generación de pruebas automatizadas y decisiones de arquitectura guiadas por la Asistencia de IA (**Google Antigravity**) en el **Sistema de Asistencia Técnica (`asistencia`)**.

---

## 1. Declaración de Principios de Gobernanza y Supervisión Humana

1. **Supervisión Humana Obligatoria:** Todo código generado o refactorizado por la IA es validado empíricamente mediante pruebas automatizadas (PHPUnit) en el entorno de pruebas local.
2. **TDD Estricto en 4 Pasos:** La IA no escribe código de producción sin haber presentado primero un test fallido (Pantalla Roja) o un contrato predefinido.
3. **Cero Falsos Verdes:** La IA no silenciará excepciones ni introducirá assertions triviales. Cada prueba valida estado real en base de datos PostgreSQL local (`asistencia_testing`).
4. **Desacoplamiento Estricto:** La IA debe forzar la separación de capas `Controller -> Service -> Repository` en todo momento.

---

## 2. Bitácora de Intervenciones y Refactorizaciones

### Sesión 1: Configuración de Infraestructura TDD y Documentación Inicial
* **Fecha:** 18/08/2026
* **Tareas Realizadas por IA:**
  * Diagnóstico del proyecto Laravel 8 + Craftable 7.
  * Elaboración del documento de requisitos del producto ([`PRD.md`](file:///C:/Users/osemidei/Documents/asistencia/docs/PRD.md)).
  * Definición de reglas del proyecto ([`AGENTS.md`](file:///C:/Users/osemidei/Documents/asistencia/AGENTS.md)).
  * Configuración del entorno de testing local con **PostgreSQL** (`asistencia_testing`).
  * Detección y corrección de un error de migración duplicada (`CreateMediaTable`).
  * Creación e implementación exitosa de [`SanityTest.php`](file:///C:/Users/osemidei/Documents/asistencia/tests/Feature/SanityTest.php) (3/3 tests en verde).

---

### Sesión 2: Refactorización a 3 Capas del Módulo `Categories`
* **Fecha:** 18/08/2026
* **Tareas Realizadas por IA:**
  * **Paso 1 (Contratos):** Análisis de `StoreCategory` y `UpdateCategory` FormRequests.
  * **Paso 2 (Pantalla Roja):** Creación de `tests/Unit/CategoryServiceTest.php` demostrando falla por clases inexistentes.
  * **Paso 3 (Implementación):**
    * Creación de `App\Repositories\CategoryRepository`.
    * Creación de `App\Services\CategoryService`.
    * Refactorización de `CategoriesController` eliminando consultas Eloquent directas.
  * **Paso 4 (Pantalla Verde):** Desarrollo de `CategoryFeatureTest.php` probando autenticación de Craftable y validaciones HTTP.
* **Resultado:** 11/11 tests ejecutados con éxito (100% verde en 2.7 segundos sobre PostgreSQL local).

---

### Sesión 3: Refactorización a 3 Capas del Módulo `States`
* **Fecha:** 18/08/2026
* **Tareas Realizadas por IA:**
  * **Paso 1 (Contratos):** Análisis de `StoreState` y `UpdateState` FormRequests.
  * **Paso 2 (Pantalla Roja):** Creación de `tests/Unit/StateServiceTest.php` comprobando la falla inicial por falta de clases.
  * **Paso 3 (Implementación):**
    * Creación de `App\Repositories\StateRepository`.
    * Creación de `App\Services\StateService`.
    * Refactorización de `StatesController` para delegar el 100% de operaciones al servicio.
  * **Paso 4 (Pantalla Verde):** Creación de `StateFeatureTest.php` con permisos Spatie de Craftable y ejecución completa de la suite.
* **Resultado:** 17/17 tests ejecutados con éxito (100% verde en 3.49 segundos sobre PostgreSQL local).

---

### Sesión 4: Refactorización a 3 Capas del Módulo `Funcionarios` (Opción B)
* **Fecha:** 18/08/2026
* **Tareas Realizadas por IA:**
  * **Paso 1 (Contratos):** Análisis de `IndexFuncionario` y `StoreFuncionario` FormRequests.
  * **Paso 2 (Pantalla Roja):** Creación de `tests/Unit/FuncionarioServiceTest.php` demostrando falla inicial por falta de `FuncionarioRepository`.
  * **Paso 3 (Implementación):**
    * Creación de `App\Repositories\FuncionarioRepository` (abstrae las búsquedas en RRHH y SEGURIDAD).
    * Creación de `App\Services\FuncionarioService` (orquesta búsquedas cruzadas, mapeos, trimmings de strings y paginación `LengthAwarePaginator`).
    * Refactorización de `FuncionariosController` reduciendo más de 200 líneas de lógica de búsqueda directa a delegación HTTP pura.
    * Incorporación de accesores de limpieza (`trim`) en el modelo `Funcionario.php`.
  * **Paso 4 (Pantalla Verde):** Desarrollo de `FuncionarioFeatureTest.php` y ejecución completa de la suite.
* **Resultado:** 23/23 tests ejecutados con éxito (100% verde en 4.04 segundos sobre PostgreSQL local).

---

### Sesión 5: Refactorización a 3 Capas del Módulo Núcleo `Helps` y `DetailHelps`
* **Fecha:** 18/08/2026
* **Tareas Realizadas por IA:**
  * **Paso 1 (Contratos):** Análisis de FormRequests `StoreHelp`, `UpdateHelp`, `IndexHelp` y migraciones de `detail_helps`.
  * **Paso 2 (Pantalla Roja):** Creación de `tests/Unit/HelpServiceTest.php` verificando falla inicial por falta de `HelpRepository`.
  * **Paso 3 (Implementación):**
    * Creación de `App\Repositories\HelpRepository` (gestión de `Help`, `DetailHelp`, `Medium` y búsquedas por Cédula).
    * Creación de `App\Services\HelpService` (registro de tickets, creación de historial inicial, consultas por CI y eliminación de adjuntos).
    * Refactorización masiva de `HelpsController` eliminando consultas de subquery y SQL inline hacia delegación limpia al servicio.
    * Resolución de resticciones de Foreign Key y secuencias de PostgreSQL (`detail_helps_state_id_foreign`, `detail_helps_category_id_foreign`).
  * **Paso 4 (Pantalla Verde):** Creación de `HelpFeatureTest.php` validando rutas `/admin/helps/storeadm` y `/cedula/{cedula}`.
* **Resultado:** 29/29 tests ejecutados con éxito (100% verde en 4.64 segundos sobre PostgreSQL local).

---

### Sesión 6: Refactorización y Estandarización de Estilos UI, Perfil, Login y Redirecciones
* **Fecha:** 08/09/2026
* **Tareas Realizadas por IA:**
  * **Paso 1 (Contratos y Correcciones de Negocio):**
    * Corrección del filtrado por técnico en `HelpService.php` evaluando estrictamente el **último registro de detalle registrado por ticket**.
    * Registro del alias de ruta `upload` en `routes/web.php` para la compatibilidad con el cargador de avatar en `brackets/admin-ui`.
    * Ajuste de reglas de validación en `ProfileController@updatePassword` a confirmación obligatoria con mínimo 7 caracteres.
  * **Paso 2 (Pantalla Roja / Tests):**
    * Desarrollo de `tests/Feature/ProfileFeatureTest.php` verificando accesos a Perfil (`/admin/profile`), Contraseña (`/admin/password`), actualización de datos y redirección `/admin` -> `/admin/helps`.
  * **Paso 3 (Implementación UI/UX):**
    * **Cabecera Principal (`header.blade.php`)**: Estilizada con el degradado oscuro pizarra (`#1e293b` / `#0f172a`), insignia blanca para el logo MUVH (`logo.blade.php`), y adición de `data-toggle="dropdown"`.
    * **Menú Desplegable de Perfil (`profile-dropdown.blade.php`)**: Caja emergente oscura pizarra (`#0f172a`) con esquinas curvas (`12px`), sombra flotante y accesos a Perfil, Contraseña y Logout.
    * **Pantalla de Inicio de Sesión (`login.blade.php`)**: Fondo general limpio (`#f8fafc`), tarjeta con encabezado en tono Azul Marino Institucional, insignia del logo MUVH y botón redondeado.
    * **Paginación (`_index.scss` -> `admin.css`)**: Botón de página activa formateado con el tono oscuro pizarra `#0f172a` y sombra fina.
    * **Redireccionamientos**: Configuración de `'login_redirect' => '/admin/helps'` en `config/admin-auth.php` y `Route::get('/admin')` -> `redirect('admin/helps')` en `routes/web.php`.
  * **Paso 4 (Pantalla Verde):** Ejecución de la suite completa con `php artisan test`.
* **Resultado:** 38/38 tests ejecutados con éxito (100% verde en 5.90 segundos sobre PostgreSQL local).
