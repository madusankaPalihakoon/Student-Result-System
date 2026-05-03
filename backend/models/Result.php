<?php

class Result
{

  private $conn;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  // Call Stored Procedure
  public function getStudentResults($student_id)
  {
    $stmt = $this->conn->prepare("CALL GetStudentResults(:sid)");
    $stmt->bindParam(":sid", $student_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function addResult($sid, $subid, $eid, $marks)
  {
    $stmt = $this->conn->prepare("CALL AddResult(:sid, :subid, :eid, :marks)");

    return $stmt->execute([
      ":sid" => $sid,
      ":subid" => $subid,
      ":eid" => $eid,
      ":marks" => $marks
    ]);
  }
}