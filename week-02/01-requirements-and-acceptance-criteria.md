# ASII-24 — RF, RNF y criterios de aceptación

## 1. Identificación de la actividad

| Campo | Valor |
|---|---|
| Estudiante | ALBINO SEBASTIAN ROSALES RUANO |
| GitHub | `codsebas` |
| Módulo oficial | Contratos API: OpenAPI/Postman y documentación técnica |
| Actividad adaptada | Centro de documentación y manuales por rol |
| Semana | 2 |
| Tipo de evidencia | RF, RNF, criterios de aceptación y trazabilidad |

## 2. Propósito y relación con la Semana 1

Esta evidencia define los requerimientos funcionales y no funcionales del módulo ASII-24 como una propuesta académica de análisis y diseño. No describe una implementación existente.

La Semana 1 fijó el alcance, los actores y los casos de uso; esta Semana 2 conserva esos identificadores y los conecta con requisitos y criterios de aceptación sin alterar la base aprobada.

## 3. Contexto verificado y comportamiento propuesto

| Elemento | Estado verificado en el repositorio | Comportamiento propuesto para ASII-24 |
|---|---|---|
| JWT | Existe autenticación JWT en el backend base. | Validar identidad antes de cualquier operación documental protegida. |
| `X-Tenant-ID` | El tenant se resuelve por la cabecera requerida `X-Tenant-ID`. | Restringir toda consulta o administración al tenant activo. |
| RBAC roles | Existen roles semilla con Spatie Permission y guard `api`. | Usar `Admin` como rol administrativo y `Médico`, `Enfermera`, `TecnicoLab` y `Recepcionista` como roles lectores. |
| Prefijo de API | Las rutas API usan el prefijo `/api/v1`. | Mantener la separación conceptual del módulo dentro de ese contexto base. |
| Alcance actual de la API | Solo existen rutas de autenticación. | No inventar endpoints ni contratos finales para esta semana. |
| Centro de documentación y manuales | No existe una implementación documental en el repositorio. | Proponer un centro de documentación y manuales por rol como ejercicio académico. |
| Estado de RF/RNF | No están implementados como funcionalidad del sistema. | Documentarlos como requerimientos propuestos. |
| Estado de criterios de aceptación | No existen criterios de aceptación implementados. | Definir criterios en formato `Dado / Cuando / Entonces` a nivel de análisis. |

## 4. Convenciones de identificación

- Se conservan exactamente los identificadores `UC-*`, `RF-*`, `RNF-*` y `CA-*` aprobados.
- `TecnicoLab` se presenta como Técnico de laboratorio (`TecnicoLab`) cuando se requiera texto humano.
- `Admin` es el único actor administrativo conceptual permitido para esta semana.
- No se definen payloads, rutas, esquemas, códigos HTTP finales ni permisos de implementación.

## 5. Requisitos funcionales

