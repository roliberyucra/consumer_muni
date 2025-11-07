<!DOCTYPE html>
<html>
<head>
    <title>Consulta de Municipios</title>
</head>
<body>

<h2>Consultar Municipios</h2>

<form action="index.php?action=consultarMunicipiosRequest" method="POST">

    <label>Token:</label><br>
    <input type="text" name="token" placeholder="Ingresa tu token" required><br><br>

    <label>Departamento:</label><br>
    <input type="text" name="departamento" placeholder="LIMA" required><br><br>

    <button type="submit">Consultar</button>

</form>

<?php if(isset($result)): ?>

    <h3>Resultado:</h3>

    <?php if(isset($result["status"]) && $result["status"] == true): ?>

        <table border="1">
            <tr>
                <th>ID</th>
                <th>Distrito</th>
                <th>Provincia</th>
                <th>Departamento</th>
            </tr>

            <?php foreach($result['contenido'] as $mun): ?>
                <tr>
                    <td><?= $mun['id'] ?></td>
                    <td><?= $mun['distrito'] ?></td>
                    <td><?= $mun['provincia'] ?></td>
                    <td><?= $mun['departamento'] ?></td>
                </tr>
            <?php endforeach; ?>

        </table>

    <?php else: ?>

        <p style="color:red;"><?= $result['msg'] ?></p>

    <?php endif; ?>

<?php endif; ?>


<br><br>
<a href="index.php?action=home">← Volver</a>

</body>
</html>
