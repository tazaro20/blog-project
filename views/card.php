<?php
$categories = [];
foreach ($post->getCategories() as $k => $category) {
    $url = $router->url('category',['id'=>$category->getId(),'slug'=>$category->getSlug()]);
    $categories[] = <<<HTML
         <a href="{$url}">{$category->getName()}</a>
HTML;
}
?>
<div class="card h-100 ">
    <div class="card-body">
        <h5 class="card-title"><?= htmlentities($post->getName()) ?></h5>
        <p class="text-muted"><?= $post->getCreatedAt()->format('d F Y H:i:s a') ?>
            <?php if(!empty($categories)): ?>
                :: <?= implode(', ', $categories) ?>
            <?php endif; ?>
        </p>
        <p><?= $post->getExcerpt() ?></p>
        <p>
            <a href="<?= $router->url('post', ['id' => $post->getId(), 'slug' => $post->getSlug()]) ?>" class="btn btn-primary">voir plus</a>
        </p>
    </div>
</div>
