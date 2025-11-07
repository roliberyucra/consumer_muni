<!DOCTYPE html>
<html>
<head>
<title>Mis Tokens</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2>Tokens Registrados</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Token</th>
            <th>Fecha Registro</th>
        </tr>
    </thead>
    <tbody>
    <?php if(count($tokens) > 0): ?>
        <?php foreach($tokens as $t): ?>
        <tr>
            <td><?= $t['id'] ?></td>
            <td><?= $t['token'] ?></td>
            <td><?= $t['fecha_registro'] ?></td>
        </tr>
        <?php endforeach;?>
    <?php else: ?>
        <tr>
            <td colspan="3">No tienes tokens guardados</td>
        </tr>
    <?php endif;?>
    </tbody>
</table>

<a href="index.php?action=home" class="btn btn-secondary">Volver</a>

</body>
</html>
