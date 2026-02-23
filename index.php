<?php
require_once __DIR__ . '/functions.php';

$data = loadAlbums();
$albums = $data['albums'] ?? [];

ob_start();
?>
<h1 class="text-2xl font-semibold mb-6 text-neutral-800">Overview</h1>

<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
    <?php foreach ($albums as $album): ?>
        <a href="<?= htmlspecialchars($album['spotify']) ?>" target="_blank" rel="noopener noreferrer" class="block group">
            <div class="aspect-square rounded-lg overflow-hidden shadow-md group-hover:shadow-lg transition-shadow bg-neutral-200">
                <img
                    src="<?= htmlspecialchars($album['cover']) ?>"
                    alt="<?= htmlspecialchars($album['artist'] . ' - ' . $album['title']) ?>"
                    class="w-full h-full object-cover"
                    loading="lazy"
                >
            </div>
            <p class="mt-2 text-sm text-neutral-600 truncate" title="<?= htmlspecialchars($album['artist'] . ' - ' . $album['title']) ?>">
                <?= htmlspecialchars($album['artist']) ?> – <?= htmlspecialchars($album['title']) ?>
            </p>
        </a>
    <?php endforeach; ?>
</div>

<?php if (empty($albums)): ?>
    <p class="text-neutral-500">No albums yet. <a href="add.php" class="text-blue-600 hover:underline">Add your first album</a>.</p>
<?php endif; ?>

<?php
$content = ob_get_clean();
$pageTitle = 'Album Collection';
require __DIR__ . '/layout.php';
