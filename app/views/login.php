<!DOCTYPE html>
<html>
<head>
    <title>Login Consumer API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --main: #197b7d; }

        body{
            margin:0;
            padding:0;
            background:url('https://wallpapers.com/images/hd/4k-bmw-car-in-dark-c0ot64ri2fecu1pr.jpg');
            background-size:cover;
            background-position:center;
            height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            backdrop-filter: blur(1px);
        }

        .login-card{
            color: white;
            background: rgba(255,255,255,.25);
            border-radius: 14px;
            padding:35px;
            width: 380px;
            backdrop-filter: blur(10px);
            border:1px solid rgba(255,255,255,.30);
            box-shadow: 0 0 25px rgba(0,0,0,.3);
        }

        .btn-main{
            background:var(--main);
            color:white;
            font-weight:600;
        }
        .btn-main:hover{
            opacity:.85;
            background: white;
            color: #197b7d;
        }
    </style>
</head>

<body>

    <div class="login-card">

        <h3 class="text-center mb-4" style="color:var(--main); font-weight:800;">
            Consumer API
        </h3>

        <?php if(isset($error)){ ?>
            <div class="alert alert-danger p-2 text-center"><?=$error?></div>
        <?php } ?>

        <form method="POST" action="index.php?action=login">

            <div class="mb-3">
                <label class="fw-bold">Email</label>
                <input class="form-control form-control-sm" type="email" name="email" required>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Contraseña</label>
                <input class="form-control form-control-sm" type="password" name="password" required>
            </div>

            <button class="btn btn-main w-100 py-1 mt-2">Ingresar</button>
        </form>

    </div>

</body>
</html>
