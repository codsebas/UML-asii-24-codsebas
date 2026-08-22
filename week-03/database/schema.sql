PRAGMA foreign_keys = ON;

CREATE TABLE IF NOT EXISTS documents (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code TEXT NOT NULL UNIQUE,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    content TEXT NOT NULL,
    status TEXT NOT NULL,
    created_at TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS document_roles (
    document_id INTEGER NOT NULL,
    role TEXT NOT NULL,
    PRIMARY KEY (document_id, role),
    FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE CASCADE
);
