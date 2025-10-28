<!DOCTYPE html>
<html>
<head>
    <title>Login Consumer API</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="public/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row vh-100">

        <!-- columna imagen -->
        <div class="col-md-7 d-none d-md-block p-0">
            <div style="background:url('https://benecar.pt/storage/355191/conversions/01JGNSJGBZ2PT34ZW8A0B0SH5M-webp.webp');background-size:cover;background-position:center;width:100%;height:100%;">
            </div>
        </div>

        <!-- columna form -->
        <div class="col-md-5 d-flex align-items-center justify-content-center">
            <div class="w-75">

                <h2 class="mb-3" style="color:var(--main);font-weight:700;">Consumer API</h2>
                <p class="text-muted mb-4">Accede para consumir la API de municipios</p>

                <?php if(isset($error)){ ?>
                    <div class="alert alert-danger"><?=$error?></div>
                <?php } ?>

                <form method="POST" action="index.php?action=login">

                    <div class="mb-3">
                        <label>Email</label>
                        <input class="form-control" type="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label>Contraseña</label>
                        <input class="form-control" type="password" name="password" required>
                    </div>

                    <button class="btn btn-main w-100 py-2 mt-2">Ingresar</button>
                </form>
            </div>
        </div>

    </div>
</div>

</body>
</html>
