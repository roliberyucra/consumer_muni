<?php ob_start(); ?>
<?php $title = "Agregar nuevo Token"; ?>

<h3 class="mb-3">Agregar nuevo Token</h3>

<?php if(isset($error)){ ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php } ?>

<?php if(isset($success)){ ?>
<div class="alert alert-success"><?= $success ?></div>
<?php } ?>

<form action="index.php?action=saveToken" method="POST" class="bg-white p-4 rounded shadow-sm" style="max-width:500px">
    
    <div class="mb-3">
        <label class="form-label">Token del API</label>
        <input type="text" class="form-control" name="token" placeholder="PEGA AQUÍ EL TOKEN" required>
        <small class="text-muted">Ejemplo: a7389c03e0c1813ad1b3-20250101-2</small>
    </div>

    <button type="submit" class="btn btn-success">Guardar Token</button>
    <a href="index.php?action=tokens" class="btn btn-secondary ms-2">Cancelar</a>

</form>

<?php $content = ob_get_clean(); include __DIR__."/layout.php"; ?>
