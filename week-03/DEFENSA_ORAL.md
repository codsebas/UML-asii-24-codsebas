# Defensa oral - Semana 3

## Preguntas y respuestas

### 1. Que es un monolito?

Es una aplicacion donde las capas y funciones conviven en un mismo despliegue y comparten el mismo proceso de ejecucion.

### 2. Por que esto es un micro-monolito educativo?

Porque es una version pequena, acotada y didactica de un monolito, con alcance reducido y capas claras para explicar arquitectura y reglas.

### 3. Por que se separaron las capas?

Para aislar responsabilidades, facilitar pruebas y evitar que la logica de negocio dependa de HTTP o de PDO.

### 4. Diferencia entre Presentation y Application.

Presentation recibe la peticion y muestra la respuesta. Application coordina el caso de uso y decide que hacer con los datos.

### 5. Diferencia entre Application y Domain.

Application orquesta. Domain contiene las reglas y el modelo que no deben depender de infraestructura.

### 6. Diferencia entre Domain y Persistence.

Domain define el contrato y las reglas. Persistence implementa el acceso real a la base de datos usando PDO.

### 7. Por que usar sentencias preparadas?

Para evitar inyeccion SQL y mantener consultas seguras y parametrizadas.

### 8. Que hace el Repository?

Oculta la forma concreta de guardar y leer documentos, permitiendo que la logica de negocio trabaje con una abstraccion estable.

### 9. Por que se rechazan roles no autorizados?

Porque la regla central exige que solo los roles incluidos en la visibilidad del documento puedan consultarlo.

### 10. Como se cambia una regla en vivo?

Se modifica primero el modelo o la validacion del dominio, luego se ajustan los casos de uso, pruebas y documentacion.

### 11. Como las pruebas demuestran el comportamiento?

Cada prueba ejecuta un caso concreto y verifica que el resultado esperado ocurra, tanto en el camino feliz como en los errores.

### 12. Una limitacion y una mejora futura.

Limitacion: no hay renderizado de PlantUML en este entorno. Mejora futura: agregar integracion automatica de diagramas y una capa web mas completa.
