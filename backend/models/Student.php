<?php

class Student
{

  private $conn;
  private $table = "students";

  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function create($name, $email, $course_id)
  {
    $sql = "INSERT INTO {$this->table} (name, email, course_id)
                VALUES (:name, :email, :course_id)";

    $stmt = $this->conn->prepare($sql);

    return $stmt->execute([
      ":name" => $name,
      ":email" => $email,
      ":course_id" => $course_id
    ]);
  }

  public function getAll()
  {
    $sql = "SELECT * FROM {$this->table}";
    return $this->conn->query($sql)->fetchAll();
  }

  public function getById($id)
  {
    $sql = "SELECT * FROM {$this->table} WHERE student_id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([":id" => $id]);
    return $stmt->fetch();
  }

  public function update($id, $name, $email, $course_id)
  {
    $sql = "UPDATE {$this->table}
                SET name=:name, email=:email, course_id=:course_id
                WHERE student_id=:id";

    $stmt = $this->conn->prepare($sql);

    return $stmt->execute([
      ":name" => $name,
      ":email" => $email,
      ":course_id" => $course_id,
      ":id" => $id
    ]);
  }

  public function delete($id)
  {
    $sql = "DELETE FROM {$this->table} WHERE student_id = :id";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([":id" => $id]);
  }
}