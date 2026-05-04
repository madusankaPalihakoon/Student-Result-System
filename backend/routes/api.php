<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../core/Response.php";

// Models
require_once __DIR__ . "/../models/Student.php";
require_once __DIR__ . "/../models/Subject.php";
require_once __DIR__ . "/../models/Result.php";
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../models/Course.php";
require_once __DIR__ . "/../models/Exam.php";

// Controllers
require_once __DIR__ . "/../controllers/StudentController.php";
require_once __DIR__ . "/../controllers/SubjectController.php";
require_once __DIR__ . "/../controllers/ResultController.php";
require_once __DIR__ . "/../controllers/AuthController.php";
require_once __DIR__ . "/../controllers/CourseController.php";
require_once __DIR__ . "/../controllers/ExamController.php";

// ✅ CORS HEADERS
header("Access-Control-Allow-Origin: http://localhost:8000");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Credentials: true");

// ✅ HANDLE PREFLIGHT (MOST IMPORTANT)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$db = (new Database())->connect();

$resource = $_GET['resource'] ?? null;
$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null; // ✅ FIXED
$method = $_SERVER['REQUEST_METHOD'];

$data = json_decode(file_get_contents("php://input"), true);

// 🔥 Controller Mapping
$routes = [
    "students" => StudentController::class,
    "subjects" => SubjectController::class,
    "results"  => ResultController::class,
    "auth"     => AuthController::class,
    "courses" => CourseController::class,
    "exams" => ExamController::class,
];

if (!$resource || !isset($routes[$resource])) {
    Response::error("Invalid resource", 404);
}

$controllerClass = $routes[$resource];
$controller = new $controllerClass($db);

// 🔄 Clean Routing
switch ($method) {

    case "GET":

        if ($resource === "auth") {
            $controller->index(); // get current user
        } else {
            $id ? $controller->show($id) : $controller->index();
        }

        break;

    case "POST":

        if ($resource === "auth" && $action === "register") {
            $controller->register($data);
        } else {
            $controller->store($data);
        }

        break;

    case "PUT":

        if (!$id) {
            Response::error("ID required for update");
        }

        $controller->update($id, $data);
        break;

    case "DELETE":

        if ($resource === "auth") {
            $controller->destroy(); // logout
        } else {
            if (!$id) {
                Response::error("ID required for delete");
            }
            $controller->destroy($id);
        }

        break;

    default:
        Response::error("Invalid request method", 405);
}