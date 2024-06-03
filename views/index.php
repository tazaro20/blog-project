<?php

use App\Connection;
use App\Table\PostTable;

$title = 'mon blog'; // Titre de la page
$pdo = Connection::getPDO(); // Connexion à la base de données

$table = new PostTable($pdo);
[$posts,$pagination] = $table->findPaginated();

$link = $router->url('home');
?>

<h1>mon blog</h1>

<div class="row">
    <?php foreach ($posts as $post): ?>
        <div class="col-md-4 mb-4">
            <?php require 'card.php'; ?>
        </div>
    <?php endforeach; ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?= $pagination->PreviousLink($link); ?>
    <?= $pagination->nextLink($link); ?>
</div>


