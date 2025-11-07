<?php ob_start(); ?>
<?php $title = "Editar Token"; ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-4">
  <div class="container-fluid">
    <span class="navbar-brand">Consumer API</span>
    <div class="d-flex">
        <a href="index.php?action=logout" class="btn btn-outline-danger btn-sm">Salir</a>
    </div>
  </div>
</nav>

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    Editar Token
                </div>
                <div class="card-body">

                    <form action="index.php?action=updateToken" method="POST">
                        <input type="hidden" name="id" value="<?= $token_bd['id'] ?>">

                        <label class="form-label">Token:</label>
                        <input type="text" name="token" class="form-control" value="<?= $token_bd['token'] ?>" required>

                        <div class="mt-3 text-end">
                            <a href="index.php?action=tokens" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<?php $content = ob_get_clean(); include __DIR__."/layout.php"; ?>
