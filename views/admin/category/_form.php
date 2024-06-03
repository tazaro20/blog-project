<form method="post">
    <?= $form->input('name', 'Titre') ?>
    <?= $form->input('slug', 'URL') ?>
    <button type="submit" class="btn btn-primary">
        <?php if ($item->getId() !== null): ?>
            Modifier
        <?php else: ?>
             Ajouter
        <?php endif; ?></button>
</form>