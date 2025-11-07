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