| ID | Nombre | Descripción | Actor | Precondición | Entrada conceptual | Resultado esperado | Excepción principal | UC relacionado | Prioridad | Estado |
|---|---|---|---|---|---|---|---|---|---|---|
| RF-01 | Validar contexto de acceso | Verifica autenticación, tenant activo, correspondencia usuario-tenant y roles del usuario antes de cualquier operación protegida. | Control de acceso existente del HIS | Existe una petición con contexto de acceso. | JWT y `X-Tenant-ID`. | El módulo continúa solo si el contexto es válido. | Rechazo por autenticación inválida, tenant inexistente o desajuste usuario-tenant. | UC-09 | Alta | Propuesto |
| RF-02 | Consultar documentación disponible | Retorna solo la documentación activa del tenant actual visible para al menos uno de los roles del usuario autenticado. | Usuario autenticado del HIS | Contexto de acceso válido. | Solicitud de consulta documental. | Se muestra la lista autorizada o un estado vacío seguro. | No hay documentos accesibles o existe restricción por tenant/rol. | UC-01 | Alta | Propuesto |
| RF-03 | Buscar y filtrar documentación | Permite restringir conceptualmente la lista autorizada mediante criterios como título, categoría, tipo, versión o estado. | Usuario autenticado del HIS | Existe una lista autorizada previa. | Criterios conceptuales de búsqueda. | Los resultados se limitan al conjunto ya autorizado. | El filtro no produce coincidencias autorizadas. | UC-02 | Media | Propuesto |
| RF-04 | Visualizar documento o manual | Permite ver un documento seleccionado solo tras revalidar tenant, estado y visibilidad por rol. | Usuario autenticado del HIS | Documento activo del mismo tenant. | Solicitud de visualización. | El contenido puede mostrarse si el acceso sigue siendo válido. | Documento inexistente, archivado, cruzado de tenant o restringido por rol. | UC-03 | Alta | Propuesto |
| RF-05 | Descargar documento o manual | Permite descargar un documento seleccionado solo tras revalidar tenant, estado y visibilidad por rol. | Usuario autenticado del HIS | Documento activo y autorizado. | Solicitud de descarga. | El archivo puede entregarse de forma autorizada. | Archivo no disponible o acceso denegado por tenant/rol. | UC-04 | Media | Propuesto |
| RF-06 | Publicar documento o manual | Permite que solo `Admin` registre una publicación documental dentro del tenant activo. | `Admin` | El actor es `Admin` y tiene contexto válido. | Información documental conceptual y roles lectores. | La publicación puede registrarse dentro del tenant. | Usuario no `Admin` o información inválida. | UC-05 | Alta | Propuesto |
| RF-07 | Asignar visibilidad por rol | Permite asociar uno o más roles lectores aprobados a la publicación del documento. | `Admin` | Existe una publicación válida en proceso. | Selección conceptual de roles lectores. | La visibilidad queda asociada a los roles seleccionados. | Selección vacía, inválida o incompleta. | UC-06 | Alta | Propuesto |
| RF-08 | Validar información documental | Revisa la coherencia conceptual de la información requerida antes de publicar o actualizar una versión. | Módulo ASII-24 | Existen datos conceptuales de publicación o actualización. | Metadatos documentales conceptuales. | Se reportan errores corregibles o se valida la información. | Datos incompletos, inconsistentes o inválidos. | UC-10 | Alta | Propuesto |
| RF-09 | Actualizar versión del documento | Permite que solo `Admin` registre una nueva versión de un documento existente en el tenant activo. | `Admin` | Existe un documento del tenant activo. | Nueva versión conceptual. | Se registra la versión sin romper el aislamiento del tenant. | Documento inexistente, tenant incorrecto o validación fallida. | UC-07 | Media | Propuesto |
| RF-10 | Archivar documento | Permite que solo `Admin` archive un documento del tenant activo. El archivado excluye el documento de la consulta normal sin afirmar una eliminación física. | `Admin` | Existe un documento activo del tenant. | Confirmación de archivo lógico. | El documento queda excluido de la consulta normal. | Operación cancelada o documento no archivable. | UC-08 | Media | Propuesto |

## 6. Requisitos no funcionales

| ID | Categoría | Requisito | Medida de verificación propuesta | Prioridad | RF o UC relacionado | Estado actual |
|---|---|---|---|---|---|---|
| RNF-01 | Seguridad | Autenticación obligatoria | Verificar que ninguna operación protegida continúe sin contexto de autenticación válido. | Alta | UC-09, RF-01 | Propuesto |
| RNF-02 | Seguridad multi-tenant | Aislamiento entre tenants | Revisar que ningún documento de otro tenant pueda listarse, visualizarse, descargarse, actualizarse o archivarse. | Alta | UC-01 a UC-08 | Propuesto |
| RNF-03 | Autorización | Control de acceso por rol | Revisar que solo `Admin` realice publicación, actualización de versión y archivado, y que la lectura respete los roles permitidos. | Alta | UC-05, UC-06, UC-07, UC-08 | Propuesto |
| RNF-04 | Confidencialidad | Respuestas y datos seguros | Confirmar que los rechazos no expongan credenciales, JWT, rutas internas, contenido no autorizado ni metadatos sensibles. | Alta | UC-03, UC-04, UC-09, UC-10 | Propuesto |
| RNF-05 | Rendimiento | Tiempo de respuesta de consulta | Propuesto académico: en entorno controlado, 95% de consultas de listado deben completarse en menos de 2 segundos con hasta 100 registros autorizados. | Media | UC-01, UC-02 | Propuesto |
| RNF-06 | Robustez | Manejo consistente de fallos | Verificar que un fallo de almacenamiento o persistencia no confirme operaciones incompletas. | Alta | UC-03, UC-04, UC-05, UC-07, UC-08 | Propuesto |
| RNF-07 | Mantenibilidad | Desacoplamiento del almacenamiento | Revisar que la lógica de alto nivel dependa de una abstracción de almacenamiento y no de una implementación concreta. | Media | UC-05, UC-07 | Propuesto |
| RNF-08 | Trazabilidad | Registro conceptual de cambios | Verificar que publicación y versiones conserven información conceptual de tenant, versión, responsable y fecha. | Alta | UC-05, UC-07 | Propuesto |

