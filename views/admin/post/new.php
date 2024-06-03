<?php
use App\Connection;
use App\Table\PostTable;
use App\HTML\Form;
use App\Validators\PostValidator;
use App\ObjectHelper;
use App\Model\Post;

$errors = [];
$post = new Post();
$post->setCreatedAt(date('Y-m-d H:i:s'));

// Si des données sont postées
if (!empty($_POST)) {
    $pdo = Connection::getPDO();
    $postTable = new PostTable($pdo);

    $v = new PostValidator($_POST, $postTable, $post->getId());

    // Mise à jour des propriétés de l'objet Post
    (new ObjectHelper)->hydrate($post, $_POST, ['name', 'slug', 'content', 'created_at']);

    // Validation des données
    if ($v->validate()) {
        // Insertion du post dans la base de données
        $postTable->createPost($post);
        header('Location: '.$router->url('admin_posts',['id' => $post->getId()]) .'?created=1');
        exit();
    } else {
        // Récupération des erreurs de validation
        $errors = $v->errors();
    }
}

// Création du formulaire
$form = new Form($post, $errors);
?>

<?php if ($errors): ?>
    <div class="alert alert-danger" onclick="alert('L\'article n\'a pas pu être enregistré.');">
        Votre article n'a pas pu être enregistré.
    </div>
<?php endif; ?>

<!-- Titre de la page -->
<h1>Créer un article</h1>

<?php require '_form.php';
