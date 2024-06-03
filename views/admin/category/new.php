<?php
use App\Connection;
use App\Table\CategoryTable;
use App\HTML\Form;
use App\Validators\CategoryValidator;
use App\ObjectHelper;
use App\Model\Category;
use App\Auth;

$errors = [];
Auth::check();

$items = new Category();

// Si des données sont postées
if (!empty($_POST)) {
    $pdo = Connection::getPDO();
    $table = new CategoryTable($pdo);

    $v = new CategoryValidator($_POST, $table);

    // Mise à jour des propriétés de l'objet Post
    (new ObjectHelper)->hydrate($items, $_POST, ['name', 'slug']);

    // Validation des données
    if ($v->validate()) {
        // Insertion du post dans la base de données
        $table->create([
            'name' => $items->getName(),
            'slug' => $items->getSlug(),
        ],$items->getId());
        header('Location: '.$router->url('admin_categories') .'?created=1');
        exit();
    } else {
        // Récupération des erreurs de validation
        $errors = $v->errors();
    }
}

// Création du formulaire
$form = new Form($items, $errors);
?>

<?php if ($errors): ?>
    <div class="alert alert-danger" onclick="alert('L\'article n\'a pas pu être enregistré.');">
        Votre categories n'a pas pu être enregistré.
    </div>
<?php endif; ?>

<!-- Titre de la page -->
<h1>Créer un article</h1>

<?php require '_form.php';
