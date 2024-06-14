CREATE TABLE project_documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT,
    url TEXT,
    label VARCHAR(255),
    FOREIGN KEY (project_id) REFERENCES projects(id)
);
