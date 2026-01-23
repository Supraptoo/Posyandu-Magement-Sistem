<?php
// Validate all PHP files for correct syntax

echo "Validating PHP files...\n\n";

function validatePhpFile($file) {
    // Check syntax using php -l
    $output = [];
    $return = 0;
    exec('php -l "' . $file . '" 2>&1', $output, $return);
    
    if ($return === 0) {
        return ['status' => 'ok', 'message' => 'Syntax OK'];
    } else {
        return ['status' => 'error', 'message' => implode(' ', $output)];
    }
}

$directories = [
    'app/Http/Controllers',
    'app/Models',
    'app/Http/Middleware',
];

$errorCount = 0;
$totalFiles = 0;

foreach ($directories as $dir) {
    $path = __DIR__ . '/' . $dir;
    if (!is_dir($path)) {
        continue;
    }
    
    echo "Checking directory: $dir\n";
    
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    foreach ($files as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $totalFiles++;
            $result = validatePhpFile($file->getPathname());
            
            if ($result['status'] === 'error') {
                echo "✗ " . $file->getFilename() . ": " . $result['message'] . "\n";
                $errorCount++;
            }
        }
    }
}

echo "\nSummary:\n";
echo "Total files checked: $totalFiles\n";
echo "Files with errors: $errorCount\n";

if ($errorCount === 0) {
    echo "✅ All PHP files have valid syntax!\n";
} else {
    echo "❌ Found $errorCount files with syntax errors\n";
}
