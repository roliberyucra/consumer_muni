<?php ob_start(); ?>
<?php $title = "Consulta de Municipios"; ?>

<style>
    :root {
        --primary: #0d6efd;
        --accent: #0b4fa3;
        --soft-bg: #f4f7fb;
    }

    body { background: var(--soft-bg); }

    .hero-consulta {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        padding: 40px 35px;
        border-radius: 14px;
        color: white;
        margin-bottom: 35px;
        box-shadow: 0 6px 22px rgba(0,0,0,0.15);
        animation: fadeIn .6s ease-in-out;
    }

    .consulta-card {
        border-radius: 18px;
        border: none;
        transition: .25s;
    }

    .consulta-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.12);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .btn-more {
        padding: 4px 10px;
        font-size: 13px;
    }
</style>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold text-primary">Consumer API</span>

        <div class="d-flex">
            <a href="index.php?action=home" class="btn btn-outline-primary btn-sm me-2">🏠 Inicio</a>
            <a href="index.php?action=logout" class="btn btn-outline-danger btn-sm">Salir</a>
        </div>
    </div>
</nav>

<div class="container py-4">

    <!-- HERO -->
    <div class="hero-consulta">
        <h2 class="fw-bold mb-1">🔍 Consulta de Municipios</h2>
        <p class="mb-0" style="opacity:.90;">Realiza búsquedas rápidas y seguras usando tu token de acceso.</p>
    </div>

    <?php
    // Obtener token local
    require __DIR__ . '/../../config/config.php';
    $stmt = $pdo->prepare("
        SELECT token 
        FROM tokens_consumer 
        WHERE id_usuario = ? 
        ORDER BY fecha_guardado DESC 
        LIMIT 1
    ");
    $stmt->execute([ $_SESSION['user']['id'] ]);
    $tokenRow = $stmt->fetch(PDO::FETCH_ASSOC);
    $token = $tokenRow['token'] ?? '';
    ?>

    <div class="row justify-content-center">
        <div class="col-md-7">

            <!-- FORM CARD -->
            <div class="card consulta-card shadow-sm mb-4">
                <div class="card-body p-4">

                    <?php if(!$token): ?>
                        <div class="alert alert-warning">
                            ⚠️ No tienes un token activo.
                            <a href="index.php?action=tokens" class="alert-link">Actualízalo aquí</a>.
                        </div>
                    <?php endif; ?>

                    <form action="index.php?action=consultarMunicipiosRequest" method="POST">

                        <!-- TOKEN HIDDEN -->
                        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Departamento</label>
                            <input 
                                type="text" 
                                class="form-control form-control-lg" 
                                name="departamento" 
                                placeholder="Ejemplo: LIMA" 
                                required>
                        </div>

                        <div class="text-end mt-3">
                            <a href="index.php?action=home" class="btn btn-secondary">Volver</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Consultar
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <!-- RESULTADOS -->
            <?php if(isset($result)): ?>
                <div class="card shadow-sm consulta-card">
                    <div class="card-header bg-dark text-white">
                        <b>Resultados de la búsqueda</b>
                    </div>

                    <div class="card-body">

                        <?php if(isset($result["status"]) && $result["status"] == true): ?>

                            <table class="table table-hover table-striped align-middle">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th>ID</th>
                                        <th>Distrito</th>
                                        <th>Provincia</th>
                                        <th>Depto</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach($result['contenido'] as $mun): ?>
                                        <tr>
                                            <td class="text-center fw-bold"><?= $mun['id'] ?></td>
                                            <td><?= $mun['distrito'] ?></td>
                                            <td><?= $mun['provincia'] ?></td>
                                            <td><?= $mun['departamento'] ?></td>
                                            <td class="text-center">
                                                <button 
                                                    class="btn btn-sm btn-primary btn-more"
                                                    onclick='verMunicipio(<?= json_encode($mun) ?>)'
                                                >
                                                    🔍 Ver más
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>

                        <?php else: ?>
                            <div class="alert alert-danger text-center">
                                ❌ <?= $result['msg'] ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

</div>

<!-- MODAL DETALLES MUNICIPIO -->
<div class="modal fade" id="modalMunicipio" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">📍 Detalles del Municipio</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body" id="modalBodyMunicipio" style="font-size: 16px;"></div>

        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>

    </div>
  </div>
</div>

<!-- Bootstrap Icons + Modal JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script>
function verMunicipio(data) {
    let html = `
        <p><b>ID:</b> ${data.id}</p>
        <p><b>Distrito:</b> ${data.distrito}</p>
        <p><b>Provincia:</b> ${data.provincia}</p>
        <p><b>Departamento:</b> ${data.departamento}</p>
    `;

    document.getElementById("modalBodyMunicipio").innerHTML = html;
    let modal = new bootstrap.Modal(document.getElementById('modalMunicipio'));
    modal.show();
}
</script>

<?php $content = ob_get_clean(); include __DIR__."/layout.php"; ?>
