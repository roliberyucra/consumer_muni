<?php ob_start(); ?>
<?php $title = "Login - Consumer API"; ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-4">

        <div class="card shadow-sm">
            <div class="card-header text-center">
                <h4 class="m-0">Consumer API</h4>
            </div>

            <div class="card-body">

                <?php if(isset($error)){ ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php } ?>

                <form method="POST" action="index.php?action=login">

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input class="form-control" type="password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                </form>

            </div>
        </div>

    </div>
</div>

<?php $content = ob_get_clean(); include __DIR__."/layout.php"; ?>
