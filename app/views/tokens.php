<?php ob_start(); ?>
<?php $title = "Último Token"; ?>

<?php
$ch = curl_init("https://www.muni.serviciosvirtuales.com.pe/muni/api.php?tipo=getLastToken");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$json = json_decode($response,true);
?>

<h3>Último Token Registrado</h3>
<hr>

<?php if($json && $json["status"]==true): ?>

<div class="alert alert-info shadow-sm">
    <b>Token:</b><br>
    <code style="font-size:18px"><?= $json["token"] ?></code>
    <br><br>
    <b>Estado:</b> <?= ($json["estado"]==1?"Activo":"Inactivo") ?><br>
    <b>Expiración:</b> <?= $json["expiracion"] ?>
</div>

<a href="index.php?action=solicitarToken" class="btn btn-success">
    Generar Token Nuevo
</a>

<?php else: ?>

<div class="alert alert-danger shadow-sm">
    No hay tokens generados todavía
</div>

<a href="index.php?action=solicitarToken" class="btn btn-primary">
    Generar Token Ahora
</a>

<?php endif; ?>


<a href="index.php?action=home" class="btn btn-secondary mt-3">Volver</a>

<?php $content = ob_get_clean(); include __DIR__."/layout.php"; ?>
