<?php ob_start(); ?>
<?php $title = "Consumer API - Inicio"; ?>

<style>
    :root {
        --primary: #0d6efd;
        --accent: #0b4fa3;
        --soft-bg: #f7f9fc;
    }

    body {
        background: var(--soft-bg);
    }

    .hero {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        padding: 45px 20px;
        border-radius: 12px;
        color: white;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        margin-bottom: 35px;
        animation: fadeIn .6s ease-in-out;
    }

    .option-card {
        border-radius: 18px;
        transition: .25s;
        border: none;
        overflow: hidden;
    }

    .option-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .icon-circle {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display:flex;
        align-items:center;
        justify-content:center;
        background: rgba(13,110,253,0.15);
        color: var(--primary);
        font-size: 2rem;
        margin: 0 auto 10px;
    }

    @keyframes fadeIn {
        from {opacity:0; transform: translateY(15px);}
        to {opacity:1; transform: translateY(0);}
    }
</style>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
  <div class="container-fluid">
    <span class="navbar-brand fw-bold text-primary">Consumer API</span>
    <div class="d-flex align-items-center">
        <span class="me-3 text-secondary fw-semibold">
            <i class="bi bi-person-circle"></i> <?= $_SESSION['user']['email'] ?>
        </span>
        <a href="index.php?action=logout" class="btn btn-outline-danger btn-sm">Salir</a>
    </div>
  </div>
</nav>

<div class="container">

    <!-- Hero -->
    <div class="hero text-center">
        <h2 class="fw-bold mb-1">Bienvenido al Sistema de Consulta Municipal</h2>
        <p class="mb-0" style="opacity:.9;">Gestiona tus tokens y realiza búsquedas rápidas y seguras</p>
    </div>

    <!-- Mostrar token generado -->
    <?php if(isset($_SESSION['ultimo_token'])): ?>
        <div class="alert alert-info shadow-sm text-center">
            <b>Token generado recientemente:</b><br>
            <?= $_SESSION['ultimo_token'] ?>
        </div>
    <?php endif; ?>

    <!-- Opciones principales -->
    <div class="row justify-content-center mt-4">

        <!-- Tokens -->
        <div class="col-md-4 mb-4">
            <div class="card option-card shadow-sm text-center p-4">
                <div class="icon-circle mb-2">
                    <i class="bi bi-key"></i>
                </div>
                <h5 class="fw-bold">Administrar Tokens</h5>
                <p class="text-muted small mb-3">
                    Visualiza y sincroniza tus tokens de conexión al API principal.
                </p>
                <a href="index.php?action=tokens" class="btn btn-primary w-100">Ver Tokens</a>
            </div>
        </div>

        <!-- Consultas -->
        <div class="col-md-4 mb-4">
            <div class="card option-card shadow-sm text-center p-4">
                <div class="icon-circle mb-2">
                    <i class="bi bi-search"></i>
                </div>
                <h5 class="fw-bold">Consultar Municipios</h5>
                <p class="text-muted small mb-3">
                    Consulta distritos y provincias usando un token activo.
                </p>
                <a href="index.php?action=homeConsulta" class="btn btn-success w-100">Consultar</a>
            </div>
        </div>

    </div>

</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<?php $content = ob_get_clean(); include __DIR__."/layout.php"; ?>
