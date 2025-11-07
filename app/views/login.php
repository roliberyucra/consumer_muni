<!DOCTYPE html>
<html>
<head>
<title>Login Consumer API</title>
</head>
<body>

<h2>Login</h2>

<form method="POST" action="index.php?action=login">
    Email:<br>
    <input type="email" name="email" required><br><br>

    Contraseña:<br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Ingresar</button>
</form>

<?php if(isset($error)){ echo "<p style='color:red'>$error</p>"; } ?>

</body>
</html>
