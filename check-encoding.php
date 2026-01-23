<?php
// Check first bytes of critical files

echo "Checking file encoding...\n\n";

$criticalFiles = [
    'app/Models/User.php',
    'app/Http/Controllers/Auth/LoginController.php',
    'app/Providers/AppServiceProvider.php',
    'app/Http/Kernel.php',
    'bootstrap/app.php',
];

foreach ($file in $criticalFiles) {
    $filePath = __DIR__ . '/' . $file;
    
    if (file_exists($filePath)) {
        echo "File: $file\n";
        
        $handle = fopen($filePath, 'rb');
        $first100 = fread($handle, 100);
        fclose($handle);
        
        // Check first 10 bytes in hex
        $first10hex = bin2hex(substr($first100, 0, 10));
        echo "  First 10 bytes (hex): $first10hex\n";
        
        // Check for BOM
        if (str_starts_with($first100, "\xEF\xBB\xBF")) {
            echo "  ❌ Has UTF-8 BOM\n";
        } elseif (str_starts_with($first100, "\xFF\xFE")) {
            echo "  ❌ Has UTF-16 LE BOM\n";
        } elseif (str_starts_with($first100, "\xFE\xFF")) {
            echo "  ❌ Has UTF-16 BE BOM\n";
        } else {
            echo "  ✅ No BOM detected\n";
        }
        
        // Check for <?php
        if (str_starts_with($first100, '<?php')) {
            echo "  ✅ Starts with <?php\n";
        } else {
            echo "  ❌ Doesn't start with <?php\n";
            
            // Try to find it
            $pos = strpos($first100, '<?php');
            if ($pos !== false) {
                echo "  Found <?php at position: $pos\n";
                echo "  Characters before: ";
                for ($i = 0; $i < $pos; $i++) {
                    echo '0x' . bin2hex($first100[$i]) . ' ';
                }
                echo "\n";
            }
        }
        
        // Validate syntax
        $output = [];
        $return = 0;
        exec('php -l "' . $filePath . '" 2>&1', $output, $return);
        
        if ($return === 0) {
            echo "  ✅ Syntax valid\n";
        } else {
            echo "  ❌ Syntax error\n";
        }
        
        echo "---\n";
    } else {
        echo "File not found: $file\n";
    }
}
