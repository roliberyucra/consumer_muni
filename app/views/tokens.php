<?php ob_start(); ?> 
<?php $title = "Gestión de Token"; ?>

<style>
    :root {
        --primary: #0d6efd;
        --accent: #0b4fa3;
        --soft-bg: #f4f7fb;
    }

    body {
        background: var(--soft-bg);
    }

    .token-hero {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        padding: 45px 35px;
        border-radius: 14px;
        color: white;
        margin-bottom: 35px;
        box-shadow: 0 6px 22px rgba(0,0,0,0.15);
        animation: fadeIn .6s ease-in-out;
    }

    .token-card {
        border-radius: 18px;
        border: none;
        overflow: hidden;
        transition: .25s;
    }

    .token-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.12);
    }

    .badge-status {
        font-size: 1rem;
        padding: 8px 15px;
        border-radius: 30px;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container py-4">

    <!-- HERO SUPERIOR -->
    <div class="token-hero">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="fw-bold mb-1">🔐 Gestión del Token de Acceso</h2>
                <p class="mb-0" style="opacity:.9;">Token sincronizado con el sistema principal</p>
            </div>

            <div class="mt-3 mt-md-0">
                <a href="index.php?action=actualizarToken" class="btn btn-light fw-semibold shadow-sm">
                    <i class="bi bi-arrow-repeat"></i> Actualizar token
                </a>
            </div>
        </div>
    </div>

    <?php
    // Leer token local
    $stmt = $pdo->prepare("SELECT * FROM tokens_consumer WHERE id_usuario=? ORDER BY id DESC LIMIT 1");
    $stmt->execute([$_SESSION['user']['id']]);
    $token = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>

    <!-- TARJETA PRINCIPAL DEL TOKEN -->
    <div class="card token-card shadow-sm">
        <div class="card-body p-5 text-center">

            <?php if($token): ?>

                <!-- Estado -->
                <div class="mb-3">
                    <span class="badge-status <?= $token['estado']==1 ? 'bg-success' : 'bg-danger' ?>">
                        <?= $token['estado']==1 ? "🟢 Token Activo" : "🔴 Token Inactivo" ?>
                    </span>
                </div>

                <h5 class="fw-bold text-secondary">Token actual</h5>

                <code class="fs-5 d-block text-break my-3 p-3 bg-light border rounded">
                    <?= htmlspecialchars($token["token"]) ?>
                </code>

                <p class="mb-1"><b>Expiración:</b> <?= htmlspecialchars($token["expiracion"]) ?></p>
                <p class="text-muted small">Este token fue emitido por el sistema principal y está almacenado localmente.</p>

            <?php else: ?>

                <div class="alert alert-warning shadow-sm">
                    No hay tokens registrados en el sistema.
                </div>

            <?php endif; ?>

        </div>
    </div>

    <!-- VOLVER -->
    <div class="text-center mt-4">
        <a href="index.php?action=home" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver al Inicio
        </a>
    </div>

</div>

<!-- Bootstrap Icons & SweetAlert -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if(isset($_GET['msg']) && $_GET['msg'] == 'ok'): ?>
<script>
Swal.fire({
    title: "Token actualizado",
    text: "El token fue sincronizado correctamente con el API principal.",
    icon: "success",
    confirmButtonColor: "#0d6efd"
});
</script>
<?php endif; ?>

<?php $content = ob_get_clean(); include __DIR__."/layout.php"; ?>
