<?php
require_once __DIR__ . '/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = trim($_POST['url'] ?? '');
    if (empty($url)) {
        $error = 'Please enter a Spotify URL.';
    } elseif (!isSpotifyAlbumUrl($url)) {
        $error = 'Please enter a valid Spotify album URL (e.g. https://open.spotify.com/album/...).';
    } else {
        header('Location: add-confirm.php?url=' . urlencode($url));
        exit;
    }
}

ob_start();
?>
<h1 class="text-2xl font-semibold mb-6 text-neutral-800">Add album</h1>

<p class="mb-4 text-neutral-600">Enter the Spotify album URL. You can copy it from Spotify by right-clicking the album and choosing "Share" → "Copy link to album".</p>

<?php if ($error): ?>
    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" action="add.php" class="max-w-xl">
    <label for="url" class="block text-sm font-medium text-neutral-700 mb-2">Spotify album URL</label>
    <input
        type="url"
        id="url"
        name="url"
        value="<?= htmlspecialchars($_POST['url'] ?? '') ?>"
        placeholder="https://open.spotify.com/album/..."
        class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-neutral-500 focus:border-neutral-500 mb-4"
        required
    >
    <button type="submit" class="px-4 py-2 bg-neutral-800 text-white rounded-lg hover:bg-neutral-700">
        Next
    </button>
</form>

<?php
$content = ob_get_clean();
$pageTitle = 'Add album';
require __DIR__ . '/layout.php';
