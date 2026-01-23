<?php
// Script untuk memperbaiki semua controller

echo "Fixing controller files...\n\n";

$controllersDir = __DIR__ . '/app/Http/Controllers';
$fixedCount = 0;

function fixControllerFile($filePath) {
    if (!file_exists($filePath)) {
        return false;
    }
    
    $content = file_get_contents($filePath);
    
    // Hapus BOM jika ada
    $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);
    
    // Hapus whitespace di awal file
    $content = ltrim($content);
    
    // Pastikan dimulai dengan <?php
    if (strpos($content, '<?php') !== 0) {
        $content = '<?php' . PHP_EOL . ltrim($content);
    }
    
    // Pastikan namespace langsung setelah <?php
    $lines = explode(PHP_EOL, $content);
    if (count($lines) > 1 && trim($lines[0]) == '<?php' && trim($lines[1]) != '') {
        array_splice($lines, 1, 0, ''); // Tambah baris kosong setelah <?php
        $content = implode(PHP_EOL, $lines);
    }
    
    file_put_contents($filePath, $content);
    return true;
}

// Fix Auth Controllers
$authControllers = [
    'Auth/LoginController.php',
    'Auth/ForgotPasswordController.php',
];

foreach ($authControllers as $controller) {
    $filePath = $controllersDir . '/' . $controller;
    if (file_exists($filePath)) {
        if (fixControllerFile($filePath)) {
            echo "✓ Fixed: $controller\n";
            $fixedCount++;
        }
    }
}

// Fix Admin Controllers
$adminControllers = [
    'Admin/DashboardController.php',
    'Admin/UserController.php',
    'Admin/KaderController.php',
    'Admin/BidanController.php',
    'Admin/PasienController.php',
];

foreach ($adminControllers as $controller) {
    $filePath = $controllersDir . '/' . $controller;
    if (file_exists($filePath)) {
        if (fixControllerFile($filePath)) {
            echo "✓ Fixed: $controller\n";
            $fixedCount++;
        }
    }
}

// Fix Bidan Controllers
$bidanControllers = [
    'Bidan/DashboardController.php',
    'Bidan/PemeriksaanController.php',
    'Bidan/KonsultasiController.php',
];

foreach ($bidanControllers as $controller) {
    $filePath = $controllersDir . '/' . $controller;
    if (file_exists($filePath)) {
        if (fixControllerFile($filePath)) {
            echo "✓ Fixed: $controller\n";
            $fixedCount++;
        }
    }
}

// Fix Kader Controllers
$kaderControllers = [
    'Kader/DashboardController.php',
    'Kader/PendaftaranController.php',
    'Kader/KunjunganController.php',
];

foreach ($kaderControllers as $controller) {
    $filePath = $controllersDir . '/' . $controller;
    if (file_exists($filePath)) {
        if (fixControllerFile($filePath)) {
            echo "✓ Fixed: $controller\n";
            $fixedCount++;
        }
    }
}

// Fix User Controllers
$userControllers = [
    'User/DashboardController.php',
    'User/ProfileController.php',
];

foreach ($userControllers as $controller) {
    $filePath = $controllersDir . '/' . $controller;
    if (file_exists($filePath)) {
        if (fixControllerFile($filePath)) {
            echo "✓ Fixed: $controller\n";
            $fixedCount++;
        }
    }
}

echo "\n✅ Fixed $fixedCount controller files\n";
