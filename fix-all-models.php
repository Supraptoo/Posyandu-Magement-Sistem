<?php
// Fix semua model files

echo "Fixing all model files...\n\n";

$modelsDir = __DIR__ . '/app/Models';
$models = [
    'Profile.php',
    'Balita.php',
    'Remaja.php',
    'Lansia.php',
    'Kader.php',
    'Bidan.php',
    'Kunjungan.php',
    'Pemeriksaan.php',
    'Imunisasi.php',
    'Vitamin.php',
    'Konsultasi.php',
    'ReferensiNilaiRemaja.php',
    'AnalisisPemeriksaanRemaja.php',
    'KonselingRemaja.php',
    'Laporan.php',
    'Notifikasi.php',
];

foreach ($models as $model) {
    $filePath = $modelsDir . '/' . $model;
    
    if (file_exists($filePath)) {
        echo "Processing: $model\n";
        
        // Baca file
        $content = file_get_contents($filePath);
        $original = $content;
        
        // 1. Hapus BOM
        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);
        
        // 2. Hapus whitespace di awal
        $content = ltrim($content);
        
        // 3. Pastikan dimulai dengan <?php
        if (!str_starts_with($content, '<?php')) {
            $content = '<?php' . PHP_EOL . $content;
        }
        
        // 4. Hapus karakter null
        $content = str_replace("\0", '', $content);
        
        // 5. Hapus karakter kontrol kecuali newline dan tab
        $content = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $content);
        
        // Simpan jika ada perubahan
        if ($content !== $original) {
            file_put_contents($filePath, $content);
            echo "  ✓ Fixed encoding\n";
        }
        
        // Validasi syntax
        $output = [];
        $return = 0;
        exec('php -l "' . $filePath . '" 2>&1', $output, $return);
        
        if ($return === 0) {
            echo "  ✅ Syntax OK\n";
        } else {
            echo "  ❌ Syntax error: " . implode(' ', $output) . "\n";
            
            // Tampilkan 5 baris pertama untuk debugging
            $lines = explode(PHP_EOL, $content);
            echo "  First 5 lines:\n";
            for ($i = 0; $i < min(5, count($lines)); $i++) {
                echo "    " . ($i + 1) . ": " . htmlspecialchars($lines[$i]) . "\n";
            }
        }
        
        echo "\n";
    } else {
        echo "⚠ Missing: $model\n";
    }
}

echo "✅ All models processed\n";
