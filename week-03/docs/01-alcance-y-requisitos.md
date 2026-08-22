# 01. Alcance y requisitos

## Alcance

El sistema publica y consulta documentacion tecnica ficticia segun roles autorizados.

## Requisito central

Un documento publicado debe definir al menos un rol autorizado. Un rol solo puede consultar un documento si aparece en su lista de visibilidad.

## Requisitos funcionales

- publicar documento;
- asociar roles autorizados;
- listar por rol;
- consultar por id y rol;
- denegar accesos no autorizados;
- mostrar errores de forma segura.

## Requisitos no funcionales

- PHP 8.2+ vanilla;
- arquitectura por capas;
- PDO con sentencias preparadas;
- configuracion separada del codigo;
- pruebas automatizadas;
- datos ficticios.
