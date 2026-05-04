<?php

require_once __DIR__ . "/../models/Course.php";
require_once __DIR__ . "/../core/Response.php";

class CourseController {

    private $model;

    public function __construct($db) {
        $this->model = new Course($db);
    }

    // GET ALL
    public function index() {
        Response::success($this->model->getAll());
    }

    // GET ONE
    public function show($id) {
        $data = $this->model->getById($id);

        if (!$data) {
            Response::error("Course not found", 404);
        }

        Response::success($data);
    }

    // CREATE
    public function store($data) {

        if (empty($data['course_name'])) {
            Response::error("Course name required");
        }

        $this->model->create($data);

        Response::success("Course created");
    }

    // UPDATE
    public function update($id, $data) {

        if (empty($data['course_name'])) {
            Response::error("Course name required");
        }

        $this->model->update($id, $data);

        Response::success("Course updated");
    }

    // DELETE
    public function destroy($id) {
        $this->model->delete($id);
        Response::success("Course deleted");
    }
}