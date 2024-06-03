<form method="post">
    <?= $form->input('name', 'Titre') ?>
    <?= $form->input('slug', 'URL') ?>
    <?= $form->textarea('content', 'Contenu') ?>
    <?= $form->input('created_at', 'Date de création') ?>

    <button type="submit" class="btn btn-primary">
        <?php if ($post->getId() !== null): ?>
            Modifier
        <?php else: ?>
             Ajouter
        <?php endif; ?></button>
</form>