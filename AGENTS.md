# AGENTS.md — Reglas del Proyecto Sistema de Asistencia (Laravel 8 + Craftable)

Este repositorio contiene el sistema de asistencia técnica, mesa de ayuda y gestión de funcionarios (**Laravel 8** + **Craftable 7**).

Cualquier cambio o desarrollo en este código DEBE seguir la arquitectura de 3 capas y el flujo estricto de TDD Asistido.

---

## Regla General: Arquitectura de 3 Capas en Laravel

Toda funcionalidad o módulo debe dividirse en:

Controller (Transporte) -> Service (Negocio) -> Repository (Infraestructura / DB)

Si un controlador realiza consultas directas a Eloquent, llamadas directas a SQL Server (sqlsrv) o reglas complejas de negocio, está mal diseñado.

---

## 1) Controllers · app/Http/Controllers/
* **Responsabilidad:** Recibir peticiones HTTP, ejecutar la validación con FormRequest, llamar al Service correspondiente y retornar respuestas HTTP (JSON o vistas Blade/Craftable).
* **NO DEBE HACER:** Consultas Eloquent, operaciones SQL, reglas de negocio ni lógica de archivos.

## 2) Services · app/Services/
* **Responsabilidad:** Contener la lógica de negocio, orquestación de casos de uso, transformaciones de datos y reglas comerciales.
* **NO DEBE HACER:** Importar clases de HTTP (Request, Response), ejecutar consultas de base de datos directamente o manipular status codes HTTP.

## 3) Repositories · app/Repositories/
* **Responsabilidad:** Aislar la infraestructura y base de datos (queries Eloquent, DB Query Builder, conexión a sqlsrv / RHM006, servicios externos).
* **NO DEBE HACER:** Reglas de negocio ni manejo de peticiones HTTP.

---

## Flujo de TDD Asistido (4 Pasos)

1. **Contratos (FormRequests / DTOs):** Definir primero las reglas de validación en FormRequest.
2. **Tests (Pantalla Roja):** Escribir la prueba en 	ests/Feature/ o 	ests/Unit/ que compruebe la funcionalidad requerida. Debe FALLAR antes de programar.
3. **Implementación:** Implementar el Repository, Service y Controller mínimos para hacer pasar el test.
4. **Verificación (Pantalla Verde):** Ejecutar php artisan test y confirmar el éxito sin falsos verdes.
