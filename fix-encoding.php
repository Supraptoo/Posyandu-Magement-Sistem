<?php
// Fix encoding for all PHP files

echo "Fixing encoding for all PHP files...\n\n";

function fixFileEncoding($filePath) {
    if (!file_exists($filePath)) {
        return false;
    }
    
    $content = file_get_contents($filePath);
    $original = $content;
    
    // Remove BOM
    $bom = pack('H*', 'EFBBBF');
    $content = preg_replace("/^$bom/", '', $content);
    
    // Remove any whitespace at the beginning
    $content = ltrim($content);
    
    // Ensure it starts with <?php
    if (!str_starts_with($content, '<?php')) {
        // Try to find <?php
        $pos = strpos($content, '<?php');
        if ($pos !== false) {
            // Remove everything before <?php
            $content = substr($content, $pos);
        } else {
            // Add <?php if not found
            $content = '<?php' . PHP_EOL . $content;
        }
    }
    
    // Save only if changed
    if ($content !== $original) {
        file_put_contents($filePath, $content);
        return true;
    }
    
    return false;
}

$directories = [
    'app',
    'routes',
    'database',
];

$fixedCount = 0;
$totalFiles = 0;

foreach ($directories as $dir) {
    $path = __DIR__ . '/' . $dir;
    if (!is_dir($path)) {
        continue;
    }
    
    echo "Processing directory: $dir\n";
    
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $totalFiles++;
            if (fixFileEncoding($file->getPathname())) {
                echo "  ✓ Fixed: " . $file->getFilename() . "\n";
                $fixedCount++;
            }
        }
    }
}

echo "\nSummary:\n";
echo "Total PHP files: $totalFiles\n";
echo "Files fixed: $fixedCount\n";
echo "✅ Encoding fix completed\n";
