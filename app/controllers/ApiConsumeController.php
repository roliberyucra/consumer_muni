<?php 
require_once __DIR__ . '/../models/ApiConsume.php';

class ApiConsumeController {

    private $model;

    public function __construct($pdo) {
        $this->model = new ApiConsume($pdo);
    }

    public function form() {
        include __DIR__ . '/../views/home.php';
    }

    public function consultar($data) {

        $departamento = trim($data['departamento']);
        $token = trim($data['token']); // ←  AQUI LO AGARRAMOS DEL FORM

        if ($departamento == "" || $token == "") {
            $error = "Ingrese token y departamento";
            include __DIR__ . '/../views/consulta_form.php';
            return;
        }

        // ahora SI mandamos 2 parámetros
        $result = $this->model->consultarMunicipios($departamento, $token);

        // regresamos a la misma vista donde está el formulario
        include __DIR__ . '/../views/consulta_form.php';
    }
}
