<?php
require_once __DIR__ . '/functions.php';

$url = trim($_GET['url'] ?? '');
$error = '';
$artist = '';
$title = '';
$cover = '';

if (empty($url) || !isSpotifyAlbumUrl($url)) {
    header('Location: add.php');
    exit;
}

$metadata = fetchSpotifyMetadata($url);
if ($metadata) {
    $artist = $metadata['artist'];
    $title = $metadata['title'];
    $cover = $metadata['cover'];
} else {
    $error = 'Could not fetch album info from Spotify. You can still add the album by filling in the fields below manually.';
}

ob_start();
?>
<h1 class="text-2xl font-semibold mb-6 text-neutral-800">Confirm album details</h1>

<?php if ($error): ?>
    <div class="mb-4 p-4 bg-amber-100 text-amber-800 rounded-lg"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="max-w-xl">
    <?php if ($cover): ?>
        <div class="mb-6">
            <img src="<?= htmlspecialchars($cover) ?>" alt="Album cover" class="w-48 h-48 object-cover rounded-lg shadow-md">
        </div>
    <?php endif; ?>

    <form method="post" action="save-album.php">
        <input type="hidden" name="spotify" value="<?= htmlspecialchars($url) ?>">

        <div class="mb-4">
            <label for="artist" class="block text-sm font-medium text-neutral-700 mb-2">Artist</label>
            <input
                type="text"
                id="artist"
                name="artist"
                value="<?= htmlspecialchars($artist) ?>"
                class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-neutral-500 focus:border-neutral-500"
                required
            >
        </div>

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-neutral-700 mb-2">Album title</label>
            <input
                type="text"
                id="title"
                name="title"
                value="<?= htmlspecialchars($title) ?>"
                class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-neutral-500 focus:border-neutral-500"
                required
            >
        </div>

        <div class="mb-4">
            <label for="cover" class="block text-sm font-medium text-neutral-700 mb-2">Album cover URL</label>
            <input
                type="url"
                id="cover"
                name="cover"
                value="<?= htmlspecialchars($cover) ?>"
                class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-neutral-500 focus:border-neutral-500"
                required
            >
        </div>

        <div class="flex gap-3">
            <button type="submit" class="px-4 py-2 bg-neutral-800 text-white rounded-lg hover:bg-neutral-700">
                Submit
            </button>
            <a href="add.php" class="px-4 py-2 text-neutral-600 hover:text-neutral-800">Back</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
$pageTitle = 'Confirm album';
require __DIR__ . '/layout.php';
