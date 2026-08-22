# 02. Arquitectura y decisiones

## Arquitectura

- Presentation: front controller y respuestas JSON;
- Application: casos de uso;
- Domain: Document y reglas;
- Persistence: SQLiteDocumentRepository con PDO.

## Decisiones

- usar SQLite para simplificar el entorno local;
- usar un documento como agregado principal;
- separar roles autorizados en tabla relacionada;
- usar excepciones de dominio para validar reglas;
- mantener el front controller pequeno.
