<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataModel');
    }

    // Obtener todos los usuarios
    public function users()
    {
        $users = $this->DataModel->select('users');
        if ($users) {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($users));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(404)
                ->set_output(json_encode(['message' => 'No se encontraron usuarios']));
        }
    }

    // Obtener un usuario por ID
    public function getUser($id)
    {
        $user = $this->DataModel->select('users', ['user_id' => $id]);
        if ($user) {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($user));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(404)
                ->set_output(json_encode(['message' => 'Usuario no encontrado']));
        }
    }

    // Crear un nuevo usuario
    public function createUser()
    {
        // Obtener los datos enviados en la solicitud POST
        $data = [
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'),
            'role' => $this->input->post('role')
        ];

        // Validar los datos (opcional)

        // Crear el nuevo usuario en la base de datos
        $user = $this->DataModel->insert('users', $data);

        if ($user) {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(201)
                ->set_output(json_encode(['message' => 'Usuario creado correctamente', 'id' => $user]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode(['message' => 'Error al crear el usuario']));
        }
    }

    // Actualizar un usuario existente
    public function updateUser($id)
    {
        // Obtener los datos enviados en la solicitud PUT
        $data = [
            'name' => $this->input->put('name'),
            'email' => $this->input->put('email'),
            'password' => $this->input->put('password'),
            'role' => $this->input->put('role')
        ];
        // Validar los datos (opcional)

        // Actualizar el usuario en la base de datos
        $result = $this->DataModel->updateUser($id, $name, $email, $phone);

        if ($result) {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(['message' => 'Usuario actualizado correctamente']));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode(['message' => 'Error al actualizar el usuario']));
        }
    }

    // Eliminar un usuario existente
    public function deleteUser($id)
    {
        // Eliminar el usuario de la base de datos
        $result = $this->DataModel->deleteUser($id);

        if ($result) {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(['message' => 'Usuario eliminado correctamente']));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode(['message' => 'Error al eliminar el usuario']));
        }
    }

    // Cargar archivos a la base de datos
    public function uploadFile()
    {
        $config['upload_path'] = './uploads/'; // Ruta donde se guardarán los archivos subidos
        $config['allowed_types'] = 'pdf|doc|docx|ppt'; // Extensiones de archivo permitidas
        $config['max_size'] = 3096; // Tamaño máximo del archivo en kilobytes

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            $error = $this->upload->display_errors();
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode(['message' => $error]));
        } else {
            $fileData = $this->upload->data();
            $fileName = $fileData['file_name'];
            $filePath = $fileData['full_path'];

            // Aquí puedes guardar el filePath en la base de datos o realizar otras operaciones necesarias
            $result = $this->DataModel->insert('files', ['file_name' => $fileName, 'file_path' => $filePath]);
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(['message' => 'Archivo subido correctamente']));
        }
    }

    // Descargar el archivo de la tarea correspondiente
    public function downloadFile($fileId) {
        $file = $this->DataModel->select('files', '*', ['id' => $fileId]);
    
        if (!$file) {
            $this->output
            ->set_content_type('application/json')
            ->set_status_header(400)
            ->set_output(json_encode(['message' => 'No se encuentra el archivo para descargar']));
        }
    
        $filePath = $file['file_path'];
    
        // Envía el archivo para su descarga
        $this->load->helper('download');
        force_download($filePath, null);
    }
}

?>