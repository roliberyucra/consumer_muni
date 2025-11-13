<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();

require_once __DIR__ . "/config/config.php";
require_once __DIR__ . "/app/controllers/AuthController.php";
require_once __DIR__ . "/app/controllers/ApiConsumeController.php";

$authController = new AuthController($pdo);
$apiController  = new ApiConsumeController($pdo);

$action = $_GET['action'] ?? 'loginForm';

switch($action){

/* ==========================================================
   🟢 SOLICITAR TOKEN NUEVO (genera uno desde el API)
   ========================================================== */
case 'solicitarToken':
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?action=loginForm");
        exit;
    }

    // Llamar al API principal para generar token nuevo
    $ch = curl_init("https://www.muni.serviciosvirtuales.com.pe/api.php");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ["tipo" => "generarToken"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response, true);

    if (!$json || !isset($json["status"])) {
        echo "<script>alert('No hubo respuesta válida del servidor API.');window.location='index.php?action=tokens';</script>";
        exit;
    }

    if ($json["status"] === true) {
        $token_api = $json["token"];
        $expira    = $json["expira"] ?? null;

        // Guardar o actualizar token local
        $stmt = $pdo->prepare("SELECT id FROM tokens_consumer WHERE id_usuario=?");
        $stmt->execute([$_SESSION['user']['id']]);
        $exists = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($exists) {
            $stmt = $pdo->prepare("UPDATE tokens_consumer SET token=?, fecha_guardado=NOW() WHERE id_usuario=?");
            $stmt->execute([$token_api, $_SESSION['user']['id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO tokens_consumer (id_usuario, token, fecha_guardado) VALUES (?, ?, NOW())");
            $stmt->execute([$_SESSION['user']['id'], $token_api]);
        }

        header("Location: index.php?action=tokens&msg=nuevo");
        exit;
    } else {
        echo "<script>alert('Error al generar el token: " . ($json['msg'] ?? 'Desconocido') . "');window.location='index.php?action=tokens';</script>";
        exit;
    }
    break;


/* ==========================================================
   🔄 ACTUALIZAR TOKEN LOCAL (sincroniza con API principal)
   ========================================================== */
case 'actualizarToken':
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?action=loginForm");
        exit;
    }

    $api_url = "https://www.muni.serviciosvirtuales.com.pe/api.php?tipo=getLastToken";
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response, true);

    if (!$json || !isset($json["status"]) || $json["status"] !== true) {
        echo "<script>alert('No se pudo obtener el token desde el API.');window.location='index.php?action=tokens';</script>";
        exit;
    }

    $token_api = $json["token"];
    $expira    = $json["expiracion"] ?? null;
    $estado    = $json["estado"] ?? 0;

    // Guardar o actualizar en la BD local
    $stmt = $pdo->prepare("SELECT id FROM tokens_consumer WHERE id_usuario=?");
    $stmt->execute([$_SESSION['user']['id']]);
    $exists = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($exists) {
        $stmt = $pdo->prepare("UPDATE tokens_consumer SET token=?, expiracion=?, estado=?, fecha_guardado=NOW() WHERE id_usuario=?");
        $stmt->execute([$token_api, $expira, $estado, $_SESSION['user']['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO tokens_consumer (id_usuario, token, expiracion, estado, fecha_guardado) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$_SESSION['user']['id'], $token_api, $expira, $estado]);
    }

    header("Location: index.php?action=tokens&msg=ok");
    exit;
    break;


/* ==========================================================
   🧾 LISTADO DE TOKENS LOCALES
   ========================================================== */
case 'tokens':
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?action=loginForm");
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM tokens_consumer WHERE id_usuario = ?");
    $stmt->execute([ $_SESSION['user']['id'] ]);
    $tokens = $stmt->fetchAll(PDO::FETCH_ASSOC);

    include __DIR__."/app/views/tokens.php";
    break;


/* ==========================================================
   🔑 LOGIN / LOGOUT / HOME / CONSULTAS
   ========================================================== */
case 'loginForm':
    $authController->loginForm();
    break;

case 'login':
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $authController->login($_POST);
    }
    break;

case 'logout':
    $authController->logout();
    break;

case 'home':
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?action=loginForm");
        exit;
    }
    $apiController->form();
    break;

case 'homeConsulta':
    include __DIR__."/app/views/consulta_form.php";
    break;

case 'consultarApi':
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?action=loginForm");
        exit;
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $apiController->consultar($_POST);
    }
    break;

case 'consultarMunicipiosRequest':
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?action=loginForm");
        exit;
    }
    $apiController->consultar($_POST);
    break;


/* ==========================================================
   ⚠️ DEFAULT
   ========================================================== */
default:
    echo "Acción no válida.";
}
?>
