<?php

require_once __DIR__ . "/../models/Exam.php";
require_once __DIR__ . "/../core/Response.php";

class ExamController {

    private $model;

    public function __construct($db) {
        $this->model = new Exam($db);
    }

    public function index() {
        Response::success($this->model->getAll());
    }

    public function show($id) {
        $data = $this->model->getById($id);

        if (!$data) {
            Response::error("Exam not found", 404);
        }

        Response::success($data);
    }

    public function store($data) {

        if (empty($data['exam_name']) || empty($data['exam_date'])) {
            Response::error("All fields required");
        }

        $this->model->create($data);
        Response::success("Exam created");
    }

    public function update($id, $data) {
        $this->model->update($id, $data);
        Response::success("Exam updated");
    }

    public function destroy($id) {
        $this->model->delete($id);
        Response::success("Exam deleted");
    }
}