<?php

require_once __DIR__ . "/../models/Course.php";
require_once __DIR__ . "/../core/Response.php";

class CourseController {

    private $model;

    public function __construct($db) {
        $this->model = new Course($db);
    }

    
    public function index() {
        Response::success($this->model->getAll());
    }

   
    public function show($id) {
        $data = $this->model->getById($id);

        if (!$data) {
            Response::error("Course not found", 404);
        }

        Response::success($data);
    }

   
    public function store($data) {

        if (empty($data['course_name'])) {
            Response::error("Course name required");
        }

        $this->model->create($data);

        Response::success("Course created");
    }

    
    public function update($id, $data) {

        if (empty($data['course_name'])) {
            Response::error("Course name required");
        }

        $this->model->update($id, $data);

        Response::success("Course updated");
    }

   
    public function destroy($id) {
        $this->model->delete($id);
        Response::success("Course deleted");
    }
}
