<?php ob_start(); ?>
<?php $title = "Mis Tokens"; ?>

<h3 class="mb-4">Token activo del API</h3>

<?php
// pedir al API el token activo existente
$ch = curl_init("https://www.muni.serviciosvirtuales.com.pe/api.php");

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    "tipo" => "getActiveToken"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$curlError = curl_error($ch);
curl_close($ch);

if($curlError){
    echo "<div class='alert alert-danger'>Error de conexión con API: $curlError</div>";
    $json = null;
}else{
    $json = json_decode($response, true);
}
?>

<div class="card p-4 shadow-sm">

    <?php if(is_array($json) && isset($json["status"]) && $json["status"] == true): ?>

        <div class="alert alert-success">
            Token activo del API:
        </div>

        <h5 class="text-primary fw-bold">
            <?= htmlspecialchars($json["token"]) ?>
        </h5>

        <a href="index.php?action=solicitarToken" class="btn btn-danger mt-3">
            Generar nuevo token
        </a>

    <?php else: ?>

        <div class="alert alert-danger">
            No hay tokens activos actualmente
        </div>

        <a href="index.php?action=solicitarToken" class="btn btn-success mt-3">
            Generar token nuevo
        </a>

    <?php endif; ?>
</div>

<a href="index.php?action=home" class="btn btn-secondary mt-4">← volver</a>

<?php $content = ob_get_clean(); include __DIR__."/layout.php"; ?>
