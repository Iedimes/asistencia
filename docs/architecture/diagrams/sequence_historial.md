# Diagrama de Secuencia — Flujos Principales de Asistencia Técnica

Este diagrama documenta la secuencia de interacción bajo la arquitectura de **3 Capas (`Controller -> Service -> Repository`)** implementada en el sistema.

```mermaid
sequenceDiagram
    autonumber
    actor Usuario as Operador / Solicitante
    participant Ctrl as HelpsController
    participant Svc as HelpService
    participant Repo as HelpRepository
    participant DB as PostgreSQL (asistencia)
    participant Ext as RRHH / Seguridad (RHM006 / Usuario)

    %% 1. Consulta por Cédula
    rect rgb(240, 248, 255)
    note right of Usuario: Escenario 1: Consulta de Datos por Cédula (AJAX)
    Usuario->>Ctrl: GET /cedula/{cedula}
    activate Ctrl
    Ctrl->>Svc: lookupPersonByCedula(cedula)
    activate Svc
    Svc->>Repo: findPersonInRrhh(cedula)
    activate Repo
    Repo->>Ext: SELECT * FROM RHM006 WHERE FuncNro = cedula AND FuncEst = 'A'
    alt Encontrado en RRHH
        Ext-->>Repo: Datos Funcionario (FuncNom, FUsuCod, DepenDes)
        Repo-->>Svc: Funcionario Model
        Svc-->>Ctrl: Array JSON {error: false, cedula: {...}}
    else No encontrado en RRHH
        Repo->>Ext: SELECT * FROM usuario WHERE UsuCed = cedula AND Usuest = 'A'
        alt Encontrado en Seguridad
            Ext-->>Repo: Datos Usuario (UsuNombre, UsuCod)
            Repo-->>Svc: Usuario Model
            Svc-->>Ctrl: Array JSON {error: false, cedula: {...}}
        else No encontrado en ninguna fuente
            Repo-->>Svc: null
            Svc-->>Ctrl: Array JSON {error: true, message: "No se encuentra"}
        end
    end
    deactivate Repo
    deactivate Svc
    Ctrl-->>Usuario: 200 OK Response JSON
    deactivate Ctrl
    end

    %% 2. Registro de Ticket
    rect rgb(245, 255, 245)
    note right of Usuario: Escenario 2: Registro de Solicitud de Asistencia
    Usuario->>Ctrl: POST /admin/helps/storeadm (StoreHelp)
    activate Ctrl
    Ctrl->>Svc: registerTicket(sanitizedData, initialDetailData)
    activate Svc
    Svc->>Repo: createHelp(sanitizedData)
    activate Repo
    Repo->>DB: INSERT INTO helps (ci, name, problem, ...)
    DB-->>Repo: Help Entity
    Repo-->>Svc: Help Entity
    deactivate Repo

    Svc->>Repo: createDetailHelp(initialDetailData)
    activate Repo
    Repo->>DB: INSERT INTO detail_helps (help_id, state_id, category_id, ...)
    DB-->>Repo: DetailHelp Entity
    Repo-->>Svc: DetailHelp Entity
    deactivate Repo

    opt Adjunto presente en Request
        Svc->>DB: Guardar archivo en Spatie MediaLibrary (gallery)
    end

    Svc-->>Ctrl: Help Entity Creada
    deactivate Svc
    Ctrl-->>Usuario: Redirect /admin/helps (200 OK / 302 Redirect)
    deactivate Ctrl
    end
```

## Componentes y Capas

1. **`HelpsController`:** Recibe HTTP requests, desencadena la validación de contratos mediante FormRequests (`StoreHelp`, `UpdateHelp`) y delega la lógica de negocio al servicio.
2. **`HelpService`:** Ejecuta las reglas de negocio (orquestación del ticket, creación automática de detalle inicial y búsqueda jerárquica de personal por Cédula).
3. **`HelpRepository`:** Encapsula el acceso directo a la base de datos PostgreSQL y las tablas de legado/soporte.
