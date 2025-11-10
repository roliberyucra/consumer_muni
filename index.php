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

    // 🔹 Llamar al API principal para generar un nuevo token
    $api_url = "https://www.muni.serviciosvirtuales.com.pe/muni/api.php";
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ["tipo" => "generarToken"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // evitar errores SSL
    $response = curl_exec($ch);

    if ($response === false) {
        die("❌ CURL ERROR: " . curl_error($ch));
    }

    curl_close($ch);

    $json = json_decode($response, true);

    // Validar respuesta del API
    if (!$json || !isset($json["status"]) || $json["status"] !== true) {
        echo "<script>alert('Error al generar token en el API');window.location='index.php?action=tokens';</script>";
        exit;
    }

    // 🔹 Datos recibidos
    $token_api = $json["token"];
    $expira    = $json["expira"];
    $estado    = 1;

    // 🔹 Guardar en BD local del consumer
    $stmt = $pdo->prepare("SELECT id FROM tokens_consumer WHERE id_usuario=?");
    $stmt->execute([$_SESSION['user']['id']]);
    $exists = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($exists) {
        $stmt = $pdo->prepare("UPDATE tokens_consumer SET token=?, expiracion=?, estado=? WHERE id_usuario=?");
        $stmt->execute([$token_api, $expira, $estado, $_SESSION['user']['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO tokens_consumer(id_usuario, token, expiracion, estado) VALUES (?,?,?,?)");
        $stmt->execute([$_SESSION['user']['id'], $token_api, $expira, $estado]);
    }

    // Redirige a la vista tokens
    header("Location: index.php?action=tokens&msg=ok");
    exit;



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
