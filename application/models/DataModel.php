<?php 
class DataModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert($table, $data) {
        return $this->db->insert($table, $data);
    }

    public function delete($table, $conditions) {
        return $this->db->where($conditions)->delete($table);
    }

    public function update($table, $data, $conditions) {
        return $this->db->where($conditions)->update($table, $data);
    }

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
