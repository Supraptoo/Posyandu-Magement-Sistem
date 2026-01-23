<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "posyandu_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Fixing cache table...\n";
    
    // Buat tabel cache yang benar
    $sql = "CREATE TABLE IF NOT EXISTS cache (
        `key` VARCHAR(255) NOT NULL,
        `value` MEDIUMTEXT NOT NULL,
        expiration INT NOT NULL,
        PRIMARY KEY (`key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "✓ Cache table created\n";
    
    // Cek dan buat tabel session jika belum ada
    $sql = "CREATE TABLE IF NOT EXISTS sessions (
        id VARCHAR(255) NOT NULL,
        user_id BIGINT UNSIGNED NULL,
        ip_address VARCHAR(45) NULL,
        user_agent TEXT NULL,
        payload LONGTEXT NOT NULL,
        last_activity INT NOT NULL,
        PRIMARY KEY (id),
        INDEX sessions_user_id_index (user_id),
        INDEX sessions_last_activity_index (last_activity)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "✓ Sessions table checked/created\n";
    
    // Cek dan buat tabel password_reset_tokens jika belum ada
    $sql = "CREATE TABLE IF NOT EXISTS password_reset_tokens (
        email VARCHAR(255) NOT NULL,
        token VARCHAR(255) NOT NULL,
        created_at TIMESTAMP NULL,
        PRIMARY KEY (email)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "✓ Password reset tokens table checked/created\n";
    
    echo "\n✅ Cache tables fixed successfully!\n";
    
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
