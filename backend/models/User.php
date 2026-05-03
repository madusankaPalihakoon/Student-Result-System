<?php

class User
{

  private $conn;
  private $table = "users";

  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function login($username, $password)
  {

    $sql = "SELECT * FROM {$this->table} WHERE username = :username LIMIT 1";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([":username" => $username]);

    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password']))
    {
      return $user;
    }

    return false;
  }
}