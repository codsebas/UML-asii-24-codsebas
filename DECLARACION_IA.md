# DECLARACIÓN DE USO DE INTELIGENCIA ARTIFICIAL

## 1. Identificación

| Campo                       | Información                                                                                              |
| --------------------------- | -------------------------------------------------------------------------------------------------------- |
| Estudiante                  | **Albino Sebastián Rosales Ruano**                                                                       |
| GitHub                      | `codsebas`                                                                                               |
| Asignación                  | **ASII-24**                                                                                              |
| Módulo oficial              | **Contratos API: OpenAPI/Postman y documentación técnica**                                               |
| Actividad                   | Modelado del proceso de publicación y consulta de documentación y manuales diferenciados por rol         |
| Herramienta de IA utilizada | **ChatGPT, OpenCode**                                                                                    |
| Uso principal               | Apoyo para análisis, estructuración, revisión y mejora progresiva de la documentación y de los diagramas |

---

## 2. Declaración general

Para el desarrollo de esta asignación utilicé inteligencia artificial como
herramienta de apoyo durante el proceso de análisis y documentación.

El trabajo se realizó de forma **conjunta e iterativa**. Yo planteaba las ideas,
decisiones, dudas y propuestas relacionadas con cada consigna de la actividad, y
la herramienta de inteligencia artificial me ayudaba a organizarlas,
estructurarlas, revisar su coherencia y convertirlas en una propuesta documental
más clara.

La IA no recibió simplemente la tarea para resolverla de principio a fin de
forma autónoma. El proceso se desarrolló por etapas, revisando cada parte antes
de continuar con la siguiente.

---

## 3. Forma de trabajo utilizada

La dinámica seguida durante la actividad fue principalmente la siguiente:

1. Yo presentaba la consigna o el problema específico que debía resolver.
2. Explicaba mi interpretación inicial, las decisiones que consideraba correctas
   y las dudas que tenía sobre el alcance.
3. La IA analizaba la propuesta y ayudaba a organizarla de acuerdo con los
   requisitos de la actividad.
4. Revisábamos conjuntamente actores, alcance, reglas, casos de uso, flujos,
   excepciones, mensajes y trazabilidad.
5. Cuando se detectaba una inconsistencia, una ambigüedad o una solución poco
   conveniente, se corregía antes de continuar.
6. Se avanzaba en orden progresivo y correctivo hasta obtener una versión que
   cumpliera con la consigna.
7. Antes de incorporar los cambios al repositorio, revisaba personalmente los
   archivos, diagramas, rutas, resultados y estructura Git.

Por lo tanto, la IA fue utilizada como una herramienta de apoyo para
**razonamiento, revisión y redacción**, mientras que las decisiones finales y la
aceptación de los cambios fueron realizadas por mí.

En la ruta [/week-01/evidence-prompts/](/week-01/evidence-prompts/) se encuentra un resumen
de los prompts utilizados, desarrollados para con esta asignación.

---

## 4. Partes en las que se utilizó IA

La inteligencia artificial fue utilizada para apoyar principalmente las
siguientes actividades:

- interpretación de la consigna individual de ASII-24;
- comprensión del flujo de trabajo con Git y worktrees;
- delimitación del alcance del módulo adaptado;
- identificación y organización de actores;
- estructuración del catálogo de casos de uso;
- revisión de las relaciones entre casos de uso;
- diseño conceptual del diagrama de casos de uso;
- diseño del flujo del diagrama de actividad;
- definición de decisiones, excepciones y resultados;
- diseño conceptual del diagrama de secuencia;
- definición de participantes, mensajes, validaciones y respuestas;
- creación y revisión de identificadores `UC-*`, `ACT-*` y `SEQ-*`;
- construcción de la matriz de trazabilidad;
- preparación de código PlantUML para los diagramas;
- revisión de la estructura de los documentos Markdown;
- apoyo para organizar commits y evidencia Git;
- revisión de errores de formato detectados por herramientas como
  `markdownlint`;
- preparación y mejora de documentación complementaria del repositorio.

---

## 5. Uso de agentes de IA

También se utilizó **OpenCode** como agente de apoyo dentro del worktree del
proyecto.

Para evitar modificaciones no controladas, las instrucciones entregadas al
agente se prepararon previamente y se utilizaron con restricciones claras.

