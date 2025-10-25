<?php
$universalFiles = 'utility/';
// Ambil daftar file dari folder 'drivers' dan hilangkan . dan ..
$files = array_diff(scandir($universalFiles), array('..', '.'));
$universalFiles = array_filter($files, function($file) {
    // Filter untuk hanya file dengan ekstensi .rar dan .zip
    return in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['rar', 'zip']);
});

// Ambil query pencarian
$search = $_GET['search'] ?? '';
if ($search) {
    // Jika ada pencarian, filter file berdasarkan nama dan ekstensi yang diinginkan
    $universalFiles = array_filter($universalFiles, function($file) use ($search) {
        return stripos($file, $search) !== false && in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['rar', 'zip']);
    });
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-6 flex flex-col md:flex-row items-center justify-between">
            <h1 class="text-3xl font-bold tracking-tight text-gray-800">Driver Printer</h1>
        </div>
    </header>

    <main class="max-w-7xl mx-auto mt-6 px-4">
        <div class="mb-6">
            <a href="index.php" class="text-indigo-600">Kembali ke Beranda</a>
        </div>
        
        <div class="mb-6">
            <input type="text" id="search" placeholder="Cari driver..." class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-200">
        </div>

        <div id="file-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($universalFiles as $file): ?>
                <div class="bg-white p-5 rounded-lg shadow-sm hover:shadow-md transition transform hover:-translate-y-1">
                    <h3 class="font-semibold text-lg mb-2 text-gray-800"><?= htmlspecialchars($file) ?></h3>
                    <a href="<?= $universalFiles . '/' . urlencode($file) ?>" download class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">Download</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="bg-white mt-12 py-6 shadow-inner text-center text-gray-500">
        &copy; 2025 Gudang Driver Printer.
    </footer>

    <script>
        document.getElementById('search').addEventListener('input', function() {
            window.location.search = 'search=' + this.value;
        });
    </script>
</body>
</html>
