<?php

const ALBUMS_FILE = __DIR__ . '/albums.json';

function loadAlbums(): array
{
    if (!file_exists(ALBUMS_FILE)) {
        return ['albums' => []];
    }
    $json = file_get_contents(ALBUMS_FILE);
    $data = json_decode($json, true);
    return $data ?: ['albums' => []];
}

function saveAlbums(array $data): bool
{
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    return file_put_contents(ALBUMS_FILE, $json) !== false;
}

/**
 * Fetch album metadata from Spotify oEmbed API.
 * Returns ['artist' => string, 'title' => string, 'cover' => string] or null on failure.
 */
function fetchSpotifyMetadata(string $url): ?array
{
    $oembedUrl = 'https://open.spotify.com/oembed?url=' . urlencode($url);
    $context = stream_context_create(['http' => [
        'timeout' => 10,
        'user_agent' => 'MusicAlbumCollection/1.0',
    ]]);
    $response = @file_get_contents($oembedUrl, false, $context);
    if ($response === false) {
        return null;
    }
    $data = json_decode($response, true);
    if (!$data || !isset($data['title'])) {
        return null;
    }
    $title = trim($data['title']);
    $cover = $data['thumbnail_url'] ?? '';

    // Parse title: Spotify often returns "Artist – Album" or "Artist - Album"
    $artist = '';
    $albumTitle = $title;
    if (preg_match('/^(.+?)\s+[–\-]\s+(.+)$/u', $title, $m)) {
        $artist = trim($m[1]);
        $albumTitle = trim($m[2]);
    }

    return [
        'artist' => $artist,
        'title' => $albumTitle,
        'cover' => $cover,
    ];
}

function isSpotifyAlbumUrl(string $url): bool
{
    return (bool) preg_match('#https?://(open\.)?spotify\.com/album/[a-zA-Z0-9]+#', $url);
}
