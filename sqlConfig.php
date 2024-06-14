<?php
include_once('/var/www/dbconn/tyrael.php');

// Function to check if a table exists
function tableExists($pdo, $tableName) {
    try {
        $result = $pdo->query("SELECT 1 FROM $tableName LIMIT 1");
    } catch (Exception $e) {
        return FALSE;
    }
    return $result !== FALSE;
}

// Function to create a table from a .sql file
function createTable($pdo, $filePath) {
    $sql = file_get_contents($filePath);
    try {
        $pdo->exec($sql);
        echo "Table created successfully from $filePath\n";
    } catch (PDOException $e) {
        echo "Error creating table: " . $e->getMessage() . "\n";
    }
}

// Paths to the .sql files
$projectsTableSQL = '/var/www/html/quest/sch/sql/create_projects_table.sql';
$stagesTableSQL = '/var/www/html/quest/sch/sql/project_stages.sql';
$documentsTableSQL = '/var/www/html/quest/sch/sql/project_documents.sql';

// Check and create projects table
if (!tableExists($pdo, 'projects')) {
    createTable($pdo, $projectsTableSQL);
} else {
    echo "Table 'projects' already exists\n";
}

// Check and create project_stages table
if (!tableExists($pdo, 'project_stages')) {
    createTable($pdo, $stagesTableSQL);
} else {
    echo "Table 'project_stages' already exists\n";
}

// Check and create project_documents table
if (!tableExists($pdo, 'project_documents')) {
    createTable($pdo, $documentsTableSQL);
} else {
    echo "Table 'project_documents' already exists\n";
}
?>
