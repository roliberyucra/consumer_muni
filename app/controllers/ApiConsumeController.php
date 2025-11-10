<?php 
require_once __DIR__ . '/../models/ApiConsume.php';

class ApiConsumeController {

    private $model;
    private $pdo;

    public function __construct($pdo) {
        $this->model = new ApiConsume($pdo);
        $this->pdo   = $pdo;
    }

    /**
     * Mostrar formulario de consulta con token precargado
     */
    public function form() {
        // 🔹 Obtener token activo del usuario actual
        $stmt = $this->pdo->prepare("
            SELECT token 
            FROM tokens_consumer 
            WHERE id_usuario = ? 
            ORDER BY id DESC 
            LIMIT 1
        ");
        $stmt->execute([ $_SESSION['user']['id'] ]);
        $tokenRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $token = $tokenRow['token'] ?? '';

        include __DIR__ . '/../views/consulta_form.php';
    }

    /**
     * Procesar la consulta de municipios
     */
    public function consultar($data) {
        $departamento = trim($data['departamento']);
        $token = trim($data['token']);

        if ($departamento == "" || $token == "") {
            $error = "Ingrese token y departamento";
            include __DIR__ . '/../views/consulta_form.php';
            return;
        }

        // 🔹 Consultar municipios desde el modelo
        $result = $this->model->consultarMunicipios($departamento, $token);

        // 🔹 Volver a mostrar el formulario con resultados
        $stmt = $this->pdo->prepare("
            SELECT token 
            FROM tokens_consumer 
            WHERE id_usuario = ? 
            ORDER BY id DESC 
            LIMIT 1
        ");
        $stmt->execute([ $_SESSION['user']['id'] ]);
        $tokenRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $token = $tokenRow['token'] ?? '';

        include __DIR__ . '/../views/consulta_form.php';
    }

}