## 7. Criterios de aceptación funcionales

### CA-RF-01-01 — Contexto válido

- **Dado** un usuario autenticado con tenant válido y roles asignados;
- **Cuando** solicita una operación documental protegida;
- **Entonces** el módulo puede continuar la operación usando el contexto de control de acceso existente del HIS.

### CA-RF-01-02 — Contexto inválido

- **Dado** un contexto de autenticación inválido, tenant faltante, tenant inexistente o desajuste usuario-tenant;
- **Cuando** se solicita una operación documental protegida;
- **Entonces** la operación se rechaza sin exponer información documental.

### CA-RF-02-01 — Lista autorizada

- **Dado** un usuario autenticado con uno o más roles lectores;
- **Cuando** consulta la documentación disponible;
- **Entonces** solo se muestran documentos activos del mismo tenant que coinciden con al menos uno de sus roles.

### CA-RF-02-02 — Estado vacío

- **Dado** un contexto válido sin documentos activos accesibles;
- **Cuando** el usuario consulta la documentación disponible;
- **Entonces** el módulo devuelve un estado vacío seguro sin exponer documentos de otros roles o tenants.

### CA-RF-03-01 — Búsqueda sobre resultados autorizados

- **Dado** una lista documental ya autorizada;
- **Cuando** el usuario aplica una búsqueda o filtro conceptual;
- **Entonces** el resultado se acota únicamente dentro del conjunto autorizado.

### CA-RF-04-01 — Visualización autorizada

- **Dado** un documento activo del mismo tenant cuyos roles permitidos intersectan con los roles del usuario;
- **Cuando** el usuario solicita la visualización;
- **Entonces** el contenido del documento puede mostrarse.

### CA-RF-04-02 — Visualización rechazada

- **Dado** un documento inexistente, archivado, de otro tenant o restringido por rol;
- **Cuando** el usuario solicita la visualización;
- **Entonces** el acceso se rechaza sin revelar contenido protegido.

### CA-RF-05-01 — Descarga autorizada

- **Dado** un documento activo y autorizado en el mismo tenant;
- **Cuando** el usuario solicita la descarga;
- **Entonces** el archivo puede entregarse tras revalidar el acceso.

### CA-RF-06-01 — Publicación por Admin

- **Dado** un `Admin` autenticado dentro de un tenant válido;
- **Cuando** se envía información documental válida y roles lectores;
- **Entonces** el módulo propuesto puede registrar la publicación dentro de ese tenant.

### CA-RF-06-02 — Publicación rechazada para no-Admin

- **Dado** un usuario autenticado sin el rol `Admin`;
- **Cuando** intenta publicar un documento;
- **Entonces** la operación se deniega.

### CA-RF-07-01 — Roles lectores seleccionados

- **Dado** un `Admin` preparando una publicación válida;
- **Cuando** selecciona uno o más roles lectores existentes;
- **Entonces** la visibilidad del documento se asocia con esos roles.

### CA-RF-08-01 — Información inválida

- **Dado** una publicación o actualización de versión con información conceptual faltante o inválida;
- **Cuando** se valida la información;
- **Entonces** la operación no se confirma y se reportan los problemas corregibles.

### CA-RF-09-01 — Nueva versión

- **Dado** un `Admin` autenticado y un documento existente en el tenant activo;
- **Cuando** se presenta una nueva versión válida;
- **Entonces** el módulo registra la nueva versión sin tratarla como un documento de otro tenant.

### CA-RF-10-01 — Archivo lógico

- **Dado** un `Admin` autenticado y un documento existente en el tenant activo;
- **Cuando** se confirma la acción de archivar;
- **Entonces** el documento queda excluido de la consulta normal sin afirmar una eliminación física.

## 8. Criterios de aceptación no funcionales

### CA-RNF-01-01 — Operación protegida

