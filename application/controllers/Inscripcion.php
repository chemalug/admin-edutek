<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inscripcion extends CI_Controller {
   
    public function __construct(){
    parent::__construct();
    $this->name = 'inscripcion';
     
    }

   
    

    public function principal(){
        
        $sql = 'select * from emergencia_catalogo;';
        $eventos = $this->db->query($sql)->result();
        $this->data['eventos'] = $eventos;
        view('dashboard_inscripcion',$this->data);    
  
    }

    public function inscripcion($curso_id){
        
        $sql = 'select * from emergencia_catalogo;';
        $eventos = $this->db->query($sql)->result();
        $this->data['eventos'] = $eventos;
        view('herramientas/inscripcion',$this->data);    
  



    }



}
