<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leccion_model extends MY_Model {
    public function get_count($curso) {
        $query = 'SELECT COUNT(*) as total FROM leccions WHERE curso_id =' . $curso;
        $sql = $this->db->query($query);
        return $sql->result_array()[0]['total'];
    }
    public function get_data() {
        $query = 'SELECT * FROM temas WHERE leccion_id = '. $leccion .' ORDER BY orden ASC';
        $sql = $this->db->query($query);
        $object = new stdClass();
        foreach ($sql->result_array() as $fieldName => $fieldValue) {
            $object->{$fieldName} = $fieldValue;
        }
        return $object;
    }
}