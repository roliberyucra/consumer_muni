<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'App' ?></title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- estilos propios -->
    <style>
        body { background:#f2f2f2; }
        .container{ margin-top:40px; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <span class="navbar-brand">Consumer API</span>
    <?php if(isset($_SESSION['user'])){ ?>
    <a href="index.php?action=logout" class="btn btn-outline-light btn-sm">Salir</a>
    <?php } ?>
  </div>
</nav>

<div class="container">
    <?= $content ?>
</div>

</body>
</html>
