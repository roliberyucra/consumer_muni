<?php ob_start(); ?>
<?php $title = "Consumer API - Inicio"; ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-4">
  <div class="container-fluid">
    <span class="navbar-brand">Consumer API</span>
    <div class="d-flex">
        <span class="me-3"><b><?=$_SESSION['user']['email']?></b></span>
        <a href="index.php?action=logout" class="btn btn-outline-danger btn-sm">Salir</a>
    </div>
  </div>
</nav>

<?php if(isset($_SESSION['ultimo_token'])): ?>
<div class="alert alert-info text-center mx-5">
    <b>Token actual generado:</b> <?= $_SESSION['ultimo_token'] ?>
</div>
<?php endif; ?>

<div class="row justify-content-center">

    <a href="index.php?action=solicitarToken" class="btn btn-success">Solicitar Token</a>

    <div class="col-md-4">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Tokens</h5>
                <p class="card-text">Administra tus tokens de conexión API</p>
                <a href="index.php?action=tokens" class="btn btn-primary w-100">Ver Tokens guardados</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Consultas</h5>
                <p class="card-text">Realiza consultas al API de municipios usando un Token válido</p>
                <a href="index.php?action=homeConsulta" class="btn btn-success w-100">Consultar Municipios</a>
            </div>
        </div>
    </div>

</div>

<?php $content = ob_get_clean(); include __DIR__."/layout.php"; ?>
