CREATE TABLE project_stages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT,
    label VARCHAR(255),
    field_key VARCHAR(255),
    type VARCHAR(255),
    value TEXT,
    FOREIGN KEY (project_id) REFERENCES projects(id)
);
