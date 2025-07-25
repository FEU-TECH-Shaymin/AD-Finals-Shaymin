<?php
declare(strict_types=1);

function head(array $pageCss = []): void
{
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Outlast</title>

        <link rel="icon" type="image/x-icon" href="/assets/img/outlastFavicon.png">

        <!-- External CSS Libraries -->
        <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <!-- Main site CSS -->
        <link rel="stylesheet" href="/assets/css/style.css">

        <!-- Custom page-level CSS -->
        <?php foreach ($pageCss as $cssFile): ?>
            <link rel="stylesheet" href="<?= htmlspecialchars($cssFile) ?>">
        <?php endforeach; ?>
    </head>
    <body>
    <?php
}
?>