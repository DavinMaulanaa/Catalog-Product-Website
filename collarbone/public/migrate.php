<?php
/**
 * MIGRATE - Jalankan sekali di browser setelah upload ke AeonFree
 * URL: https://domainmu/migrate.php
 * HAPUS FILE INI SETELAH SELESAI!
 */

require __DIR__ . '/collarbone/vendor/autoload.php';
$app = require_once __DIR__ . '/collarbone/bootstrap/app.php';

$app->bind('path.public', function() {
    return __DIR__;
});

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<h2>🔧 Running Migrations...</h2>";

try {
    Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    echo "<pre>" . Illuminate\Support\Facades\Artisan::output() . "</pre>";
    echo "<h3>✅ Migration selesai!</h3>";
} catch (Exception $e) {
    echo "<h3>❌ Error:</h3>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}

echo "<hr>";
echo "<h2>🔧 Creating Admin User...</h2>";

try {
    $db = app('db');
    $exists = $db->table('users')->where('email', 'admin@collarbone.com')->first();
    
    if ($exists) {
        echo "<p>✅ Admin user sudah ada!</p>";
    } else {
        $db->table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@collarbone.com',
            'password' => password_hash('admin123', PASSWORD_BCRYPT),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "<p>✅ Admin user berhasil dibuat!</p>";
        echo "<p>Email: admin@collarbone.com</p>";
        echo "<p>Password: admin123</p>";
    }
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<br><b style='color:red;'>⚠️ HAPUS FILE INI SETELAH SELESAI!</b>";
