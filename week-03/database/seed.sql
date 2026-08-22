INSERT INTO documents (code, title, description, content, status, created_at) VALUES
('DOC-OPENAPI-001', 'Guia de contratos API', 'Resumen del contrato tecnico para integraciones', 'Este documento explica como versionar y consumir contratos API.', 'published', '2026-08-21T08:00:00+00:00'),
('DOC-POSTMAN-002', 'Coleccion de Postman', 'Manual de uso para validar peticiones REST', 'Incluye ejemplos de variables de entorno, headers y ejecucion de colecciones.', 'published', '2026-08-21T08:10:00+00:00'),
('DOC-REVISION-003', 'Revision tecnica interna', 'Checklist para aprobacion de cambios', 'Contiene pasos de revision, aprobacion y seguimiento de incidencias.', 'draft', '2026-08-21T08:20:00+00:00');

INSERT INTO document_roles (document_id, role) VALUES
(1, 'Admin'),
(1, 'Medico'),
(1, 'Enfermera'),
(2, 'Admin'),
(2, 'TecnicoLab'),
(2, 'Recepcionista'),
(3, 'Admin');
