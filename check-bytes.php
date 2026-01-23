<?php
// Check problematic files

$files = [
    'app/Providers/AppServiceProvider.php',
    'app/Http/Controllers/Auth/LoginController.php',
    'app/Http/Kernel.php',
];

foreach ($files as $file) {
    $filePath = __DIR__ . '/' . $file;
    
    if (file_exists($filePath)) {
        $handle = fopen($filePath, 'rb');
        $firstBytes = fread($handle, 20);
        fclose($handle);
        
        echo "File: $file\n";
        echo "First 20 bytes (hex): " . bin2hex($firstBytes) . "\n";
        echo "First 20 bytes (ascii): '" . addcslashes($firstBytes, "\0..\37") . "'\n";
        
        // Check for common issues
        if (str_starts_with($firstBytes, "\xEF\xBB\xBF")) {
            echo "Issue: ❌ Has UTF-8 BOM\n";
        } elseif (str_starts_with($firstBytes, "\xFF\xFE")) {
            echo "Issue: ❌ Has UTF-16 LE BOM\n";
        } elseif (str_starts_with($firstBytes, "\xFE\xFF")) {
            echo "Issue: ❌ Has UTF-16 BE BOM\n";
        } elseif (!str_starts_with($firstBytes, '<?php')) {
            echo "Issue: ❌ Doesn't start with <?php\n";
            
            // Try to find where <?php starts
            $pos = strpos($firstBytes, '<?php');
            if ($pos !== false) {
                echo "      <?php found at position: $pos\n";
                echo "      Characters before: '" . addcslashes(substr($firstBytes, 0, $pos), "\0..\37") . "'\n";
            }
        } else {
            echo "Status: ✅ OK\n";
        }
        echo "---\n";
    }
}
