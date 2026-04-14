<?php
/**
 * STORAGE FOLDERS - Buat folder upload di AeonFree
 * URL: https://domainmu/storage_link.php
 * HAPUS FILE INI SETELAH SELESAI!
 */

$folders = [
    __DIR__ . '/storage',
    __DIR__ . '/storage/products',
    __DIR__ . '/storage/categories',
    __DIR__ . '/storage/testimonials',
    __DIR__ . '/storage/collections',
    __DIR__ . '/storage/hero-slides',
    __DIR__ . '/storage/banners',
];

echo "<h2>🔧 Membuat folder storage...</h2>";

foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        if (mkdir($folder, 0755, true)) {
            echo "<p>✅ Dibuat: " . basename($folder) . "/</p>";
        } else {
            echo "<p>❌ Gagal buat: " . basename($folder) . "/</p>";
        }
    } else {
        echo "<p>✅ Sudah ada: " . basename($folder) . "/</p>";
    }
}

echo "<h3>✅ Folder storage siap!</h3>";
echo "<br><b style='color:red;'>⚠️ HAPUS FILE INI SETELAH SELESAI!</b>";
