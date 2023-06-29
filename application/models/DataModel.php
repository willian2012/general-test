<?php 
    class dataModel extends CI_Model {
        
        /* Metodo constructor donde trae por defecto la base de datos */
        public function __construct() {
            $this->load->database();
        }

        /* Metodo para insertar datos a una tabla */
        public function insert($table, $data) {
            return $this->db->insert($table, $data);
        }

        /* Metodo para eliminar un campo de una tabla */
        public function delete($table, $conditions) {
            return $this->db->where($conditions)->delete($table);
        }

        /* metodo para actualizar los datos de una tabla */
        public function update($table, $data, $conditions) {
            return $this->db->where($conditions)->update($table, $data);
        }

        /* metodo para seleccionar los datos de una tabla, por defecto selecciona todos los datos */
        public function select($table, $columns = '*', $condition = null) {
            $this->db->select($columns)->from($table);
            
            if ($condition !== null) {
                $this->db->where($condition);
            }
            
            $query = $this->db->get();
            return $query->result_array();
        }
        

    }
?>