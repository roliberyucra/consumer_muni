<?php ob_start(); ?>
<?php $title = "Token Actual"; ?>

<?php
$url = "https://www.muni.serviciosvirtuales.com.pe/index.php?action=clienteApiRequest";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, ["tipo" => "ultimoToken"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$json = json_decode($response, true);
?>

<h3 class="mb-4">Token actual del sistema</h3>

<?php if($json["status"] == true){ ?>

<table class="table table-bordered">
    <tr>
        <th>Token</th>
        <td><?= $json["token"]; ?></td>
    </tr>
    <tr>
        <th>Expira</th>
        <td><?= $json["expira"]; ?></td>
    </tr>
</table>

<?php } else { ?>

<div class="alert alert-danger">
    <?= $json["msg"]; ?>
</div>

<?php } ?>

<a href="index.php?action=home" class="btn btn-secondary">Volver</a>

<?php $content = ob_get_clean(); include __DIR__."/layout.php"; ?>
