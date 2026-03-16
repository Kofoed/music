<?php
require_once __DIR__ . '/functions.php';

$data = loadAlbums();
$albums = $data['albums'] ?? [];

ob_start();
?>
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
    <?php foreach ($albums as $i => $album):
        $id = $album['id'] + $i * 31;
        $tx = (($id % 13) - 6) * 5;
        $ty = (($id % 11) - 5) * 5;
        $r = ($id % 9) - 4;
        $rot = ($r === 0 ? 1 : $r) * 0.75;
        $style = sprintf('transform: translate(%dpx, %dpx) rotate(%sdeg);', $tx, $ty, number_format($rot, 1));
    ?>
        <a href="<?= htmlspecialchars($album['spotify']) ?>" target="_blank" rel="noopener noreferrer" class="block group flex border border-black/50" style="<?= $style ?>">
            <div class="w-[10%] shrink-0 bg-neutral-900 border-r border-black/50"></div>
            <div class="flex-1 aspect-square overflow-hidden bg-neutral-200 min-w-0">
                <img
                    src="<?= htmlspecialchars($album['cover']) ?>"
                    alt="<?= htmlspecialchars($album['artist'] . ' - ' . $album['title']) ?>"
                    class="w-full h-full object-cover"
                    loading="lazy"
                >
            </div>
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
