<?php

use App\Connection;
use App\Table\PostTable;
use App\Table\CategoryTable;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();
$post = (new PostTable($pdo))->find($id);

(new CategoryTable($pdo))->hydratePosts([$post]);

if ($post->getSlug() !== $slug) {
    $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
    exit();
}
?>

<!-- HTML pour afficher les détails du post -->
<div class="card mb-3">
    <h1 class="card-title"><?= htmlspecialchars($post->getName(), ENT_QUOTES, 'UTF-8') ?></h1>
    <p class="text-muted"><?= htmlspecialchars($post->getCreatedAt()->format('d F Y  H:i:s a'), ENT_QUOTES, 'UTF-8') ?></p>
    <?php foreach ($post->getCategories() as $k => $category):
        if ($k > 0):
            echo ', ';
        endif;
        $category_url = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]);
        ?>
        <a href="<?= htmlspecialchars($category_url, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($category->getName(), ENT_QUOTES, 'UTF-8') ?></a>
    <?php endforeach; ?>
    <p><?= $post->getFormattedContent() ?></p>
</div>
