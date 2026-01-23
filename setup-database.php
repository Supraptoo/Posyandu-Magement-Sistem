<?php
// Database configuration
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "posyandu_db";

try {
    echo "Setting up database...\n";
    
    // Create connection without database
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Database created\n";
    
    // Use database
    $conn->exec("USE $dbname");
    
    // Drop tables if exists untuk reset
    $tables = ['cache', 'sessions', 'password_reset_tokens', 'profiles', 'users'];
    foreach ($tables as $table) {
        try {
            $conn->exec("DROP TABLE IF EXISTS $table");
        } catch (Exception $e) {
            // Ignore error jika table tidak ada
        }
    }
    
    // Buat tabel users (tanpa kolom nik dulu)
    $sql = "CREATE TABLE users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) UNIQUE,
        email VARCHAR(100) UNIQUE,
        nik VARCHAR(16) UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'bidan', 'kader', 'user') NOT NULL,
        status ENUM('active', 'inactive') DEFAULT 'active',
        last_login_at TIMESTAMP NULL,
        created_by INT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_email (email),
        INDEX idx_nik (nik),
        INDEX idx_role (role)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Users table created\n";
    
    // Buat tabel profiles (tanpa kolom nik dulu)
    $sql = "CREATE TABLE profiles (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT UNIQUE NOT NULL,
        full_name VARCHAR(100) NOT NULL,
        tempat_lahir VARCHAR(50),
        tanggal_lahir DATE,
        jenis_kelamin ENUM('L', 'P') NOT NULL,
        alamat TEXT,
        telepon VARCHAR(15),
        foto VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Profiles table created\n";
    
    // Buat tabel cache
    $sql = "CREATE TABLE cache (
        `key` VARCHAR(255) NOT NULL,
        `value` MEDIUMTEXT NOT NULL,
        expiration INT NOT NULL,
        PRIMARY KEY (`key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Cache table created\n";
    
    // Buat tabel sessions
    $sql = "CREATE TABLE sessions (
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
    echo "✓ Sessions table created\n";
    
    // Buat tabel password_reset_tokens
    $sql = "CREATE TABLE password_reset_tokens (
        email VARCHAR(255) NOT NULL,
        token VARCHAR(255) NOT NULL,
        created_at TIMESTAMP NULL,
        PRIMARY KEY (email)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Password reset tokens table created\n";
    
    // Insert admin user (tanpa nik)
    $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (email, password, role, status, created_by) 
            VALUES ('admin@posyandu.com', '$adminPassword', 'admin', 'active', 1)";
    $conn->exec($sql);
    echo "✓ Admin user inserted\n";
    
    // Tambah kolom nik ke tabel users jika belum ada
    try {
        $sql = "ALTER TABLE users ADD COLUMN IF NOT EXISTS nik VARCHAR(16) UNIQUE AFTER email";
        $conn->exec($sql);
        echo "✓ Added nik column to users table\n";
    } catch (Exception $e) {
        // Kolom mungkin sudah ada
    }
    
    // Update admin user dengan nik
    $sql = "UPDATE users SET nik = '9999999999999999' WHERE email = 'admin@posyandu.com'";
    $conn->exec($sql);
    
    // Insert admin profile (tanpa nik dulu)
    $sql = "INSERT INTO profiles (user_id, full_name, jenis_kelamin, alamat, telepon)
            SELECT id, 'Administrator', 'L', 'Posyandu', '081234567890'
            FROM users WHERE email = 'admin@posyandu.com'";
    $conn->exec($sql);
    echo "✓ Admin profile inserted\n";
    
    // Tambah kolom nik ke tabel profiles jika belum ada
    try {
        $sql = "ALTER TABLE profiles ADD COLUMN IF NOT EXISTS nik VARCHAR(16) AFTER full_name";
        $conn->exec($sql);
        echo "✓ Added nik column to profiles table\n";
    } catch (Exception $e) {
        // Kolom mungkin sudah ada
    }
    
    // Update admin profile dengan nik
    $sql = "UPDATE profiles SET nik = '9999999999999999' WHERE user_id = (SELECT id FROM users WHERE email = 'admin@posyandu.com')";
    $conn->exec($sql);
    
    echo "\n✅ Database setup completed successfully!\n";
    echo "Admin login:\n";
    echo "  Email: admin@posyandu.com\n";
    echo "  Password: admin123\n";
    
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
