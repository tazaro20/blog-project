<?php
use App\Connection;
use App\Table\PostTable;
use App\HTML\Form;
use App\Validators\PostValidator;
use App\ObjectHelper;
use App\Auth;

Auth::check();

// Initialisation de la variable de succès
$success = false;

// Connexion à la base de données
$pdo = Connection::getPDO();

// Création d'une instance de PostTable
$postTable = new PostTable($pdo);

// Récupération du post à éditer
$post = (new PostTable($pdo))->find($params['id']);

// Initialisation du tableau d'erreurs
$errors = [];

// Si des données sont postées
if (!empty($_POST)) {

    // Création d'une instance de Validator
    $v = new PostValidator($_POST,$postTable,$post->getId());

    // Mise à jour des propriétés de l'objet Post
    (new ObjectHelper)->hydrate($post,$_POST,['name','slug','content','created_at']);

    // Validation des données
    if ($v->validate()) {
        // Mise à jour du post dans la base de données
        $postTable->updatePost($post);
        $success = true;
    } else {
        // Récupération des erreurs de validation
        $errors = $v->errors();
    }
}

// Création du formulaire
$form = new Form($post, $errors);
?>

<!-- Affichage d'un message de succès si l'article a été mis à jour -->
<?php if ($success): ?>
    <div class="alert alert-success" onclick="alert('Vous avez mis l\'article à jour');">
        Votre article a été mis à jour.
    </div>
<?php endif; ?>
<?php if ($errors): ?>
    <div class="alert alert-danger" onclick="alert('l\'article n\'a pas ete mis a jour ');">
        Votre article n'as pu a été mis a jour.
    </div>
<?php endif; ?>

<!-- Titre de la page -->
<h1>Éditer l'article <?= e($post->getName()) ?></h1>

<!-- Génération des champs du formulaire -->
<form method="post">
   <?php require '_form.php'; ?>
