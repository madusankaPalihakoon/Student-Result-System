<?php

class Exam {

    private $conn;
    private $table = "exams";

    public function __construct($db) {
        $this->conn = $db;
    }

   
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (exam_name, exam_date)
                VALUES (:name, :date)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":name" => $data['exam_name'],
            ":date" => $data['exam_date']
        ]);
    }

    
    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY exam_date DESC";
        return $this->conn->query($sql)->fetchAll();
    }

   
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE exam_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

   
    public function update($id, $data) {
        $sql = "UPDATE {$this->table}
                SET exam_name = :name, exam_date = :date
                WHERE exam_id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":name" => $data['exam_name'],
            ":date" => $data['exam_date'],
            ":id" => $id
        ]);
    }

    
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE exam_id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }
}
