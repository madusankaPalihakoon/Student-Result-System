<?php

require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../core/Response.php";

class AuthController {

    private $model;

    public function __construct($db) {
        $this->model = new User($db);

        // Start session for login
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    
    public function store($data) {

        if (empty($data['username']) || empty($data['password'])) {
            Response::error("Username and password required");
        }

        $user = $this->model->login($data['username'], $data['password']);

        if (!$user) {
            Response::error("Invalid credentials", 401);
        }

        // Store session
        $_SESSION['user'] = [
            "user_id" => $user['user_id'],
            "username" => $user['username'],
            "role" => $user['role'],
            "student_id" => $user['student_id']
        ];

        Response::success([
            "message" => "Login successful",
            "user" => $_SESSION['user']
        ]);
    }

   
    public function index() {

        if (!isset($_SESSION['user'])) {
            Response::error("Not authenticated", 401);
        }

        Response::success($_SESSION['user']);
    }

    
    public function destroy() {

        session_destroy();

        Response::success("Logged out successfully");
    }

    
    public function register($data) {

        if (empty($data['username']) || empty($data['password']) || empty($data['role'])) {
            Response::error("All fields required");
        }

        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password, role, student_id)
                VALUES (:username, :password, :role, :student_id)";

        $stmt = $this->model->conn->prepare($sql);

        $stmt->execute([
            ":username" => $data['username'],
            ":password" => $hashedPassword,
            ":role" => $data['role'],
            ":student_id" => $data['student_id'] ?? null
        ]);

        Response::success("User registered");
    }
}