Entre las restricciones aplicadas estuvieron:

- trabajar únicamente dentro de las rutas autorizadas;
- no modificar código de backend o frontend;
- no crear endpoints, migraciones ni componentes no solicitados;
- no inventar funcionalidades existentes;
- distinguir entre capacidades reales del sistema y diseño propuesto;
- no ejecutar operaciones Git;
- detenerse entre fases para permitir revisión manual;
- mantener los identificadores y reglas previamente acordados;
- no continuar con actividades de semanas posteriores.

Los prompts relevantes utilizados para estas ejecuciones se conservan como
evidencia dentro del repositorio cuando corresponde.

---

## 6. Partes aceptadas y modificadas

Las propuestas generadas con apoyo de IA no fueron aceptadas
automáticamente.

Durante el desarrollo se realizaron ajustes manuales y decisiones propias, entre
ellas:

- selección del rol `Admin` como actor responsable de publicación y
  administración;
- mantenimiento de los roles reales existentes en el HIS;
- decisión de conservar el aislamiento por `tenant`;
- organización de la evidencia por semanas;
- separación del trabajo en commits pequeños y revisables;
- cambio de la estrategia de visualización de diagramas;
- decisión final de utilizar PlantUML como fuente editable y SVG como formato
  visual para GitHub;
- modificación de rutas y nombres de archivos;
- corrección de enlaces Markdown;
- revisión y corrección de inconsistencias detectadas durante el proceso;
- validación del contenido antes de realizar commits y push.

Cuando una propuesta no se ajustaba a la consigna, a las limitaciones del
repositorio o a la forma en que quería organizar la entrega, se descartaba o se
modificaba.

---

## 7. Validación humana

La validación final de la evidencia fue realizada manualmente.

Antes de incorporar los cambios se revisaron, según correspondía:

- contenido de los documentos Markdown;
- coherencia entre actores y casos de uso;
- consistencia entre diagramas;
- existencia de decisiones y excepciones;
- relación entre participantes y mensajes;
- trazabilidad entre `UC-*`, `ACT-*` y `SEQ-*`;
- visualización de los diagramas;
- rutas relativas utilizadas en Markdown;
- estructura de carpetas;
- estado de Git;
- commits creados;
- archivos incluidos en cada commit;
- ausencia de credenciales, tokens o datos reales.

También se utilizaron comandos y herramientas de validación cuando fue
necesario para detectar problemas de formato o consistencia.

---

## 8. Responsabilidad sobre el contenido

Reconozco que el uso de inteligencia artificial no sustituye mi responsabilidad
sobre la actividad.

El contenido entregado fue revisado por mí y debo ser capaz de:

- explicar las decisiones tomadas;
- justificar los actores y reglas utilizadas;
- explicar cada diagrama UML;
- describir los flujos principales y alternativos;
- explicar la trazabilidad entre los artefactos;
- realizar modificaciones si se solicitan durante la defensa;
- responder preguntas relacionadas con el trabajo sin depender de la
  herramienta de IA.

La versión incluida en el repositorio representa el resultado de un proceso de
trabajo asistido, revisado y aceptado por mí.

---

## 9. Transparencia

El uso de inteligencia artificial se declara de forma explícita para mantener
trazabilidad y transparencia académica.

No se utilizó IA con el propósito de ocultar autoría, generar evidencia falsa,
introducir datos reales o evitar la comprensión de los contenidos.

Los prompts y artefactos relevantes conservados en el repositorio permiten
revisar cómo se utilizó la herramienta durante el desarrollo de la actividad.

---

## 10. Declaración final

Declaro que utilicé herramientas de inteligencia artificial como apoyo durante
la realización de la asignación **ASII-24**, principalmente para analizar,
estructurar, revisar y mejorar progresivamente mis propuestas.

El proceso fue iterativo: **yo planteaba las ideas y decisiones iniciales, la IA
me ayudaba a desarrollarlas y revisarlas, y posteriormente evaluaba,
corregía y aprobaba el resultado antes de incorporarlo a la entrega**.

Asumo la responsabilidad académica sobre el contenido presentado y sobre su
explicación durante la defensa individual.

---

**Albino Sebastián Rosales Ruano**  
GitHub: `codsebas`  
Asignación: **ASII-24**
