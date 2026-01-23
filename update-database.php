<?php
// Database configuration
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "posyandu_db";

try {
    echo "Updating database structure...\n";
    
    // Create connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database: $dbname\n";
    
    // ==================== TABEL UTAMA USERS & PROFILES ====================
    
    // Pastikan tabel users ada dengan struktur lengkap
    $sql = "CREATE TABLE IF NOT EXISTS users (
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
    echo "✓ Users table checked/created\n";
    
    // Update kolom jika perlu
    $columns_to_add = [
        "ADD COLUMN IF NOT EXISTS username VARCHAR(50) UNIQUE AFTER id",
        "ADD COLUMN IF NOT EXISTS email VARCHAR(100) UNIQUE AFTER username",
        "ADD COLUMN IF NOT EXISTS nik VARCHAR(16) UNIQUE AFTER email",
        "ADD COLUMN IF NOT EXISTS role ENUM('admin', 'bidan', 'kader', 'user') NOT NULL AFTER password",
        "ADD COLUMN IF NOT EXISTS status ENUM('active', 'inactive') DEFAULT 'active' AFTER role",
        "ADD COLUMN IF NOT EXISTS last_login_at TIMESTAMP NULL AFTER status",
        "ADD COLUMN IF NOT EXISTS created_by INT NULL AFTER last_login_at"
    ];
    
    foreach ($columns_to_add as $column_sql) {
        try {
            $conn->exec("ALTER TABLE users $column_sql");
        } catch (Exception $e) {
            // Kolom mungkin sudah ada
        }
    }
    
    // Tabel profiles
    $sql = "CREATE TABLE IF NOT EXISTS profiles (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT UNIQUE NOT NULL,
        full_name VARCHAR(100) NOT NULL,
        nik VARCHAR(16),
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
    echo "✓ Profiles table checked/created\n";
    
    // ==================== TABEL KADER ====================
    $sql = "CREATE TABLE IF NOT EXISTS kaders (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT UNIQUE NOT NULL,
        posyandu_id INT,
        jabatan VARCHAR(50),
        tanggal_bergabung DATE,
        status_kader ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Kaders table checked/created\n";
    
    // ==================== TABEL BIDAN ====================
    $sql = "CREATE TABLE IF NOT EXISTS bidans (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT UNIQUE NOT NULL,
        sip VARCHAR(50) UNIQUE,
        spesialisasi VARCHAR(100),
        rumah_sakit VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Bidans table checked/created\n";
    
    // ==================== TABEL PASIEN ====================
    
    // Tabel Balita
    $sql = "CREATE TABLE IF NOT EXISTS balitas (
        id INT PRIMARY KEY AUTO_INCREMENT,
        kode_balita VARCHAR(20) UNIQUE NOT NULL,
        nama_lengkap VARCHAR(100) NOT NULL,
        nik VARCHAR(16) UNIQUE NOT NULL,
        tempat_lahir VARCHAR(50),
        tanggal_lahir DATE NOT NULL,
        jenis_kelamin ENUM('L', 'P') NOT NULL,
        nama_ibu VARCHAR(100),
        nama_ayah VARCHAR(100),
        alamat TEXT,
        berat_lahir DECIMAL(4,2),
        panjang_lahir DECIMAL(4,2),
        created_by INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (created_by) REFERENCES users(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Balitas table checked/created\n";
    
    // Tabel Remaja
    $sql = "CREATE TABLE IF NOT EXISTS remajas (
        id INT PRIMARY KEY AUTO_INCREMENT,
        kode_remaja VARCHAR(20) UNIQUE NOT NULL,
        nama_lengkap VARCHAR(100) NOT NULL,
        nik VARCHAR(16) UNIQUE NOT NULL,
        tempat_lahir VARCHAR(50),
        tanggal_lahir DATE NOT NULL,
        jenis_kelamin ENUM('L', 'P') NOT NULL,
        alamat TEXT,
        sekolah VARCHAR(100),
        kelas VARCHAR(20),
        created_by INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (created_by) REFERENCES users(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Remajas table checked/created\n";
    
    // Tabel Lansia
    $sql = "CREATE TABLE IF NOT EXISTS lansias (
        id INT PRIMARY KEY AUTO_INCREMENT,
        kode_lansia VARCHAR(20) UNIQUE NOT NULL,
        nama_lengkap VARCHAR(100) NOT NULL,
        nik VARCHAR(16) UNIQUE NOT NULL,
        tempat_lahir VARCHAR(50),
        tanggal_lahir DATE NOT NULL,
        jenis_kelamin ENUM('L', 'P') NOT NULL,
        alamat TEXT,
        penyakit_bawaan TEXT,
        created_by INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (created_by) REFERENCES users(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Lansias table checked/created\n";
    
    // ==================== TABEL KUNJUNGAN ====================
    $sql = "CREATE TABLE IF NOT EXISTS kunjungans (
        id INT PRIMARY KEY AUTO_INCREMENT,
        kode_kunjungan VARCHAR(20) UNIQUE NOT NULL,
        pasien_id INT NOT NULL,
        pasien_type ENUM('balita', 'remaja', 'lansia') NOT NULL,
        tanggal_kunjungan DATE NOT NULL,
        jenis_kunjungan ENUM('rutin', 'imunisasi', 'konsultasi', 'pengobatan') NOT NULL,
        keluhan TEXT,
        petugas_id INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (petugas_id) REFERENCES users(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Kunjungans table checked/created\n";
    
    // ==================== TABEL PEMERIKSAAN ====================
    $sql = "CREATE TABLE IF NOT EXISTS pemeriksaans (
        id INT PRIMARY KEY AUTO_INCREMENT,
        kunjungan_id INT UNIQUE NOT NULL,
        tinggi_badan DECIMAL(5,2),
        berat_badan DECIMAL(5,2),
        lingkar_kepala DECIMAL(5,2),
        lingkar_lengan DECIMAL(5,2),
        tekanan_darah VARCHAR(10),
        suhu_badan DECIMAL(4,2),
        detak_jantung INT,
        catatan TEXT,
        pemeriksa_id INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (kunjungan_id) REFERENCES kunjungans(id),
        FOREIGN KEY (pemeriksa_id) REFERENCES users(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Pemeriksaans table checked/created\n";
    
    // ==================== TABEL IMUNISASI ====================
    $sql = "CREATE TABLE IF NOT EXISTS imunisasis (
        id INT PRIMARY KEY AUTO_INCREMENT,
        kunjungan_id INT NOT NULL,
        jenis_imunisasi VARCHAR(50) NOT NULL,
        vaksin VARCHAR(50),
        dosis VARCHAR(20),
        tanggal_imunisasi DATE NOT NULL,
        batch_number VARCHAR(50),
        expiry_date DATE,
        penyelenggara VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (kunjungan_id) REFERENCES kunjungans(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Imunisasis table checked/created\n";
    
    // ==================== TABEL VITAMIN ====================
    $sql = "CREATE TABLE IF NOT EXISTS vitamins (
        id INT PRIMARY KEY AUTO_INCREMENT,
        kunjungan_id INT NOT NULL,
        jenis_vitamin VARCHAR(50) NOT NULL,
        dosis VARCHAR(20),
        tanggal_pemberian DATE NOT NULL,
        catatan TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (kunjungan_id) REFERENCES kunjungans(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Vitamins table checked/created\n";
    
    // ==================== TABEL KONSULTASI ====================
    $sql = "CREATE TABLE IF NOT EXISTS konsultasis (
        id INT PRIMARY KEY AUTO_INCREMENT,
        kunjungan_id INT NOT NULL,
        topik VARCHAR(100),
        keluhan TEXT,
        saran TEXT,
        tindak_lanjut TEXT,
        konsultan_id INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (kunjungan_id) REFERENCES kunjungans(id),
        FOREIGN KEY (konsultan_id) REFERENCES users(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Konsultasis table checked/created\n";
    
    // ==================== TABEL REFERENSI NILAI NORMAL REMAJA ====================
    $sql = "CREATE TABLE IF NOT EXISTS referensi_nilai_remaja (
        id INT PRIMARY KEY AUTO_INCREMENT,
        jenis_pemeriksaan ENUM('imt', 'hemoglobin', 'lila', 'gula_darah') NOT NULL,
        usia_tahun INT NOT NULL,
        jenis_kelamin ENUM('L', 'P') NOT NULL,
        kategori ENUM('kurus', 'normal', 'gemuk', 'rendah', 'tinggi', 'kek', 'normal_gds', 'pra_diabetes', 'diabetes') NOT NULL,
        nilai_min DECIMAL(10,2),
        nilai_max DECIMAL(10,2),
        satuan VARCHAR(20),
        keterangan TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_ref (jenis_pemeriksaan, usia_tahun, jenis_kelamin, kategori),
        INDEX idx_jenis_pemeriksaan (jenis_pemeriksaan),
        INDEX idx_usia (usia_tahun)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Referensi nilai remaja table checked/created\n";
    
    // ==================== TABEL ANALISIS PEMERIKSAAN REMAJA ====================
    $sql = "CREATE TABLE IF NOT EXISTS analisis_pemeriksaan_remaja (
        id INT PRIMARY KEY AUTO_INCREMENT,
        pemeriksaan_id INT NOT NULL,
        remaja_id INT NOT NULL,
        usia_saat_periksa INT,
        jenis_kelamin ENUM('L', 'P'),
        
        -- IMT Analysis
        imt_nilai DECIMAL(5,2),
        imt_kategori ENUM('kurus', 'normal', 'gemuk'),
        
        -- Hemoglobin Analysis
        hemoglobin_nilai DECIMAL(5,2),
        hemoglobin_kategori ENUM('rendah', 'normal', 'tinggi'),
        hemoglobin_satuan VARCHAR(10) DEFAULT 'g/dL',
        
        -- LILA Analysis (khusus perempuan)
        lila_nilai DECIMAL(5,2),
        lila_kategori ENUM('normal', 'kek'),
        lila_satuan VARCHAR(10) DEFAULT 'cm',
        
        -- Gula Darah Analysis
        gula_darah_puasa_nilai DECIMAL(5,2),
        gula_darah_2jam_nilai DECIMAL(5,2),
        gula_darah_sewaktu_nilai DECIMAL(5,2),
        gula_darah_kategori ENUM('normal', 'pra_diabetes', 'diabetes'),
        gula_darah_satuan VARCHAR(10) DEFAULT 'mg/dL',
        
        -- Rekomendasi
        rekomendasi_umum TEXT,
        rekomendasi_khusus TEXT,
        status ENUM('normal', 'perhatian', 'darurat') DEFAULT 'normal',
        
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (pemeriksaan_id) REFERENCES pemeriksaans(id),
        FOREIGN KEY (remaja_id) REFERENCES remajas(id),
        INDEX idx_remaja (remaja_id),
        INDEX idx_status (status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Analisis pemeriksaan remaja table checked/created\n";
    
    // ==================== TABEL KONSELING REMAJA ====================
    $sql = "CREATE TABLE IF NOT EXISTS konseling_remaja (
        id INT PRIMARY KEY AUTO_INCREMENT,
        remaja_id INT NOT NULL,
        bidan_id INT NOT NULL,
        tanggal_konseling DATE NOT NULL,
        topik_konseling ENUM('gizi', 'kesehatan_reproduksi', 'kebersihan_diri', 'aktivitas_fisik', 'mental_emosional', 'lainnya'),
        keluhan TEXT,
        hasil_assessment TEXT,
        rencana_tindakan TEXT,
        rekomendasi TEXT,
        jadwal_tindak_lanjut DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (remaja_id) REFERENCES remajas(id),
        FOREIGN KEY (bidan_id) REFERENCES users(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Konseling remaja table checked/created\n";
    
    // ==================== TABEL LAPORAN ====================
    $sql = "CREATE TABLE IF NOT EXISTS laporans (
        id INT PRIMARY KEY AUTO_INCREMENT,
        kode_laporan VARCHAR(20) UNIQUE NOT NULL,
        jenis_laporan ENUM('bulanan', 'tahunan', 'khusus') NOT NULL,
        periode_awal DATE NOT NULL,
        periode_akhir DATE NOT NULL,
        judul VARCHAR(200) NOT NULL,
        data_json LONGTEXT,
        file_path VARCHAR(255),
        dibuat_oleh INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (dibuat_oleh) REFERENCES users(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Laporans table checked/created\n";
    
    // ==================== TABEL NOTIFIKASI ====================
    $sql = "CREATE TABLE IF NOT EXISTS notifikasis (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        judul VARCHAR(200) NOT NULL,
        pesan TEXT,
        tipe ENUM('info', 'warning', 'success', 'danger') DEFAULT 'info',
        dibaca BOOLEAN DEFAULT FALSE,
        link VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id),
        INDEX idx_user_dibaca (user_id, dibaca)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "✓ Notifikasis table checked/created\n";
    
    // ==================== INSERT DATA REFERENSI NILAI NORMAL REMAJA ====================
    echo "\nInserting reference data for remaja...\n";
    
    // Data IMT Remaja (dari gambar yang diberikan)
    $imt_data = [
        // Usia 6 tahun
        [6, 'L', 'kurus', 0, 13.0],
        [6, 'L', 'normal', 13.1, 18.4],
        [6, 'L', 'gemuk', 18.5, 100],
        [6, 'P', 'kurus', 0, 12.7],
        [6, 'P', 'normal', 12.8, 19.1],
        [6, 'P', 'gemuk', 19.2, 100],
        
        // Usia 7 tahun
        [7, 'L', 'kurus', 0, 13.2],
        [7, 'L', 'normal', 13.3, 18.9],
        [7, 'L', 'gemuk', 19.0, 100],
        [7, 'P', 'kurus', 0, 12.7],
        [7, 'P', 'normal', 12.8, 19.7],
        [7, 'P', 'gemuk', 19.8, 100],
        
        // Usia 8 tahun
        [8, 'L', 'kurus', 0, 13.3],
        [8, 'L', 'normal', 13.4, 19.6],
        [8, 'L', 'gemuk', 19.7, 100],
        [8, 'P', 'kurus', 0, 12.9],
        [8, 'P', 'normal', 13.0, 20.7],
        [8, 'P', 'gemuk', 20.8, 100],
        
        // Usia 9 tahun
        [9, 'L', 'kurus', 0, 13.5],
        [9, 'L', 'normal', 13.6, 20.4],
        [9, 'L', 'gemuk', 20.5, 100],
        [9, 'P', 'kurus', 0, 13.1],
        [9, 'P', 'normal', 13.2, 21.4],
        [9, 'P', 'gemuk', 21.5, 100],
        
        // Usia 10 tahun
        [10, 'L', 'kurus', 0, 13.7],
        [10, 'L', 'normal', 13.8, 21.3],
        [10, 'L', 'gemuk', 21.4, 100],
        [10, 'P', 'kurus', 0, 13.5],
        [10, 'P', 'normal', 13.6, 22.5],
        [10, 'P', 'gemuk', 22.6, 100],
        
        // Usia 11 tahun
        [11, 'L', 'kurus', 0, 14.1],
        [11, 'L', 'normal', 14.2, 22.4],
        [11, 'L', 'gemuk', 22.5, 100],
        [11, 'P', 'kurus', 0, 13.9],
        [11, 'P', 'normal', 14.0, 23.6],
        [11, 'P', 'gemuk', 23.7, 100],
        
        // Usia 12 tahun
        [12, 'L', 'kurus', 0, 14.5],
        [12, 'L', 'normal', 14.6, 23.7],
        [12, 'L', 'gemuk', 23.8, 100],
        [12, 'P', 'kurus', 0, 14.4],
        [12, 'P', 'normal', 14.5, 24.8],
        [12, 'P', 'gemuk', 24.9, 100],
        
        // Usia 13 tahun
        [13, 'L', 'kurus', 0, 14.9],
        [13, 'L', 'normal', 15.0, 24.7],
        [13, 'L', 'gemuk', 24.8, 100],
        [13, 'P', 'kurus', 0, 14.9],
        [13, 'P', 'normal', 15.0, 26.1],
        [13, 'P', 'gemuk', 26.2, 100],
        
        // Usia 14 tahun
        [14, 'L', 'kurus', 0, 15.5],
        [14, 'L', 'normal', 15.6, 25.8],
        [14, 'L', 'gemuk', 25.9, 100],
        [14, 'P', 'kurus', 0, 15.5],
        [14, 'P', 'normal', 15.6, 27.2],
        [14, 'P', 'gemuk', 27.3, 100],
        
        // Usia 15 tahun
        [15, 'L', 'kurus', 0, 16.5],
        [15, 'L', 'normal', 16.6, 27.8],
        [15, 'L', 'gemuk', 27.9, 100],
        [15, 'P', 'kurus', 0, 15.9],
        [15, 'P', 'normal', 16.0, 28.1],
        [15, 'P', 'gemuk', 28.2, 100],
        
        // Usia 16 tahun
        [16, 'L', 'kurus', 0, 16.5],
        [16, 'L', 'normal', 16.6, 27.8],
        [16, 'L', 'gemuk', 27.9, 100],
        [16, 'P', 'kurus', 0, 16.2],
        [16, 'P', 'normal', 16.3, 28.8],
        [16, 'P', 'gemuk', 28.9, 100],
        
        // Usia 17 tahun
        [17, 'L', 'kurus', 0, 16.9],
        [17, 'L', 'normal', 17.0, 28.5],
        [17, 'L', 'gemuk', 28.6, 100],
        [17, 'P', 'kurus', 0, 16.4],
        [17, 'P', 'normal', 16.5, 29.2],
        [17, 'P', 'gemuk', 29.3, 100],
        
        // Usia 18 tahun
        [18, 'L', 'kurus', 0, 17.3],
        [18, 'L', 'normal', 17.4, 29.1],
        [18, 'L', 'gemuk', 29.2, 100],
        [18, 'P', 'kurus', 0, 16.4],
        [18, 'P', 'normal', 16.5, 29.4],
        [18, 'P', 'gemuk', 29.5, 100],
    ];
    
    foreach ($imt_data as $data) {
        list($usia, $jk, $kategori, $min, $max) = $data;
        $sql = "INSERT IGNORE INTO referensi_nilai_remaja 
                (jenis_pemeriksaan, usia_tahun, jenis_kelamin, kategori, nilai_min, nilai_max, satuan, keterangan) 
                VALUES ('imt', ?, ?, ?, ?, ?, 'kg/m²', 'Indeks Massa Tubuh')";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$usia, $jk, $kategori, $min, $max]);
    }
    echo "✓ IMT reference data inserted\n";
    
    // Data Hemoglobin
    $hb_data = [
        ['hemoglobin', 0, 'L', 'rendah', 0, 13.9, 'g/dL', 'Hemoglobin rendah'],
        ['hemoglobin', 0, 'L', 'normal', 14, 18, 'g/dL', 'Hemoglobin normal pria'],
        ['hemoglobin', 0, 'L', 'tinggi', 18.1, 100, 'g/dL', 'Hemoglobin tinggi'],
        ['hemoglobin', 0, 'P', 'rendah', 0, 11.9, 'g/dL', 'Hemoglobin rendah'],
        ['hemoglobin', 0, 'P', 'normal', 12, 16, 'g/dL', 'Hemoglobin normal wanita'],
        ['hemoglobin', 0, 'P', 'tinggi', 16.1, 100, 'g/dL', 'Hemoglobin tinggi'],
        ['hemoglobin', 0, 'ALL', 'rendah', 0, 10.9, 'g/dL', 'Hemoglobin rendah anak'],
        ['hemoglobin', 0, 'ALL', 'normal', 11, 13, 'g/dL', 'Hemoglobin normal anak'],
        ['hemoglobin', 0, 'ALL', 'tinggi', 13.1, 100, 'g/dL', 'Hemoglobin tinggi anak'],
    ];
    
    foreach ($hb_data as $data) {
        list($jenis, $usia, $jk, $kategori, $min, $max, $satuan, $keterangan) = $data;
        $sql = "INSERT IGNORE INTO referensi_nilai_remaja 
                (jenis_pemeriksaan, usia_tahun, jenis_kelamin, kategori, nilai_min, nilai_max, satuan, keterangan) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$jenis, $usia, $jk, $kategori, $min, $max, $satuan, $keterangan]);
    }
    echo "✓ Hemoglobin reference data inserted\n";
    
    // Data LILA (KEK - Kekurangan Energi Kronis)
    $lila_data = [
        ['lila', 0, 'P', 'kek', 0, 23.4, 'cm', 'Risiko KEK (Kekurangan Energi Kronis)'],
        ['lila', 0, 'P', 'normal', 23.5, 100, 'cm', 'Normal'],
    ];
    
    foreach ($lila_data as $data) {
        list($jenis, $usia, $jk, $kategori, $min, $max, $satuan, $keterangan) = $data;
        $sql = "INSERT IGNORE INTO referensi_nilai_remaja 
                (jenis_pemeriksaan, usia_tahun, jenis_kelamin, kategori, nilai_min, nilai_max, satuan, keterangan) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$jenis, $usia, $jk, $kategori, $min, $max, $satuan, $keterangan]);
    }
    echo "✓ LILA reference data inserted\n";
    
    // Data Gula Darah
    $gula_data = [
        ['gula_darah', 0, 'ALL', 'normal_gds', 0, 109, 'mg/dL', 'Gula Darah Puasa Normal'],
        ['gula_darah', 0, 'ALL', 'pra_diabetes', 110, 125, 'mg/dL', 'Pra-Diabetes'],
        ['gula_darah', 0, 'ALL', 'diabetes', 126, 1000, 'mg/dL', 'Diabetes'],
        
        ['gula_darah', 0, 'ALL', 'normal_gds', 0, 139, 'mg/dL', 'Gula Darah 2 Jam Normal'],
        ['gula_darah', 0, 'ALL', 'pra_diabetes', 140, 199, 'mg/dL', 'Pra-Diabetes'],
        ['gula_darah', 0, 'ALL', 'diabetes', 200, 1000, 'mg/dL', 'Diabetes'],
    ];
    
    foreach ($gula_data as $data) {
        list($jenis, $usia, $jk, $kategori, $min, $max, $satuan, $keterangan) = $data;
        $sql = "INSERT IGNORE INTO referensi_nilai_remaja 
                (jenis_pemeriksaan, usia_tahun, jenis_kelamin, kategori, nilai_min, nilai_max, satuan, keterangan) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$jenis, $usia, $jk, $kategori, $min, $max, $satuan, $keterangan]);
    }
    echo "✓ Gula darah reference data inserted\n";
    
    // ==================== CEK ADMIN USER ====================
    echo "\nChecking admin user...\n";
    
    $sql = "SELECT COUNT(*) as count FROM users WHERE email = 'admin@posyandu.com'";
    $stmt = $conn->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['count'] == 0) {
        // Insert admin user
        $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (email, password, role, status, created_by, nik) 
                VALUES ('admin@posyandu.com', '$adminPassword', 'admin', 'active', 1, '9999999999999999')";
        $conn->exec($sql);
        echo "✓ Admin user created\n";
        
        // Insert admin profile
        $sql = "INSERT INTO profiles (user_id, full_name, nik, jenis_kelamin, alamat, telepon)
                SELECT id, 'Administrator', '9999999999999999', 'L', 'Posyandu', '081234567890'
                FROM users WHERE email = 'admin@posyandu.com'";
        $conn->exec($sql);
        echo "✓ Admin profile created\n";
    } else {
        echo "✓ Admin user already exists\n";
    }
    
    echo "\n✅ Database update completed successfully!\n";
    echo "Total tables updated: 15 tables\n";
    echo "Admin login:\n";
    echo "  Email: admin@posyandu.com\n";
    echo "  Password: admin123\n";
    
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
