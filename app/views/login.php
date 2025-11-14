<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingreso al Sistema | Consumer API</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos personalizados -->
    <style>
        :root {
            --primary: #0d6efd;
            --accent: #0b4fa3;
            --bg-soft: #eef3f8;
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #0d6efd 0%, #0b4fa3 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Segoe UI", sans-serif;
        }

        .login-wrapper {
            max-width: 420px;
            width: 100%;
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0px 10px 25px rgba(0,0,0,0.15);
            animation: fadeIn .65s ease-in-out;
        }

        .header-logo {
            width: 80px;
            height: 80px;
            background: var(--primary);
            border-radius: 50%;
            display:flex;
            align-items:center;
            justify-content:center;
            color:white;
            font-size:2rem;
            margin: 0 auto 10px;
        }

        .title {
            text-align: center;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            font-size: .9rem;
            color: #6c757d;
            margin-bottom: 25px;
        }

        .btn-login {
            background: var(--primary);
            color: white;
            font-weight: 600;
            letter-spacing: .5px;
        }

        .btn-login:hover {
            background: var(--accent);
            color: #fff;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(25px);}
            to { opacity: 1; transform: translateY(0);}
        }
    </style>
</head>

<body>

<div class="login-wrapper">

    <div class="header-logo">
        <i class="bi bi-building"></i>
    </div>

    <h3 class="title">Busca MUNI</h3>
    <p class="subtitle">Acceso al sistema de consulta de municipalidades</p>

    <?php if(isset($error)): ?>
        <div class="alert alert-danger text-center p-2">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?action=login">

        <div class="mb-3">
            <label class="form-label fw-semibold">Correo electrónico</label>
            <input type="email" name="email" class="form-control" required placeholder="correo*">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Contraseña</label>
            <input type="password" name="password" class="form-control" required placeholder="contraseña*">
        </div>

        <button class="btn btn-login w-100 py-2 mt-2">Ingresar</button>
    </form>

</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</body>
</html>
