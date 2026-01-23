<?php
// Fix semua provider files

echo "Fixing provider files...\n\n";

$providers = [
    'AppServiceProvider.php',
    'AuthServiceProvider.php',
    'EventServiceProvider.php',
    'RouteServiceProvider.php',
];

$providersDir = __DIR__ . '/app/Providers';

foreach ($providers as $provider) {
    $filePath = $providersDir . '/' . $provider;
    
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        
        // Remove BOM
        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);
        
        // Remove whitespace at beginning
        $content = ltrim($content);
        
        // Ensure starts with <?php
        if (strpos($content, '<?php') !== 0) {
            $content = '<?php' . PHP_EOL . $content;
        }
        
        // Basic validation
        if (!str_contains($content, 'namespace App\Providers;')) {
            echo "⚠ Warning: $provider might have namespace issues\n";
        }
        
        file_put_contents($filePath, $content);
        echo "✓ Fixed: $provider\n";
        
        // Validate syntax
        $output = [];
        exec('php -l "' . $filePath . '"', $output, $returnCode);
        if ($returnCode !== 0) {
            echo "❌ Syntax error in $provider: " . implode(' ', $output) . "\n";
        }
    } else {
        echo "✗ Missing: $provider\n";
        
        // Create default provider if missing
        if ($provider === 'AppServiceProvider.php') {
            $defaultContent = '<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}';
            file_put_contents($filePath, $defaultContent);
            echo "✓ Created default $provider\n";
        }
    }
}

echo "\n✅ Provider files fixed\n";
