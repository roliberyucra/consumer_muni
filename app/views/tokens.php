<?php ob_start(); ?>
<?php $title = "Token Activo"; ?>

<?php
// CONSULTAR TOKEN ACTIVO EN EL API
$ch = curl_init("https://www.muni.serviciosvirtuales.com.pe/muni/api.php?tipo=getActiveToken");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$json = json_decode($response, true);
?>

<h3>Token Activo</h3>
<hr>

<?php if($json["status"]==true): ?>

<div class="alert alert-success shadow-sm">
    <b>Token Actual:</b><br>
    <code style="font-size:18px"><?= $json["token"] ?></code>
</div>

<p>
    <a href="index.php?action=solicitarToken" class="btn btn-warning">
        Generar Nuevo Token
    </a>
</p>

<?php else: ?>

<div class="alert alert-danger shadow-sm">
    No hay tokens activos actualmente.
</div>

<p>
    <a href="index.php?action=solicitarToken" class="btn btn-success">
        Generar Token Ahora
    </a>
</p>

<?php endif; ?>


<a href="index.php?action=home" class="btn btn-secondary mt-3">Volver</a>

<?php $content = ob_get_clean(); include __DIR__."/layout.php"; ?>
