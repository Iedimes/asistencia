# ERD — Modelo Entidad-Relación de Asistencia Técnica

## Propósito y Alcance

Este modelo lógico define la estructura de datos del **Sistema de Asistencia Técnica (`asistencia`)**, soportando la gestión de tickets de ayuda, historial de cambios de estado, categorías técnicas, adjuntos multimedia y la integración con fuentes externas de personal (**Recursos Humanos / RHM006** y **Seguridad / Usuario**).

## Diagrama ERD

```mermaid
erDiagram
    ADMIN_USER ||--o{ DETAIL_HELP : "registra / resuelve"
    HELP ||--|{ DETAIL_HELP : "posee historial"
    STATE ||--o{ DETAIL_HELP : "clasifica estado"
    CATEGORY ||--o{ DETAIL_HELP : "clasifica categoria"
    HELP ||--o{ MEDIUM : "adjunta documentos"

    RHM006 ||--o| HELP : "provee datos por CI (RRHH)"
    USUARIO ||--o| HELP : "provee datos por CI (Seguridad)"

    HELP {
        int id PK
        string ci "Cédula de Identidad del Solicitante"
        string name "Nombre Completo del Solicitante"
        string user "Usuario Corporativo"
        string dependency "Dependencia / Departamento"
        string fone "Teléfono de Contacto"
        text problem "Descripción del Inconveniente"
        int dependency_id "ID de Dependencia"
        datetime created_at
        datetime updated_at
    }

    DETAIL_HELP {
        int id PK
        int help_id FK "Relación con el Ticket principal"
        int user_id FK "Usuario Administrador resolutor"
        int state_id FK "Estado (1: Abierto, 2: En Proceso, 4: Finalizado)"
        int category_id FK "Categoría Técnica del Inconveniente"
        text solution "Descripción del seguimiento o resolución"
        date date "Fecha del registro de detalle"
        datetime created_at
        datetime updated_at
    }

    STATE {
        int id PK
        string name "Nombre del Estado (Abierto, En Proceso, Finalizado)"
    }

    CATEGORY {
        int id PK
        string name "Nombre de la Categoría (Hardware, Software, Redes, Accesos)"
    }

    ADMIN_USER {
        int id PK
        string name
        string email
    }

    MEDIUM {
        int id PK
        string model_type
        int model_id FK "Asociado a Help"
        string collection_name "gallery"
        string file_name
        string mime_type
    }

    RHM006 {
        string FuncNro PK "Cédula RRHH (sqlsrv)"
        string FuncNom "Nombre del Funcionario"
        string FUsuCod "Código de Usuario"
        string FuncEst "Estado del Registro (A/I)"
    }

    USUARIO {
        string UsuCed PK "Cédula Seguridad"
        string UsuNombre "Nombre del Usuario"
        string UsuCod "Código de Usuario"
        string Usuest "Estado del Registro (A/I)"
    }
```

## Reglas de Integridad y Negocio

1. **Historial Inmutable:** Todo ticket (`HELP`) cuenta con al menos un registro inicial en `DETAIL_HELP` con `state_id = 1` (Abierto).
2. **Fuentes Exógenas:** Las consultas por cédula acceden secuencialmente a la vista/tabla `RHM006` (Recursos Humanos) y en caso de no hallar coincidencia, a la tabla `USUARIO` (Seguridad).
3. **Múltiples Adjuntos:** Las evidencias y documentos técnicos se almacenan utilizando Spatie MediaLibrary en la tabla `MEDIUM`.
