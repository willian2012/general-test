<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FileController extends CI_Controller
{
    private $dataModel;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataModel');
        $this->dataModel = new DataModel();
    }

    // Cargar archivos a la base de datos
    public function uploadFile()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'pdf|doc|docx|ppt';
        $config['max_size'] = 3096;

        $this->load->library('upload', $config);

        $this->setCORSHeaders();

        if (!$this->upload->do_upload('file')) {
            $this->jsonResponse(400, $this->upload->display_errors());
            return;
        }

        $fileData = $this->upload->data();
        $fileName = $fileData['file_name'];
        $filePath = $fileData['full_path'];

        $result = $this->dataModel->insert('files', ['file_name' => $fileName, 'file_path' => $filePath]);

        $this->jsonResponse($result ? 200 : 500, $result ? 'Archivo subido correctamente' : 'Error al subir el archivo');
    }

    // Descargar el archivo correspondiente por ID
    public function downloadFile($fileId)
    {
        $file = $this->dataModel->select('files', '*', ['file_id' => $fileId]);

        $this->setCORSHeaders();

        if (!$file) {
            $this->jsonResponse(400, 'No se encuentra el archivo para descargar');
            return;
        }

        $filePath = $file['file_path'];

        $this->load->helper('download');
        force_download($filePath, null);
    }

    // Actualizar un archivo existente
    public function updateFile($fileId)
    {
        $data = [
            'file_name' => $this->input->put('file_name'),
            'file_path' => $this->input->put('file_path')
        ];

        $result = $this->dataModel->update('files', $data, ['file_id' => $fileId]);

        $this->jsonResponse($result ? 200 : 500, $result ? 'Archivo actualizado correctamente' : 'Error al actualizar el archivo');
    }

    // Eliminar un archivo existente
    public function deleteFile($fileId)
    {
        $result = $this->dataModel->delete('files', ['file_id' => $fileId]);

        $this->jsonResponse($result ? 200 : 500, $result ? 'Archivo eliminado correctamente' : 'Error al eliminar el archivo');
    }
}
