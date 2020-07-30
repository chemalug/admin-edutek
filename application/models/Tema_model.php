<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tema_model extends MY_Model {
    public function get_count($leccion) {
        $query = 'SELECT COUNT(*) as total FROM temas WHERE leccion_id = '. $leccion;
        $sql = $this->db->query($query);
        return $sql->result_array()[0]['total'];
    }
    public function get_data($leccion) {
        $query = 'SELECT * FROM temas WHERE leccion_id = '. $leccion .' ORDER BY orden ASC';
        $sql = $this->db->query($query);
        $object = new stdClass();
        foreach ($sql->result_array() as $fieldName => $fieldValue) {
            $object->{$fieldName} = $fieldValue;
        }
        return $object;
    }
}