# Informe tecnico - ASII-24 Semana 3

## 1. Portada

- Estudiante: Albino Sebastian Rosales Ruano
- GitHub: `codsebas`
- Asignacion: ASII-24
- Modulo oficial: Contratos API: OpenAPI/Postman y documentacion tecnica
- Adaptacion: Centro de documentacion y manuales por rol

## 2. Indice

1. Introduccion
2. Descripcion de la asignacion
3. Consigna individual
4. Objetivos
5. Arquitectura
6. Responsabilidades por capa
7. Reglas de dominio
8. Implementacion
9. Persistencia y PDO
10. Diagramas UML
11. Pruebas
12. Evidencia Git
13. Declaracion de IA
14. Limitaciones
15. Conclusion
16. Bibliografia

## 3. Introduccion

Esta semana presenta una version ejecutable y documentada de un micro-monolito educativo orientado a la publicacion y consulta de documentacion tecnica diferenciada por rol.

## 4. Descripcion de la asignacion

La asignacion oficial trabaja contratos de API, OpenAPI/Postman y documentacion tecnica. Para esta evidencia individual se adapto el tema hacia un centro de documentacion y manuales por rol, manteniendo la finalidad tecnica y academica.

## 5. Consigna individual

Publicar y consultar documentos tecnicos ficticios, asignar roles autorizados, listar visibilidad por rol, permitir consulta solo a roles permitidos y manejar errores de persistencia sin exponer detalles internos.

## 6. Objetivos

- aplicar arquitectura por capas;
- usar PHP 8.2+ vanilla;
- separar configuracion del codigo;
- usar PDO con prepared statements;
- documentar y probar el comportamiento.

## 7. Arquitectura

La solucion se organiza en Presentation, Application, Domain y Persistence. Presentation recibe la solicitud HTTP y responde en JSON. Application coordina los casos de uso. Domain concentra entidad, reglas y excepciones. Persistence implementa el repositorio con PDO.

## 8. Responsabilidades por capa

- Presentation: parsear request, invocar casos de uso, renderizar respuestas.
- Application: validar el flujo operativo y coordinar repositorio y reglas.
- Domain: representar documento, roles autorizados y validaciones centrales.
- Persistence: guardar y consultar documentos usando SQLite y PDO.

## 9. Reglas de dominio

- el titulo es obligatorio;
- el codigo es obligatorio y unico;
- el resumen/descripcion es obligatorio;
- el contenido es obligatorio;
- debe existir al menos un rol autorizado;
- el estado es explicito;
- solo documentos `published` aparecen en busquedas normales;
- un rol no autorizado no puede consultar el detalle.

## 10. Implementacion

Se implementaron los casos de uso `PublishDocument`, `ListDocumentsByRole` y `GetDocumentForRole`, un repositorio PDO para SQLite, un front controller simple y una bateria de pruebas en PHP nativo.

## 11. Persistencia y PDO

La persistencia usa sentencias preparadas para evitar concatenacion insegura de SQL. El esquema separa documentos y roles autorizados en dos tablas relacionadas.

## 12. Diagramas UML

Fuentes editables:

- `docs/diagrams/source/use-case.puml`
- `docs/diagrams/source/class-diagram.puml`
- `docs/diagrams/source/sequence.puml`

El render SVG no pudo generarse en este entorno porque `plantuml` no esta disponible.

## 13. Pruebas

Se cubren:

- caso feliz de publicacion y consulta autorizada;
- regla de dominio para roles vacios;
- denegacion por rol no autorizado;
- persistencia contra base de prueba;
- error de persistencia con doble controlado.

## 14. Evidencia Git

- Commit inicial de documentacion: `[pendiente]`
- Commit de dominio y persistencia: `[pendiente]`
- Commit de presentacion y pruebas: `[pendiente]`
- Commit de diagramas y cierre: `[pendiente]`

## 15. Declaracion de IA

Ver `week-03/DECLARACION_IA.md`.

## 16. Limitaciones

- no hay renderizado automatico de PlantUML;
- se usa SQLite local;
- no se modelan usuarios reales ni datos clinicos.

## 17. Conclusion

La evidencia demuestra la separacion de capas, la aplicacion de reglas de negocio y la consulta segura de documentos segun rol.

## 18. Bibliografia

- Documentacion oficial de PHP 8.2
- Documentacion oficial de PDO
- Documentacion de SQLite
- Guia oficial de PlantUML
