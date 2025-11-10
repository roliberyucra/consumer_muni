<?php ob_start(); ?>
<?php $title = "Consulta de Municipios"; ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-4">
  <div class="container-fluid">
    <span class="navbar-brand">Consumer API</span>
    <div class="d-flex">
        <a href="index.php?action=home" class="btn btn-outline-secondary btn-sm me-2">Inicio</a>
        <a href="index.php?action=logout" class="btn btn-outline-danger btn-sm">Salir</a>
    </div>
  </div>
</nav>

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span>Consultar Municipios</span>
                    <a href="index.php?action=actualizarToken" class="btn btn-sm btn-warning text-white">
                        🔄 Actualizar Token
                    </a>
                </div>

                <div class="card-body">

                    <?php if(empty($token)): ?>
                        <div class="alert alert-warning">
                            ⚠️ No tienes un token activo. 
                            <a href="index.php?action=tokens" class="alert-link">Actualízalo aquí</a>.
                        </div>
                    <?php endif; ?>

                    <form action="index.php?action=consultarMunicipiosRequest" method="POST">

                        <!-- TOKEN AUTOMÁTICO -->
                        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                        <div class="mb-3">
                            <label class="form-label">Departamento</label>
                            <input type="text" class="form-control" name="departamento" placeholder="Ej: LIMA" required>
                        </div>

                        <div class="text-end">
                            <a href="index.php?action=home" class="btn btn-secondary">Volver</a>
                            <button type="submit" class="btn btn-success">Consultar</button>
                        </div>
                    </form>

                </div>
            </div>

            <?php if(isset($result)): ?>
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        Resultado
                    </div>
                    <div class="card-body">

                        <?php if(isset($result["status"]) && $result["status"] == true): ?>
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Distrito</th>
                                        <th>Provincia</th>
                                        <th>Departamento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($result['contenido'] as $mun): ?>
                                    <tr>
                                        <td><?= $mun['id'] ?></td>
                                        <td><?= $mun['distrito'] ?></td>
                                        <td><?= $mun['provincia'] ?></td>
                                        <td><?= $mun['departamento'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="alert alert-danger">
                                <?= $result['msg'] ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

</div>

<?php $content = ob_get_clean(); include __DIR__."/layout.php"; ?>
