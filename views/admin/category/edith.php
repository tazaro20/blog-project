<?php
use App\Connection;
use App\Table\CategoryTable;
use App\HTML\Form;
use App\Validators\CategoryValidator;
use App\ObjectHelper;
use App\Auth;

Auth::check();
$success = false;

// Connexion à la base de données
$pdo = Connection::getPDO();
$table =  new CategoryTable($pdo);
// Création d'une instance de PostTable
// Récupération du post à éditer
$item = $table->find($params['id']);

// Initialisation du tableau d'erreurs
$errors = [];
$fields = ['name','slug'];
// Si des données sont postées
if (!empty($_POST)) {

    // Création d'une instance de Validator
    $v = new CategoryValidator($_POST,$table,$item->getId());

    // Mise à jour des propriétés de l'objet Post
    (new ObjectHelper)->hydrate($item,$_POST,$fields);

    // Validation des données
    if ($v->validate()) {
        // Mise à jour du post dans la base de données
        $table->update([
                'name' => $item->getName(),
                 'slug' => $item->getSlug(),
        ],$item->getId());
        $success = true;
    } else {
        // Récupération des erreurs de validation
        $errors = $v->errors();
    }
}

// Création du formulaire
$form = new Form($item, $errors);
?>

<!-- Affichage d'un message de succès si l'article a été mis à jour -->
<?php if ($success): ?>
    <div class="alert alert-success" onclick="alert('Vous avez mis l\'article à jour');">
        la categorie a été mis à jour.
    </div>
<?php endif; ?>
<?php if ($errors): ?>
    <div class="alert alert-danger" onclick="alert('la categories n\'a pas ete mis a jour ');">
        echec de mis a jour de la categorie .
    </div>
<?php endif; ?>

<!-- Titre de la page -->
<h1>Éditer l'article <?= e($item->getName()) ?></h1>

<!-- Génération des champs du formulaire -->
<form method="post">
   <?php require '_form.php'; ?>
