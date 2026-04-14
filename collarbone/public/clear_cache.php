<?php
/**
 * CLEAR CACHE & DEBUG - Buka di browser setelah upload ke AeonFree
 * URL: https://domainmu/clear_cache.php
 * HAPUS FILE INI SETELAH SELESAI!
 */

require __DIR__ . '/collarbone/vendor/autoload.php';
$app = require_once __DIR__ . '/collarbone/bootstrap/app.php';

$app->bind('path.public', function() {
    return __DIR__;
});

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<h2>🧹 Clear All Cache</h2>";

try {
    Illuminate\Support\Facades\Artisan::call('config:clear');
    echo "<p>✅ Config cache cleared</p>";
    
    Illuminate\Support\Facades\Artisan::call('cache:clear');
    echo "<p>✅ Cache cleared</p>";
    
    Illuminate\Support\Facades\Artisan::call('view:clear');
    echo "<p>✅ View cache cleared</p>";
    
    Illuminate\Support\Facades\Artisan::call('route:clear');
    echo "<p>✅ Route cache cleared</p>";
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h2>🔍 Debug Paths</h2>";

echo "<p><b>public_path():</b> " . public_path() . "</p>";
echo "<p><b>storage_path():</b> " . storage_path() . "</p>";
echo "<p><b>public_path('storage'):</b> " . public_path('storage') . "</p>";
echo "<p><b>base_path():</b> " . base_path() . "</p>";
echo "<p><b>config filesystems.disks.public.root:</b> " . config('filesystems.disks.public.root') . "</p>";
echo "<p><b>config filesystems.disks.public.url:</b> " . config('filesystems.disks.public.url') . "</p>";
echo "<p><b>APP_URL:</b> " . config('app.url') . "</p>";

echo "<hr>";
echo "<h2>📁 Cek Folder Storage</h2>";

$storageDir = public_path('storage');
echo "<p><b>Path:</b> " . $storageDir . "</p>";
echo "<p><b>Exists:</b> " . (is_dir($storageDir) ? '✅ Ya' : '❌ Tidak') . "</p>";

if (is_dir($storageDir)) {
    $folders = ['products', 'categories', 'testimonials', 'collections', 'hero-slides', 'banners'];
    foreach ($folders as $f) {
        $path = $storageDir . '/' . $f;
        echo "<p>" . (is_dir($path) ? '✅' : '❌') . " storage/{$f}/</p>";
    }
}

echo "<hr>";
echo "<h2>📷 Test Upload</h2>";
echo "<p>Coba upload gambar produk sekarang. Jika masih error, screenshot halaman ini dan error-nya.</p>";

echo "<br><b style='color:red;'>⚠️ HAPUS FILE INI SETELAH SELESAI!</b>";
