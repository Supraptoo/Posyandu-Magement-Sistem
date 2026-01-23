<?php
// Script untuk memperbaiki semua model

echo "Fixing model files...\n\n";

$modelsDir = __DIR__ . '/app/Models';
$models = [
    'User.php',
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

$fixedCount = 0;

foreach ($models as $model) {
    $filePath = $modelsDir . '/' . $model;
    
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        
        // Hapus BOM
        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);
        
        // Hapus whitespace di awal
        $content = ltrim($content);
        
        // Pastikan dimulai dengan <?php
        if (strpos($content, '<?php') !== 0) {
            $content = '<?php' . PHP_EOL . ltrim($content);
        }
        
        // Hapus baris kosong berlebihan setelah <?php
        $lines = explode(PHP_EOL, $content);
        if (count($lines) > 1) {
            $newLines = [];
            $newLines[] = $lines[0]; // <?php
            
            // Skip baris kosong setelah <?php
            $i = 1;
            while ($i < count($lines) && trim($lines[$i]) === '') {
                $i++;
            }
            
            // Tambahkan namespace
            for (; $i < count($lines); $i++) {
                $newLines[] = $lines[$i];
            }
            
            $content = implode(PHP_EOL, $newLines);
        }
        
        file_put_contents($filePath, $content);
        echo "✓ Fixed: $model\n";
        $fixedCount++;
    } else {
        echo "✗ Missing: $model\n";
    }
}

echo "\n✅ Fixed $fixedCount model files\n";