- **Dado** una operación documental protegida;
- **Cuando** no existe un contexto de autenticación válido;
- **Entonces** la operación no debe continuar.

### CA-RNF-02-01 — Rechazo entre tenants

- **Dado** un documento perteneciente a otro tenant;
- **Cuando** el usuario actual intenta listarlo, visualizarlo, descargarlo, actualizarlo o archivarlo;
- **Entonces** la operación debe rechazarse.

### CA-RNF-03-01 — Rol insuficiente

- **Dado** un usuario autenticado que no posee el rol `Admin`;
- **Cuando** intenta publicar, actualizar una versión o archivar un documento;
- **Entonces** la operación no debe completarse.

### CA-RNF-04-01 — Mensaje seguro

- **Dado** una operación documental rechazada;
- **Cuando** el sistema prepara la respuesta;
- **Entonces** no debe exponer JWT, credenciales, rutas internas, metadatos no autorizados ni contenido documental no autorizado.

### CA-RNF-05-01 — Objetivo de rendimiento

- **Dado** una implementación y un entorno controlado de prueba;
- **Cuando** se mida el desempeño de las consultas de listado;
- **Entonces** la verificación documentada deberá revisar el objetivo propuesto de 95% de consultas dentro de 2 segundos para hasta 100 registros autorizados.

### CA-RNF-06-01 — Fallo sin confirmación falsa

- **Dado** un fallo de almacenamiento o persistencia;
- **Cuando** la operación documental no se completa por esa causa;
- **Entonces** no debe producirse una confirmación exitosa.

### CA-RNF-07-01 — Sustitución del mecanismo de almacenamiento

- **Dado** una futura implementación de almacenamiento;
- **Cuando** se sustituya mediante una abstracción;
- **Entonces** la lógica de alto nivel del caso de uso de publicación no debe requerir cambios.

### CA-RNF-08-01 — Datos mínimos de trazabilidad

- **Dado** una publicación o actualización de versión futura;
- **Cuando** se registre conceptualmente la información de cambios;
- **Entonces** debería conservar, al menos, el tenant, la versión, el administrador responsable y la fecha relevante.

## 9. Matriz de trazabilidad

| Caso de uso | Requisito funcional | Criterios de aceptación funcionales | RNF relacionados | Criterios RNF relacionados | Resultado esperado |
|---|---|---|---|---|---|
| UC-01 | RF-02 | CA-RF-02-01, CA-RF-02-02 | RNF-01, RNF-02, RNF-03, RNF-05 | CA-RNF-01-01, CA-RNF-02-01, CA-RNF-03-01, CA-RNF-05-01 | Lista autorizada o estado vacío seguro |
| UC-02 | RF-03 | CA-RF-03-01 | RNF-02, RNF-03, RNF-05 | CA-RNF-02-01, CA-RNF-03-01, CA-RNF-05-01 | Filtrado solo dentro del conjunto autorizado |
| UC-03 | RF-04 | CA-RF-04-01, CA-RF-04-02 | RNF-01, RNF-02, RNF-03, RNF-04, RNF-06 | CA-RNF-01-01, CA-RNF-02-01, CA-RNF-03-01, CA-RNF-04-01, CA-RNF-06-01 | Visualización autorizada o rechazo seguro |
| UC-04 | RF-05 | CA-RF-05-01 | RNF-01, RNF-02, RNF-03, RNF-04, RNF-06 | CA-RNF-01-01, CA-RNF-02-01, CA-RNF-03-01, CA-RNF-04-01, CA-RNF-06-01 | Descarga autorizada o rechazo seguro |
| UC-05 | RF-06 | CA-RF-06-01, CA-RF-06-02 | RNF-01, RNF-02, RNF-03, RNF-04, RNF-06, RNF-07, RNF-08 | CA-RNF-01-01, CA-RNF-02-01, CA-RNF-03-01, CA-RNF-04-01, CA-RNF-06-01, CA-RNF-07-01, CA-RNF-08-01 | Publicación permitida solo para `Admin` y sin falsos positivos |
| UC-06 | RF-07 | CA-RF-07-01 | RNF-02, RNF-03, RNF-08 | CA-RNF-02-01, CA-RNF-03-01, CA-RNF-08-01 | Visibilidad asociada a roles lectores válidos |
| UC-07 | RF-09 | CA-RF-09-01 | RNF-01, RNF-02, RNF-03, RNF-06, RNF-07, RNF-08 | CA-RNF-01-01, CA-RNF-02-01, CA-RNF-03-01, CA-RNF-06-01, CA-RNF-07-01, CA-RNF-08-01 | Nueva versión registrada sin cruzar tenants |
| UC-08 | RF-10 | CA-RF-10-01 | RNF-01, RNF-02, RNF-03, RNF-06, RNF-08 | CA-RNF-01-01, CA-RNF-02-01, CA-RNF-03-01, CA-RNF-06-01, CA-RNF-08-01 | Archivo lógico sin eliminación física declarada |
| UC-09 | RF-01 | CA-RF-01-01, CA-RF-01-02 | RNF-01, RNF-02, RNF-03, RNF-04 | CA-RNF-01-01, CA-RNF-02-01, CA-RNF-03-01, CA-RNF-04-01 | Contexto de acceso autorizado o rechazo seguro |
| UC-10 | RF-08 | CA-RF-08-01 | RNF-04, RNF-06, RNF-08 | CA-RNF-04-01, CA-RNF-06-01, CA-RNF-08-01 | Información válida o corrección solicitada |

