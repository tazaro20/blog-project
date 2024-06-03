<!doctype html>
<html lang="fa" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= isset($title) ? htmlspecialchars($title) : "mon site" ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .text-muted {
            font-size: 0.9rem;
        }
    </style>
</head>
<body class="d-flex flex-column h-100" style="background: #85c1f6">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a href="<?= htmlspecialchars($router->url('home')) ?>" class="navbar-brand">Mon site</a>
</nav>

<div class="container mt-4">
    <?= $content ?>
</div>

<footer class="bg-light footer py-4">
    <div class="container">
        <?php if (defined('DEBUG_TIME')): ?>
            page générée en <?= round(1000 * (microtime(true) - DEBUG_TIME)) ?> ms
        <?php endif; ?>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
