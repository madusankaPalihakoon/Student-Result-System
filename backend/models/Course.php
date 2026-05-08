<?php

class Course {

    private $conn;
    private $table = "courses";

    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (course_name)
                VALUES (:course_name)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":course_name" => $data['course_name']
        ]);
    }

    
    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY course_id DESC";
        return $this->conn->query($sql)->fetchAll();
    }

   
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE course_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    
    public function update($id, $data) {
        $sql = "UPDATE {$this->table}
                SET course_name = :course_name
                WHERE course_id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":course_name" => $data['course_name'],
            ":id" => $id
        ]);
    }

    
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE course_id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }
}