### Cobertura de requisitos funcionales

| RF | Criterios de aceptación |
|---|---|
| RF-01 | CA-RF-01-01, CA-RF-01-02 |
| RF-02 | CA-RF-02-01, CA-RF-02-02 |
| RF-03 | CA-RF-03-01 |
| RF-04 | CA-RF-04-01, CA-RF-04-02 |
| RF-05 | CA-RF-05-01 |
| RF-06 | CA-RF-06-01, CA-RF-06-02 |
| RF-07 | CA-RF-07-01 |
| RF-08 | CA-RF-08-01 |
| RF-09 | CA-RF-09-01 |
| RF-10 | CA-RF-10-01 |

### Cobertura de requisitos no funcionales

| RNF | Criterios de aceptación |
|---|---|
| RNF-01 | CA-RNF-01-01 |
| RNF-02 | CA-RNF-02-01 |
| RNF-03 | CA-RNF-03-01 |
| RNF-04 | CA-RNF-04-01 |
| RNF-05 | CA-RNF-05-01 |
| RNF-06 | CA-RNF-06-01 |
| RNF-07 | CA-RNF-07-01 |
| RNF-08 | CA-RNF-08-01 |

### Cobertura de casos de uso

| UC | RF asociado | Estado |
|---|---|---|
| UC-01 | RF-02 | Mapeado |
| UC-02 | RF-03 | Mapeado |
| UC-03 | RF-04 | Mapeado |
| UC-04 | RF-05 | Mapeado |
| UC-05 | RF-06 | Mapeado |
| UC-06 | RF-07 | Mapeado |
| UC-07 | RF-09 | Mapeado |
| UC-08 | RF-10 | Mapeado |
| UC-09 | RF-01 | Mapeado |
| UC-10 | RF-08 | Mapeado |

## 10. Verificación de cobertura

- Todos los RF desde `RF-01` hasta `RF-10` tienen al menos un criterio de aceptación funcional.
- Todos los RNF desde `RNF-01` hasta `RNF-08` tienen al menos un criterio de aceptación no funcional.
- Todos los casos de uso desde `UC-01` hasta `UC-10` están trazados.
- La trazabilidad conserva la separación entre lo verificado en el repositorio y lo propuesto para ASII-24.

## 11. Supuestos, riesgos y pendientes

- Los permisos finales de implementación permanecen indefinidos durante esta semana.
- El mecanismo final de almacenamiento documental permanece indefinido.
- El objetivo de rendimiento de `RNF-05` es académico y aún no está verificado.
- El contrato API final pertenece a una semana posterior.
- La implementación y las pruebas funcionales pertenecen a semanas posteriores.
- La validación de seguridad futura deberá cubrir roles, aislamiento entre tenants e información sensible.
- La trazabilidad documentada es la base permitida para refinar los requisitos posteriores.

## 12. Límites de la Semana 2

Esta evidencia se limita al análisis y diseño documental del módulo ASII-24.

No define rutas, métodos HTTP, payloads, contratos OpenAPI, colecciones Postman, esquemas de base de datos, código de aplicación, ni ejemplos SOLID.

No modifica la base aprobada de la Semana 1.
