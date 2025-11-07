<!DOCTYPE html>
<html>
<head>
    <title>Consumer API</title>
</head>
<body>

<h2>Consumer API</h2>

<p>Bienvenido: <?=$_SESSION['user']['email']?></p>

<a href="index.php?action=tokens">
    <button>Ver tokens guardados</button>
</a>

<a href="index.php?action=homeConsulta">
    <button>Consultar Municipios</button>
</a>

<a href="index.php?action=logout">
    <button>Salir</button>
</a>

</body>
</html>

