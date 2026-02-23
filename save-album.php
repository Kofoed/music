<?php
require_once __DIR__ . '/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$artist = trim($_POST['artist'] ?? '');
$title = trim($_POST['title'] ?? '');
$cover = trim($_POST['cover'] ?? '');
$spotify = trim($_POST['spotify'] ?? '');

if (empty($artist) || empty($title) || empty($cover) || empty($spotify) || !isSpotifyAlbumUrl($spotify)) {
    header('Location: add.php');
    exit;
}

$data = loadAlbums();
$albums = $data['albums'] ?? [];

$maxId = 0;
foreach ($albums as $album) {
    $id = (int) ($album['id'] ?? 0);
    if ($id > $maxId) {
        $maxId = $id;
    }
}
$newId = $maxId + 1;

$albums[] = [
    'id' => $newId,
    'title' => $title,
    'artist' => $artist,
    'cover' => $cover,
    'spotify' => $spotify,
];

$data['albums'] = $albums;
saveAlbums($data);

header('Location: index.php');
exit;
