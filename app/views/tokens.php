<!DOCTYPE html>
<html>
<head>
<title>Mis Tokens</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2>Tokens Registrados</h2>

<table table bordered>
<tr>
    <th>ID</th>
    <th>Token</th>
    <th>Acción</th>
</tr>

<?php foreach($tokens as $t){ ?>
<tr>
    <td><?= $t['id'] ?></td>
    <td><?= $t['token'] ?></td>
    <td>
        <a href="index.php?action=editTokenForm&id=<?= $t['id'] ?>">Editar</a>
    </td>
</tr>
<?php } ?>

</table>


<a href="index.php?action=home" class="btn btn-secondary">Volver</a>

</body>
</html>
