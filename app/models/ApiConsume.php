<?php

class ApiConsume {

    private $pdo;
    private $apiBase = "https://www.muni.serviciosvirtuales.com.pe/api.php";

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function consultarMunicipios($departamento, $token) {

        $fields = [
            "tipo"  => "verMunicipiosByDepartamento",
            "data"  => $departamento,
            "token" => $token
        ];

        $ch = curl_init($this->apiBase);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if($response === false){
            echo "<pre>CURL ERROR: ".curl_error($ch)."</pre>";
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        return json_decode($response, true);
    }

}
