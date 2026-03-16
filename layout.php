<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Album Collection') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col bg-neutral-100">
    <main class="flex-1 p-6 w-full">
        <?= $content ?? '' ?>
    </main>

    <footer class="sticky bottom-0 bg-neutral-800 text-neutral-400 py-3 px-6">
        <div class="max-w-6xl mx-auto flex items-center gap-4">
            <span>actions</span>
            <a href="add.php" class="text-neutral-300 hover:text-white">Add album</a>
        </div>
    </footer>
</body>
</html>
