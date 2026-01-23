<?php
// Check first bytes of problematic files

echo "Checking file headers...\n\n";

$files = [
    'app/Http/Controllers/Auth/LoginController.php',
    'app/Http/Kernel.php',
];

foreach ($files as $file) {
    $filePath = __DIR__ . '/' . $file;
    
    if (file_exists($filePath)) {
        $handle = fopen($filePath, 'rb');
        $firstBytes = fread($handle, 10);
        fclose($handle);
        
        echo "File: $file\n";
        echo "Hex: " . bin2hex($firstBytes) . "\n";
        echo "ASCII: " . addcslashes($firstBytes, "\0..\37\177..\377") . "\n";
        
        if (substr($firstBytes, 0, 3) == "\xEF\xBB\xBF") {
            echo "Status: ❌ Has BOM\n";
        } elseif (substr($firstBytes, 0, 5) == '<?php') {
            echo "Status: ✅ OK\n";
        } elseif (substr($firstBytes, 0, 6) == '<?php ') {
            echo "Status: ✅ OK (with space)\n";
        } elseif (substr($firstBytes, 0, 2) == "\r\n") {
            echo "Status: ❌ Has CRLF before <?php\n";
        } elseif (substr($firstBytes, 0, 1) == "\n") {
            echo "Status: ❌ Has LF before <?php\n";
        } elseif (substr($firstBytes, 0, 1) == " ") {
            echo "Status: ❌ Has space before <?php\n";
        } else {
            echo "Status: ❓ Unknown format\n";
        }
        
        echo "---\n";
    } else {
        echo "File not found: $file\n";
    }
}
