<?php ob_start(); ?>
<?php $title = "Mis Tokens"; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Mis Tokens</h3>
<!-- <a href="index.php?action=newTokenForm" class="btn btn-success btn-sm">+ Nuevo Token</a> -->
</div>

<table class="table table-striped table-bordered bg-white shadow-sm">
    <thead class="table-dark">
    <tr>
        <th>ID</th>
        <th>Token</th>
        <th class="text-center">Acción</th>
    </tr>
    </thead>

    <tbody>
    <?php foreach($tokens as $t){ ?>
    <tr>
        <td><?= $t['id'] ?></td>
        <td><?= $t['token'] ?></td>
        <td class="text-center">
            <a href="index.php?action=editTokenForm&id=<?= $t['id'] ?>" class="btn btn-primary btn-sm">
                Editar
            </a>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>

<a href="index.php?action=home" class="btn btn-secondary mt-3">Volver</a>

<?php $content = ob_get_clean(); include __DIR__."/layout.php"; ?>
