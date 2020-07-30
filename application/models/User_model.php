<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model {

    public $primary_key = 'username';
	public function insertar($datos) {
        $query = 'INSERT INTO users (ip_address, username, password, email, created_on, first_name, last_name, carnet)
                VALUES ("127.0.0.1","'.$datos->email.'","123456789","'.$datos->email.'","UNIX_TIMESTAMP(NOW())","'.$datos->nombre.'","'.$datos->apellido.'","'.$datos->carne.'")';
        $sql = $this->db->query($query);
        /*$query = 'SELECT id FROM users WHERE carnet = "'.$datos->email.'";';
        $sql = $this->db->query($query);*/
        
    }
    public function updateuser($datos) {
        
        $query = 'UPDATE users SET first_name  = "'. $datos['first_name'] .'", last_name = " '. $datos['last_name'].'",
        email = "'. $datos['email'] .'", username = " '. $datos['email'] .'" WHERE id = '. $datos['id'].';';
        $sql = $this->db->query($query);
    }

}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */