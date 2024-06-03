<?php
use App\Connection;
use App\Table\PostTable;
use App\Table\CategoryTable;

$id = (int)($params['id'] ?? null);
$slug = $params['slug'] ?? null;

if ($id === null || $slug === null) {
    exit('Paramètres manquants');
}

$pdo = Connection::getPDO();
$category = (new CategoryTable($pdo))->find($id);

if ($category->getSlug() !== $slug) {
    $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
    exit();
}

$title = "Catégorie {$category->getName()}";

[$posts, $paginatedQuery] = (new PostTable($pdo))->findPaginatedForCategory($category->getId());

$link = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]);
?>

<h1><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>

<!-- Affichage des posts -->
<div class="row">
    <?php foreach ($posts as $post): ?>
        <div class="col-md-4">
            <?php require dirname(__DIR__). '/card.php' ?>
        </div>
    <?php endforeach; ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?= $paginatedQuery->previousLink($link) ?>
    <?= $paginatedQuery->nextLink($link) ?>
</div>
