<?php
use App\Connection;
use App\Auth;
use App\Table\CategoryTable;

$pdo = Connection::getPDO();
Auth::check();
$title = 'Gestion des categories';
$items= (new CategoryTable($pdo))->all();
$link = $router->url('admin_categories');
?>
<?php if (isset($_GET['delete'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 20px auto; padding: 15px; border-radius: 10px; max-width: 300px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
        <h5 class="alert-heading">Suppression réussie</h5>
        <p>Votre suppression a été effectuée avec succès.</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if (isset($_GET['created'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 20px auto; padding: 15px; border-radius: 10px; max-width: 300px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
        <h5 class="alert-heading"> successfully</h5>
        <p>Votre article a été ajouter avec succès.</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<div class="d-flex justify-content-end mb-3">
    <a href="<?= $router->url('admin_category_new') ?>" class="btn btn-primary text-light">
        Add article
    </a>
</div>

<table class="table" >
    <thead>
        <th>ID</th>
        <th>Title</th>
        <th>URL</th>
        <th>Actions</th>
    </thead>
    <tbody>
    <?php foreach ($items as $item): ?>
         <tr>
             <td>
                 #<?= e($item->getId()) ?>
             </td>
             <td>
                 <a href="<?= $router->url('admin_category',['id'=>$item->getid()]) ?>">
                 <?= e($item->getName()) ?>
                 </a>
             </td>
             <td><?=$item->getSlug() ?></td>
             <td>
                 <a href="<?= $router->url('admin_category',['id'=>$item->getid()]) ?>" class="text-light btn btn-primary">
                    Edith
                 </a>
                 <form action="<?= $router->url('admin_Category_delete',['id'=>$item->getid()]) ?>" method="post"
                 onsubmit="return confirm('voulez vous vraiment supprimer cette categories ?')" style="display: inline">
                     <button type="submit" class="btn btn-danger">Delete</button>
                 </form>
             </td>
         </tr>
    <?php endforeach; ?>
    </tbody>
</table>

