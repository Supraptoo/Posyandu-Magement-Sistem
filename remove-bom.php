<?php
// Remove BOM from all PHP files

echo "Removing BOM from PHP files...\n\n";

$directories = [
    'app/Http/Controllers',
    'app/Models',
    'app/Http/Middleware',
    'app/Services',
    'app',
    'routes',
    'database/seeders',
];

$fixedCount = 0;

foreach ($directories as $dir) {
    $path = __DIR__ . '/' . $dir;
    if (!is_dir($path)) {
        continue;
    }
    
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    foreach ($files as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            
            // Check for BOM
            if (substr($content, 0, 3) == "\xEF\xBB\xBF") {
                $content = substr($content, 3);
                file_put_contents($file->getPathname(), $content);
                echo "✓ Removed BOM from: " . $file->getFilename() . "\n";
                $fixedCount++;
            }
            
            // Check for whitespace before <?php
            if (preg_match('/^\s+<\?php/', $content)) {
                $content = preg_replace('/^\s+<\?php/', '<?php', $content);
                file_put_contents($file->getPathname(), $content);
                echo "✓ Fixed whitespace in: " . $file->getFilename() . "\n";
                $fixedCount++;
            }
        }
    }
}

echo "\n✅ Fixed $fixedCount files\n";

// Check specific problematic files
echo "\nChecking problematic files:\n";

$problemFiles = [
    'app/Http/Controllers/Auth/LoginController.php',
    'app/Http/Kernel.php',
    'app/Models/User.php',
];

foreach ($problemFiles as $file) {
    $filePath = __DIR__ . '/' . $file;
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        $firstLine = explode(PHP_EOL, $content)[0];
        
        if (trim($firstLine) === '<?php') {
            echo "✓ $file is OK\n";
        } else {
            echo "✗ $file has problem: " . substr($firstLine, 0, 20) . "...\n";
        }
    }
}
