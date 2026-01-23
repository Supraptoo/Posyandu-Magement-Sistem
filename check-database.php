<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "posyandu_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Database: $dbname\n";
    echo "===============\n\n";
    
    // Get all tables
    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Total Tables: " . count($tables) . "\n\n";
    
    foreach ($tables as $table) {
        echo "Table: $table\n";
        
        // Get row count
        $countStmt = $conn->query("SELECT COUNT(*) as count FROM $table");
        $count = $countStmt->fetch(PDO::FETCH_ASSOC);
        
        // Get column info
        $colStmt = $conn->query("DESCRIBE $table");
        $columns = $colStmt->fetchAll(PDO::FETCH_COLUMN);
        
        echo "  Rows: " . $count['count'] . "\n";
        echo "  Columns: " . count($columns) . "\n";
        
        if ($table == 'users') {
            $userStmt = $conn->query("SELECT email, role, status FROM users");
            $users = $userStmt->fetchAll(PDO::FETCH_ASSOC);
            echo "  Users:\n";
            foreach ($users as $user) {
                echo "    - {$user['email']} ({$user['role']}) - {$user['status']}\n";
            }
        }
        
        echo "\n";
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
