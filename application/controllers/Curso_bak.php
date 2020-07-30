<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curso extends CI_Controller {
    public function __construct() { 
        parent::__construct();
        $this->name = 'curso';

        if(!isset($this->session->userdata["identity"])){
            redirect('auth/login');            
        }
        $this->data['user'] = model('user')->get($this->session->userdata["identity"]);
        
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } 
        
    }
    public function index() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
            redirect('/');
        }
    }
    public function agregar() {
        view('administrador/'.$this->name.'/add', $this->data);
    }
    public function listar() {
        $this->data['list'] = model('curso')->get_all();
        view('administrador/'.$this->name.'/show', $this->data);
    }
    public function addaction() {
        $datos = array(
            'nombre'        => $this->input->post('nombre') ,
            'descripcion '  => $this->input->post('descripcion') ,
        );
        $dato = model('curso')->insert($datos);
        if ($dato != 0) {
            $this->session->set_flashdata('message', '¡Dato agregado correctamente!');
            $this->data['list'] = model('curso')->get_all();
            redirect($this->name.'/listar');
        } else {
            $this->session->set_flashdata('message', '¡Ocurrió un problema en la inserción!');
            view('administrador/'.$this->name.'/add', $this->data);
        }
        
    }
    public function evento($id) {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $this->data['bandera'] = 2;
        $this->data['eventos'] = model('eventousuario')->get_many_by('user_id',$this->data['user']->id);
        $curso_id = model('evento')->get_by('no_evento',$id)->curso_id;
        
        $this->data['contenidos'] =  model('leccion')->order_by('orden','asc')->get_many_by('curso_id',$curso_id);;
        view('dashboard_e', $this->data);

    }
    public function leccion($id){
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $user           = model('user')->get($this->session->userdata["identity"]);
        $leccion        = model('leccion')->get_by('id',$id);
        /*$leccion        = model('leccion')->get_by('id',$id);
        $eventousuario  = model('eventousuario')->get_many_by('user_id',$user->id);
        $inscrito = 0;
        foreach ($eventousuario as $value) {
            //print_r($value);
            $evento = model('evento')->get_by('id',$value->evento_id);
            //print_r($evento);
            if ($evento->curso_id == $leccion->curso_id) {
                echo 'Esta en el curso';
            }
            
        }*/
        
        $this->data['bandera']      = 2;
        $this->data['temas']        = model('tema')->order_by('orden','asc')->get_many_by('leccion_id',$id);
        
        $this->data['contenidos']   =  model('leccion')->order_by('orden','asc')->get_many_by('curso_id',$leccion->curso_id);
        //echo '<br>';
       // print_r($this->data['temas']);
        view('listado',$this->data);
    }
 }