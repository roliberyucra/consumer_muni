<?php ob_start(); ?> 
<?php $title = "Gestión de Token"; ?>

<?php
// Llamamos al API para obtener el último token
$api_url = "https://www.muni.serviciosvirtuales.com.pe/muni/api.php?tipo=getLastToken";
$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$json = json_decode($response, true);

// Preparamos alertas visuales
$alert = null;
if(isset($_GET['msg'])){
    $alert = [
        "title" => "Token actualizado",
        "text" => "El token ha sido sincronizado correctamente.",
        "icon" => "success"
    ];
}
?>

<div class="container py-5">

    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold text-primary mb-3">🔐 Token de Conexión</h2>
            <p class="text-muted">Administra y sincroniza tu token de acceso con el sistema principal (API).</p>
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

    <div class="card border-0 shadow-lg">
        <div class="card-body text-center py-5" style="background: #f9f9f9;">

            <?php if($json && $json["status"]==true): ?>
                <div class="mb-3">
                    <span class="badge <?= $json["estado"]==1 ? 'bg-success' : 'bg-danger' ?> p-2">
                        <?= $json["estado"]==1 ? '🟢 ACTIVO' : '🔴 INACTIVO' ?>
                    </span>
                </div>

                <h5 class="fw-semibold text-secondary mb-3">Token actual:</h5>
                <code class="fs-5 d-block text-break mb-4"><?= htmlspecialchars($json["token"]) ?></code>

                <p class="mb-2"><b>Expira:</b> <?= htmlspecialchars($json["expiracion"]) ?></p>
                <p class="text-muted">Este token se generó desde el sistema principal y tiene duración de 1 hora.</p>

            <?php else: ?>
                <div class="alert alert-warning shadow-sm">
                    No hay tokens generados todavía.
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

<?php if(isset($alert)): ?>
<script>
Swal.fire({
  title: "<?= $alert['title'] ?>",
  text: "<?= $alert['text'] ?>",
  icon: "<?= $alert['icon'] ?>",
  confirmButtonColor: "#197b7d"
});
</script>
<?php endif; ?>

<?php $content = ob_get_clean(); include __DIR__."/layout.php"; ?>
