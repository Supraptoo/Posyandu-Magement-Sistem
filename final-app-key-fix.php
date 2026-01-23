<?php
echo "=== Laravel App Key Final Fix ===\n\n";

// 1. Check and fix .env
$envFile = __DIR__ . '/.env';
if (!file_exists($envFile)) {
    echo "❌ .env file not found!\n";
    // Create from example
    if (file_exists(__DIR__ . '/.env.example')) {
        copy(__DIR__ . '/.env.example', $envFile);
        echo "✓ Created .env from .env.example\n";
    } else {
        echo "❌ .env.example also not found!\n";
        exit(1);
    }
}

// 2. Read and fix .env
$envContent = file_get_contents($envFile);
$lines = explode("\n", $envContent);
$hasAppKey = false;
$appKeyLine = '';

foreach ($lines as $line) {
    if (strpos(trim($line), 'APP_KEY=') === 0) {
        $hasAppKey = true;
        $appKeyLine = $line;
        break;
    }
}

if (!$hasAppKey || strlen($appKeyLine) < 50) {
    echo "APP_KEY missing or invalid\n";
    
    // Generate proper 32 byte key
    $key = 'base64:' . base64_encode(random_bytes(32));
    echo "Generated new key (64 chars): " . substr($key, 7, 10) . "...\n";
    
    if (!$hasAppKey) {
        $envContent .= "\nAPP_KEY=" . $key;
    } else {
        $envContent = str_replace($appKeyLine, "APP_KEY=" . $key, $envContent);
    }
    
    file_put_contents($envFile, $envContent);
    echo "✓ Updated .env with valid APP_KEY\n";
    
    // Set environment variable
    putenv("APP_KEY=$key");
    $_ENV['APP_KEY'] = $key;
} else {
    echo "✓ APP_KEY already exists in .env\n";
    
    // Extract key value
    $appKey = substr($appKeyLine, 8);
    putenv("APP_KEY=$appKey");
    $_ENV['APP_KEY'] = $appKey;
}

// 3. Clear cache files
echo "\nClearing cache files...\n";
$cacheDirs = [
    'bootstrap/cache',
    'storage/framework/cache',
    'storage/framework/views',
    'storage/framework/sessions',
];

foreach ($cacheDirs as $dir) {
    $fullPath = __DIR__ . '/' . $dir;
    if (is_dir($fullPath)) {
        $files = glob($fullPath . '/*');
        foreach ($files as $file) {
            if (is_file($file) && basename($file) !== '.gitignore') {
                unlink($file);
            }
        }
        echo "✓ Cleared: $dir\n";
    }
}

// 4. Run Laravel commands via shell
echo "\nRunning Laravel commands...\n";
$commands = [
    'config:clear',
    'route:clear',
    'view:clear',
    'cache:clear',
    'event:clear',
    'optimize:clear'
];

foreach ($commands as $cmd) {
    echo "  Executing: php artisan $cmd\n";
    system("cd \"" . __DIR__ . "\" && php artisan $cmd 2>&1", $result);
    if ($result !== 0) {
        echo "  ⚠ Command may have failed\n";
    }
}

// 5. Create config cache manually
echo "\nCreating config cache...\n";
try {
    require __DIR__ . '/vendor/autoload.php';
    
    $app = require_once __DIR__ . '/bootstrap/app.php';
    
    // Test config
    $config = $app->make('config');
    $appKey = $config->get('app.key');
    
    if ($appKey) {
        echo "✅ Success! APP_KEY loaded: " . substr($appKey, 0, 20) . "...\n";
        
        // Create config cache
        $configArray = [];
        foreach ($config->all() as $key => $value) {
            $configArray[$key] = $value;
        }
        
        $cacheContent = '<?php return ' . var_export($configArray, true) . ';';
        file_put_contents(__DIR__ . '/bootstrap/cache/config.php', $cacheContent);
        echo "✅ Config cache created\n";
    } else {
        echo "❌ Failed to load APP_KEY from config\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== Fix Completed ===\n";
echo "Now run: php artisan serve\n";
echo "Then open: http://localhost:8000\n";
