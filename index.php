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

    case 'solicitarToken':
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?action=loginForm");
        exit;
    }

    $ch = curl_init("http://127.0.0.1:8888/muni/api.php");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        "tipo" => "generarToken"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response, true);

if(!is_array($json)){
    $mensaje = "No hubo respuesta válida del servidor API";
    include __DIR__."/app/views/home.php";
    break;
}

if(isset($json["status"]) && $json["status"] == true){
    $_SESSION['ultimo_token'] = $json["token"] ?? "";
    $mensaje = "Token generado correctamente!";
} else {
    $mensaje = $json["msg"] ?? "Error desconocido al generar token";
}

include __DIR__."/app/views/home.php";
break;



    case 'tokens':
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=loginForm");
            exit;
        }
    
        // traer tokens del usuario logueado
        $stmt = $pdo->prepare("SELECT * FROM tokens_consumer WHERE id_usuario = ?");
        $stmt->execute([ $_SESSION['user']['id'] ]);
        $tokens = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        include __DIR__."/app/views/tokens.php";
        break;
    
    
    case 'newTokenForm':
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=loginForm");
            exit;
        }
        include __DIR__."/app/views/new_token.php";
        break;

    case 'homeConsulta':
        include __DIR__."/app/views/consulta_form.php";
        break;

        case 'saveToken':

            if (!isset($_SESSION['user'])) {
                header("Location: index.php?action=loginForm");
                exit;
            }
        
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
                $token = trim($_POST['token']);
        
                if($token == ""){
                    $error = "Token vacío";
                    include __DIR__."/app/views/new_token.php";
                    exit;
                }
        
                // insertarlo en la BD consumer
                $stmt = $pdo->prepare("INSERT INTO tokens_consumer(id_usuario, token) VALUES(?,?)");
                $stmt->execute([ $_SESSION['user']['id'], $token ]);
        
                $success = "Token guardado correctamente";
                include __DIR__."/app/views/new_token.php";
            }
        
            break;

        case 'editTokenForm':
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?action=loginForm");
        exit;
    }

    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM tokens_consumer WHERE id=? AND id_usuario=?");
    $stmt->execute([$id, $_SESSION['user']['id']]);
    $token_bd = $stmt->fetch(PDO::FETCH_ASSOC);

    include __DIR__."/app/views/edit_token.php";
    break;


case 'updateToken':
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?action=loginForm");
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id    = $_POST['id'];
        $token = trim($_POST['token']);

        $stmt = $pdo->prepare("UPDATE tokens_consumer SET token=? WHERE id=? AND id_usuario=?");
        $stmt->execute([$token, $id, $_SESSION['user']['id']]);

        header("Location: index.php?action=tokens");
        exit;
    }
    break;

        
        
    
    /* LOGIN */
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


    /* HOME (vista principal) */
    case 'home':
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=loginForm");
            exit;
        }
        $apiController->form();
        break;


    /* CONSUMO API */
    case 'consultarApi':
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=loginForm");
            exit;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $apiController->consultar($_POST);
        }
        break;

        case 'consultaMunicipios':
            if (!isset($_SESSION['user'])) {
                header("Location: index.php?action=loginForm");
                exit;
            }
            include __DIR__ . "/app/views/consulta_form.php";
            break;
    
        case 'consultarMunicipiosRequest':
            if (!isset($_SESSION['user'])) {
                header("Location: index.php?action=loginForm");
                exit;
            }
            $apiController->consultar($_POST);
            break;
    


    default:
        echo "Acción no válida.";
}
