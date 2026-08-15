# ASII-24 — Ejemplo SOLID: inversión de dependencias

## 1. Identificación y propósito

| Campo | Valor |
|---|---|
| Estudiante | ALBINO SEBASTIAN ROSALES RUANO |
| GitHub | `codsebas` |
| Módulo oficial | Contratos API: OpenAPI/Postman y documentación técnica |
| Actividad adaptada | Centro de documentación y manuales por rol |
| Semana | 2 |
| Principio SOLID | Dependency Inversion Principle |

Este documento presenta un ejemplo conceptual de inversión de dependencias aplicado al módulo ASII-24. No describe implementación real ni crea artefactos técnicos de ejecución.

## 2. Fuente consultada

Fuente base consultada: `MVP Cluster. "Principios básicos del diseño de software". https://mvpcluster.com/diseno-de-software-2/`

La fuente explica que el software evoluciona con cambios y que los principios SOLID ayudan a reducir el impacto y el costo de mantenimiento. En particular, la inversión de dependencias propone que las clases de alto nivel no dependan directamente de clases de bajo nivel, sino de abstracciones.

## 3. Concepto del principio

La inversión de dependencias establece que:

- los módulos de alto nivel no deben depender de módulos concretos de bajo nivel;
- ambos deben depender de abstracciones;
- las abstracciones no deben depender de detalles;
- los detalles deben depender de abstracciones.

En un flujo documental, esto permite que la lógica de publicación se mantenga estable aunque cambie el mecanismo de almacenamiento.

## 4. Motivo de selección para ASII-24

ASII-24 necesita modelar publicación y actualización documental sin fijar un almacenamiento final durante la Semana 2.

Este principio encaja con:

- RNF-07, porque pide desacoplar el almacenamiento;
- RF-06, porque la publicación no debe quedar atada a una tecnología concreta;
- RF-09, porque la actualización de versión también depende de la forma de persistir o referenciar el documento;
- UC-05, como caso de uso principal de publicación;
- UC-07, como caso de uso de actualización de versión.

## 5. Diseño problemático

Un diseño acoplado haría que el caso de uso de publicación conozca y use directamente una clase concreta de almacenamiento, por ejemplo almacenamiento local o una referencia externa específica.

Eso genera un problema: si cambia el mecanismo de guardado, también debe cambiar la lógica principal de publicación.

## 6. Diseño propuesto

La solución conceptual separa responsabilidades de esta forma:

```text
PublishDocumentUseCase
        |
        v
DocumentStorageContract
     /            \
    v              v
LocalDocumentStorage  ExternalReferenceStorage
```

El caso de uso de alto nivel depende de `DocumentStorageContract`.

Las implementaciones concretas satisfacen la abstracción sin invadir la lógica principal.

## 7. Pseudocódigo conceptual

**Pseudocódigo conceptual no ejecutable y no implementado en el repositorio.**

```php
interface DocumentStorageContract
{
    public function store(DocumentContent $content): StoredDocumentReference;
}

final class PublishDocumentUseCase
{
    public function __construct(
        private DocumentStorageContract $storage
    ) {
    }

    public function execute(DocumentDraft $draft): PublicationResult
    {
        $storedReference = $this->storage->store($draft->content());

        return PublicationResult::from($draft, $storedReference);
    }
}

final class LocalDocumentStorage implements DocumentStorageContract
{
    public function store(DocumentContent $content): StoredDocumentReference
    {
        // Comportamiento conceptual de almacenamiento local.
    }
}

final class ExternalReferenceStorage implements DocumentStorageContract
{
    public function store(DocumentContent $content): StoredDocumentReference
    {
        // Comportamiento conceptual de referencia externa.
    }
}
```

## 8. Responsabilidades de los elementos

- `PublishDocumentUseCase`: orquesta la publicación y decide el flujo de alto nivel.
- `DocumentStorageContract`: define la abstracción común de almacenamiento.
- `LocalDocumentStorage`: representa un detalle concreto de persistencia local.
- `ExternalReferenceStorage`: representa un detalle concreto de referencia externa.

La inyección por constructor permite que el caso de uso reciba la abstracción sin crear dependencias internas concretas.

## 9. Cumplimiento del principio

Este diseño cumple el principio porque la dependencia principal queda invertida:

- el caso de uso no conoce el detalle de almacenamiento;
- el detalle depende del contrato;
- el contrato permanece estable aunque cambie la implementación.

Eso reduce el acoplamiento y facilita extender el módulo sin modificar la lógica central.

## 10. Relación con RF, RNF y casos de uso

- RNF-07: la lógica de publicación y consulta debe depender de una abstracción de almacenamiento.
- RF-06: la publicación documental puede registrar el contenido sin elegir ahora un proveedor final.
- RF-09: la actualización de versión también puede reutilizar el mismo contrato abstracto.
- UC-05: publicación documental por `Admin`.
- UC-07: actualización de versión por `Admin`.

## 11. Beneficios esperados

- Menor acoplamiento entre publicación y almacenamiento.
- Mayor facilidad para cambiar de mecanismo de persistencia.
- Mejor legibilidad del flujo de alto nivel.
- Mayor testabilidad al poder sustituir el almacenamiento por una implementación falsa.

Un `FakeDocumentStorage` podría devolver referencias controladas para validar el comportamiento del caso de uso sin depender de disco, nube o servicios externos.

## 12. Limitaciones y riesgos

- El ejemplo es conceptual y no representa una implementación ejecutable.
- No se selecciona una tecnología final de almacenamiento.
- No se definen endpoints, payloads, esquemas, código real ni pruebas.
- El valor del diseño depende de que el contrato se mantenga estable en semanas posteriores.

## 13. Conclusión

La inversión de dependencias permite que ASII-24 mantenga estable la lógica de publicación y actualización documental mientras el mecanismo de almacenamiento permanece abierto a cambio.

Este enfoque apoya RNF-07 y preserva el alcance académico de la Semana 2 sin convertir el ejemplo en código real.
