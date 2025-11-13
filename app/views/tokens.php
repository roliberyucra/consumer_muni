<?php ob_start(); ?> 
<?php $title = "Gestión de Token"; ?>

<div class="container py-5">

    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold text-primary mb-3">🔐 Token de Conexión</h2>
            <p class="text-muted">Tu token local está sincronizado con el sistema principal (API).</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="index.php?action=solicitarToken" class="btn btn-success me-2">
                <i class="bi bi-plus-circle"></i> Generar Nuevo Token
            </a>
            <a href="index.php?action=actualizarToken" class="btn btn-info text-white">
                <i class="bi bi-arrow-repeat"></i> Actualizar Token
            </a>
        </div>
    </div>

    <?php
    // Obtener el token local desde BD
    $stmt = $pdo->prepare("SELECT * FROM tokens_consumer WHERE id_usuario=? ORDER BY id DESC LIMIT 1");
    $stmt->execute([$_SESSION['user']['id']]);
    $token = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>

    <div class="card border-0 shadow-lg">
        <div class="card-body text-center py-5" style="background: #f9f9f9;">

            <?php if($token): ?>
                <div class="mb-3">
                    <span class="badge <?= $token['estado']==1 ? 'bg-success' : 'bg-danger' ?> p-2">
                        <?= $token['estado']==1 ? '🟢 ACTIVO' : '🔴 INACTIVO' ?>
                    </span>
                </div>

                <h5 class="fw-semibold text-secondary mb-3">Token actual:</h5>
                <code class="fs-5 d-block text-break mb-4"><?= htmlspecialchars($token["token"]) ?></code>

                <p class="mb-2"><b>Expira:</b> <?= htmlspecialchars($token["expiracion"]) ?></p>
                <p class="text-muted">Este token fue generado desde el sistema principal y sincronizado localmente.</p>

            <?php else: ?>
                <div class="alert alert-warning shadow-sm">
                    No hay tokens registrados localmente.
                </div>
            <?php endif; ?>

        </div>
    </div>

    <div class="text-center mt-4">
        <a href="index.php?action=home" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver al Inicio
        </a>
    </div>

</div>

<!-- Bootstrap Icons + SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if(isset($_GET['msg']) && $_GET['msg'] == 'ok'): ?>
<script>
Swal.fire({
  title: "Token actualizado",
  text: "El token fue sincronizado correctamente con el sistema principal.",
  icon: "success",
  confirmButtonColor: "#197b7d"
});
</script>
<?php endif; ?>

<?php $content = ob_get_clean(); include __DIR__."/layout.php"; ?>
