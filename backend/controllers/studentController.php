<?php

class StudentController
{

  private $model;

  public function __construct($db)
  {
    $this->model = new Student($db);
  }

  public function index()
  {
    Response::success($this->model->getAll());
  }

  public function show($id)
  {
    $data = $this->model->getById($id);
    if (!$data)
      Response::error("Student not found", 404);

    Response::success($data);
  }

  public function store($data)
  {
    if (!$this->model->create($data['name'], $data['email'], $data['course_id']))
    {
      Response::error("Create failed");
    }

    Response::success("Student created");
  }

  public function update($id, $data)
  {
    $this->model->update($id, $data['name'], $data['email'], $data['course_id']);
    Response::success("Student updated");
  }

  public function destroy($id)
  {
    $this->model->delete($id);
    Response::success("Student deleted");
  }
}