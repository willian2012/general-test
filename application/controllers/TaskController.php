<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TaskController extends ApiController
{
    private $dataModel;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataModel');
        $this->dataModel = new DataModel();
    }

    // Crear una nueva tarea
    public function createTask()
    {
        // Obtener los datos enviados en la solicitud POST
        $data = [
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'status' => $this->input->post('status')
        ];

        // Crear la nueva tarea en la base de datos
        $task = $this->dataModel->insert('tasks', $data);

        $this->setCORSHeaders();

        if ($task) {
            $this->jsonResponse(201, 'Tarea creada correctamente', ['id' => $task]);
        } else {
            $this->jsonResponse(500, 'Error al crear la tarea');
        }
    }

    // Actualizar una tarea existente
    public function updateTask($taskId)
    {
        // Obtener los datos enviados en la solicitud PUT
        $data = [
            'title' => $this->input->put('title'),
            'description' => $this->input->put('description'),
            'status' => $this->input->put('status')
        ];

        // Actualizar la tarea en la base de datos
        $result = $this->dataModel->update('tasks', $data, ['task_id' => $taskId]);

        $this->setCORSHeaders();

        if ($result) {
            $this->jsonResponse(200, 'Tarea actualizada correctamente');
        } else {
            $this->jsonResponse(500, 'Error al actualizar la tarea');
        }
    }

    // Eliminar una tarea existente
    public function deleteTask($taskId)
    {
        // Eliminar la tarea de la base de datos
        $result = $this->dataModel->delete('tasks', ['task_id' => $taskId]);

        $this->setCORSHeaders();

        if ($result) {
            $this->jsonResponse(200, 'Tarea eliminada correctamente');
        } else {
            $this->jsonResponse(500, 'Error al eliminar la tarea');
        }
    }
}
