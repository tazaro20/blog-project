<?php

use App\Model\User;
use App\HTML\Form;
use App\Connection;
use App\Table\UserTable;
use App\Table\Exception\NotFoundException;

$errors = [];
$user = new User();
$form = new Form($user, $errors);

if (!empty($_POST)) {
    $user->setUsername($_POST['username']);
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $table = new UserTable(Connection::getPDO());
        try {
            $u = $table->findByUsername($_POST['username']);
            if (password_verify($_POST['password'], $u->getPassword())) {
                session_start();
                $_SESSION['auth'] = $u->getId();
                header('Location: ' . $router->url('admin_posts'));
                exit();
            } else {
                $errors['password'] = 'Identifiant ou mot de passe incorrect';
            }
        } catch (NotFoundException $e) {
            $errors['password'] = 'Identifiant ou mot de passe incorrect';
        }
    } else {
        $errors['password'] = 'Identifiant ou mot de passe incorrect';
    }
}

?>

<h1>Se connecter</h1>

<?php if (isset($_GET['forbidden'])): ?>
<div class="alert alert-danger">
    vous ne pouvez pas accéder a cette page
</div>
<?php endif; ?>
<form action="" method="post">
    <?= $form->input('username', 'Nom d\'utilisateur') ?>
    <?= $form->input('password', 'Mot de passe') ?>
    <button type="submit" class="btn btn-primary mt-3">Se connecter</button>
</form>
