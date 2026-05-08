<?php

require_once __DIR__ . "/../models/Result.php";
require_once __DIR__ . "/../core/Response.php";

class ResultController {

    private $model;

    public function __construct($db) {
        $this->model = new Result($db);
    }

    public function index() {

       
        if (isset($_GET['student_id']) && isset($_GET['exam_id'])) {
            Response::success(
                $this->model->getByStudentAndExam($_GET['student_id'], $_GET['exam_id'])
            );
        }

        
        elseif (isset($_GET['student_id'])) {
            Response::success(
                $this->model->getByStudent($_GET['student_id'])
            );
        }

    
        else {
            Response::success($this->model->getAll());
        }
    }

    public function show($id) {
        $data = $this->model->getById($id);

        if (!$data) {
            Response::error("Result not found", 404);
        }

        Response::success($data);
    }

    public function store($data) {

        if (
            empty($data['student_id']) ||
            empty($data['subject_id']) ||
            empty($data['exam_id']) ||
            !isset($data['marks'])
        ) {
            Response::error("All fields required");
        }

        $this->model->create($data);

        Response::success("Result created");
    }

    public function update($id, $data) {
        $this->model->update($id, $data);
        Response::success("Result updated");
    }

    public function destroy($id) {
        $this->model->delete($id);
        Response::success("Result deleted");
    }

    
    public function studentResults($student_id) {
        Response::success(
            $this->model->getStudentResults($student_id)
        );
    }
}
