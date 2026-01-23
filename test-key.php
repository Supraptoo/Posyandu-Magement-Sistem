<?php
require __DIR__.'/vendor/autoload.php';

// Load .env manually
if (file_exists(__DIR__.'/.env')) {
    \ = file(__DIR__.'/.env');
    foreach (\ as \) {
        if (strpos(\, '=') !== false) {
            putenv(trim(\));
        }
    }
}

// Check APP_KEY
\ = getenv('APP_KEY');
echo "APP_KEY from env: " . (\ ?: '(empty)') . "\n";
echo "APP_KEY length: " . strlen(\) . "\n";

if (empty(\)) {
    echo "❌ ERROR: APP_KEY is empty!\n";
    
    // Generate new key
    \base64:5kOh7xdzHdUaAHR798yVfawpYfrJGA00JkXqnqVZa6Q= = 'base64:' . base64_encode(random_bytes(32));
    echo "Generated new key: \base64:5kOh7xdzHdUaAHR798yVfawpYfrJGA00JkXqnqVZa6Q=\n";
    
    // Update .env
    \ = file_get_contents(__DIR__.'/.env');
    if (strpos(\, 'APP_KEY=') !== false) {
        \ = preg_replace('/APP_KEY=.*/', 'APP_KEY=' . \base64:5kOh7xdzHdUaAHR798yVfawpYfrJGA00JkXqnqVZa6Q=, \);
    } else {
        \ .= "\nAPP_KEY=" . \base64:5kOh7xdzHdUaAHR798yVfawpYfrJGA00JkXqnqVZa6Q=;
    }
    file_put_contents(__DIR__.'/.env', \);
    
    echo "✅ Updated .env with new APP_KEY\n";
} else {
    echo "✅ APP_KEY found\n";
    
    // Check if key is valid base64
    if (strpos(\, 'base64:') === 0) {
        \ = substr(\, 7);
        if (base64_decode(\, true) !== false) {
            echo "✅ APP_KEY is valid base64\n";
        } else {
            echo "❌ APP_KEY is NOT valid base64\n";
        }
    } else {
        echo "❌ APP_KEY format should start with 'base64:'\n";
    }
}
