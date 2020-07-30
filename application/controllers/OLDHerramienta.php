<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Herramientas extends CI_Controller {
   
    public function __construct(){
    parent::__construct();
    $this->name = 'herramienta';
    if(!isset($this->session->userdata["identity"])) {
        redirect('auth/login');
    }

    $this->data['user'] = model('user')->get($this->session->userdata["identity"]);
    //------------copiar esto
    $config = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://mail.intecap.tech',
        'smtp_port' => 465,
        'smtp_user' => 'elearning@intecap.tech',
        'smtp_pass' => 'Hola1234#',
        'mailtype'  => 'html',
        'charset' => 'utf-8',
        'wordwrap' => TRUE
    );
    $this->load->library('email', $config);
    $this->email->initialize($config);
    //------------hasta aqui
    $this->load->library('Excel');
    //$this->load->helper(array('form', 'url'));
    if (!$this->ion_auth->logged_in()) {
        redirect('auth/login');
    }
    $this->items = array(
        'no_evento'         =>  'trim|required',
        'fecha_inicio'      =>  'trim|required',//|required
        'fecha_final'       =>  'trim|required',
        'instructor_id'     =>  'trim|required',
        'no_horas'          =>  'trim|required',
        'curso_id'          =>  'trim|required',
    );
}

    public function tablero($id_evento){
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->users(2)->result()) {
            $this->session->set_flashdata('message', '¡Debes ser un instructor para ver esta página!');
            redirect('/');
        }

        
        view('dashboard_herramientas', $this->data);

    }

   
   


    }
 