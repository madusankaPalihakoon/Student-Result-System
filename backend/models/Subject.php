<?php

class Subject {

    private $conn;
    private $table = "subjects";

    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (subject_name, credits)
                VALUES (:name, :credits)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":name" => $data['subject_name'],
            ":credits" => $data['credits']
        ]);
    }

    
    public function getAll() {
        $sql = "SELECT * FROM {$this->table}";
        return $this->conn->query($sql)->fetchAll();
    }

    
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE subject_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    
    public function update($id, $data) {
        $sql = "UPDATE {$this->table}
                SET subject_name = :name, credits = :credits
                WHERE subject_id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":name" => $data['subject_name'],
            ":credits" => $data['credits'],
            ":id" => $id
        ]);
    }

    
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE subject_id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }
}
