<?php
defined('BASEPATH') or exit('No direct script access allowed');

    class UsersController extends CI_Controller
    {
        private $dataModel;

        public function __construct()
        {
            parent::__construct();
            $this->load->model('DataModel');
            $this->dataModel = new DataModel();
        }

        // Obtener todos los usuarios
        public function index()
        {
            $users = $this->dataModel->select('users');

            $this->jsonResponse($users ? 200 : 404, $users ? 'Usuarios encontrados' : 'No se encontraron usuarios', $users);
        }

        // Obtener un usuario por ID
        public function getUser($id)
        {
            $user = $this->dataModel->select('users', '*', ['user_id' => $id]);

            $this->jsonResponse($user ? 200 : 404, $user ? 'Usuario encontrado' : 'Usuario no encontrado', $user);
        }

        // Crear un nuevo usuario
        public function createUser()
        {
            // Obtener los datos enviados en la solicitud POST
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $role = $this->input->post('role');

            // Crear el nuevo usuario en la base de datos
            $data = array(
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'role' => $role
            );
            $user = $this->dataModel->insert('users', $data);

            $this->jsonResponse($user ? 201 : 500, $user ? 'Usuario creado correctamente' : 'Error al crear el usuario en el servidor');
        }


        // Verificar un usuario por correo electrónico y contraseña
        public function verifyUser()
        {
            $email = $this->input->post('emailVerify');
            $password = $this->input->post('passwordVerify');

            if (!empty($email) && !empty($password)) {
                $user = $this->dataModel->select('users', '*', ['email' => $email, 'password' => $password]);

                if ($user) {
                    $response = ['success' => true];
                } else {
                    $response = ['success' => false];
                }
            } else {
                // Manejo de error si los datos no se proporcionan
                $response = ['success' => false];
            }

            $this->jsonResponse(200, '', $response);
        }


        // Función para enviar una respuesta JSON con los encabezados CORS
        private function jsonResponse($status, $message, $data = null)
        {
            $this->output
                ->set_status_header($status)
                ->set_content_type('application/json')
                ->set_header('Access-Control-Allow-Origin: http://localhost:3000')
                ->set_header('Access-Control-Allow-Methods: GET, POST, OPTIONS')
                ->set_header('Access-Control-Allow-Headers: Content-Type')
                ->set_output(json_encode([
                    'status' => $status,
                    'message' => $message,
                    'data' => $data
                ]));
        }

    }

