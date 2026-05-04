<?php

class Result {

    private $conn;
    private $table = "results";

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE (via stored procedure)
    public function create($data) {

        $stmt = $this->conn->prepare(
            "CALL AddResult(:sid, :subid, :eid, :marks)"
        );

        return $stmt->execute([
            ":sid" => $data['student_id'],
            ":subid" => $data['subject_id'],
            ":eid" => $data['exam_id'],
            ":marks" => $data['marks']
        ]);
    }

    // READ ALL (with joins)
    public function getAll() {

        $sql = "SELECT r.result_id, s.name AS student,
                       sub.subject_name, e.exam_name,
                       r.marks, r.grade
                FROM results r
                JOIN students s ON r.student_id = s.student_id
                JOIN subjects sub ON r.subject_id = sub.subject_id
                JOIN exams e ON r.exam_id = e.exam_id";

        return $this->conn->query($sql)->fetchAll();
    }

    // READ BY ID
    public function getById($id) {

        $sql = "SELECT * FROM results WHERE result_id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":id" => $id]);

        return $stmt->fetch();
    }

    // UPDATE
    public function update($id, $data) {

        $sql = "UPDATE results
                SET student_id=:sid, subject_id=:subid,
                    exam_id=:eid, marks=:marks
                WHERE result_id=:id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":sid" => $data['student_id'],
            ":subid" => $data['subject_id'],
            ":eid" => $data['exam_id'],
            ":marks" => $data['marks'],
            ":id" => $id
        ]);
    }

    // DELETE
    public function delete($id) {
        $sql = "DELETE FROM results WHERE result_id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }

    // STORED PROCEDURE CALL
    public function getStudentResults($student_id) {
        $stmt = $this->conn->prepare("CALL GetStudentResults(:sid)");
        $stmt->execute([":sid" => $student_id]);
        return $stmt->fetchAll();
    }

    // 🔥 get results by student
public function getByStudent($student_id) {

    $stmt = $this->conn->prepare("
        SELECT r.result_id,
               r.student_id,
               sub.subject_name,
               e.exam_name,
               r.marks,
               r.grade
        FROM results r
        JOIN subjects sub ON r.subject_id = sub.subject_id
        JOIN exams e ON r.exam_id = e.exam_id
        WHERE r.student_id = :sid
    ");

    $stmt->execute([":sid" => $student_id]);
    return $stmt->fetchAll();
}

// 🔥 get by student + exam
public function getByStudentAndExam($student_id, $exam_id) {

    $stmt = $this->conn->prepare("
        SELECT r.result_id,
               r.student_id,
               sub.subject_name,
               e.exam_name,
               r.marks,
               r.grade
        FROM results r
        JOIN subjects sub ON r.subject_id = sub.subject_id
        JOIN exams e ON r.exam_id = e.exam_id
        WHERE r.student_id = :sid AND r.exam_id = :eid
    ");

    $stmt->execute([
        ":sid" => $student_id,
        ":eid" => $exam_id
    ]);

    return $stmt->fetchAll();
}
}