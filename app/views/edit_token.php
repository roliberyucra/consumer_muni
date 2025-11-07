<!DOCTYPE html>
<html>
<head>
    <title>Editar Token</title>
</head>
<body>

<h2>Editar Token</h2>

<form action="index.php?action=updateToken" method="POST">
    <input type="hidden" name="id" value="<?= $token_bd['id'] ?>">

    <label>Token:</label>
    <input type="text" name="token" value="<?= $token_bd['token'] ?>" style="width:400px">

    <br><br>

    <button type="submit">Guardar Cambios</button>
</form>

<br>
<a href="index.php?action=tokens">Volver</a>

</body>
</html>
