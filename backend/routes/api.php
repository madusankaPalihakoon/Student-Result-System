<?php

require_once "../config/database.php";
require_once "../core/Response.php";
require_once "../models/Student.php";
require_once "../controllers/StudentController.php";

$db = (new Database())->connect();
$controller = new StudentController($db);

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;

$data = json_decode(file_get_contents("php://input"), true);

switch ($method)
{
  case "GET":
    if ($id)
    {
      $controller->show($id);
    } else
    {
      $controller->index();
    }
    break;

  case "POST":
    $controller->store($data);
    break;

  case "PUT":
    $controller->update($id, $data);
    break;

  case "DELETE":
    $controller->destroy($id);
    break;

  default:
    Response::error("Invalid request method", 405);
}