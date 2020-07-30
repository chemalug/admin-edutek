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


    public function resetpassword(){
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->users(2)->result()) {
            $this->session->set_flashdata('message', '¡Debes ser un instructor para ver esta página!');
            redirect('/');
        }



        view('herramientas/resetpass');    
  
    }

    public function changename($carnet) {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->users(2)->result()) {
            $this->session->set_flashdata('message', '¡Debes ser un instructor para ver esta página!');
            redirect('/');
        }


        $identidad = $this->session->userdata["identity"];
        $this->data['user'] = model('user')->get($this->session->userdata['identity']);
        $this->data['carnet'] = $carnet;
        view('herramientas/resetname', $this->data);    
    }


    public function updatename() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->users(2)->result()) {
            $this->session->set_flashdata('message', '¡Debes ser un instructor para ver esta página!');
            redirect('/');
        }

         $this->input->post("old_email");
         $nombres = $this->input->post("nombres");
         $apellidos = $this->input->post("apellidos");
         $carnet = $this->input->post("carnet");

        $sql = "UPDATE users  SET first_name = '$nombres', last_name = '$apellidos'  WHERE carnet = '$carnet';";
        $this->db->query($sql);
        
         $url = base_url();
         redirect($url . "herramientas/resetpassword/");


        //$identidad = $this->session->userdata["identity"];
        //$this->data['user'] = model('user')->get($this->session->userdata['identity']);
        //$this->data['carnet'] = $carnet;
        //view('herramientas/resetemail', $this->data);    
    }



    public function changemail($carnet) {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->users(2)->result()) {
            $this->session->set_flashdata('message', '¡Debes ser un instructor para ver esta página!');
            redirect('/');
        }


        $identidad = $this->session->userdata["identity"];
        $this->data['user'] = model('user')->get($this->session->userdata['identity']);
        $this->data['carnet'] = $carnet;
        view('herramientas/resetemail', $this->data);    
    }


    public function updatemail() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->users(2)->result()) {
            $this->session->set_flashdata('message', '¡Debes ser un instructor para ver esta página!');
            redirect('/');
        }

         $this->input->post("old_email");
         $nuevo_email = $this->input->post("new_email");
         $carnet = $this->input->post("carnet");

         $sql = "UPDATE users  SET email = '$nuevo_email', username = '$nuevo_email' WHERE carnet = '$carnet';";
         $this->db->query($sql);
         $url = base_url();
         redirect($url . "herramientas/resetpassword");


        //$identidad = $this->session->userdata["identity"];
        //$this->data['user'] = model('user')->get($this->session->userdata['identity']);
        //$this->data['carnet'] = $carnet;
        //view('herramientas/resetemail', $this->data);    
    }


    public function rp($username) {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->users(2)->result()) {
            $this->session->set_flashdata('message', '¡Debes ser un instructor para ver esta página!');
            redirect('/');
        }


        $identidad = $this->session->userdata["identity"];
		$this->data['user'] = model('user')->get($this->session->userdata['identity']);
		
		
		$sql = 'UPDATE users  SET password = "$2y$08$qqMsENIQnznxzmbBmSe6q.wabuK70xgFfW6GotlPGpJCw2JPE/fie" WHERE username = "'. $username .'"  ;';
		$this->db->query($sql);
		
		//$datos = $resultado->row();
		//$this->data['datos'] = $datos;

        view('herramientas/rp', $this->data);    

        
        
    }



    


    public function listado_notas($evento_id) {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->users(2)->result()) {
            $this->session->set_flashdata('message', '¡Debes ser un instructor para ver esta página!');
            redirect('/');
        }

        $identidad = $this->session->userdata["identity"];
        $this->data['user'] = model('user')->get($this->session->userdata['identity']);
        
       $sqlconnota = "select carnet, first_name as nombres, last_name as apellidos, sum(notas.nota) as nota, last_login from users join eventousuarios on users.id = eventousuarios.user_id join notas on notas.eventousuario_id = eventousuarios.id where eventousuarios.evento_id = '$evento_id' group by users.id;";
       $sqllistado = "select carnet, first_name as nombres, last_name as apellidos, last_login from users join eventousuarios on users.id = eventousuarios.user_id where eventousuarios.evento_id = '$evento_id' group by users.id;";

        $alumnos_con_nota =  $this->db->query($sqlconnota)->result();
        $alumnos_lista =  $this->db->query($sqllistado)->result();

        $this->data['alumnos_con_nota'] =  $this->db->query($sqlconnota)->result();
        $this->data['alumnos_lista'] =  $this->db->query($sqllistado)->result();

        //print_r($datos);
        
       view('herramientas/listado_notas', $this->data);    
  
    }

    public function listado_constancias($evento_id) {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->users(2)->result()) {
            $this->session->set_flashdata('message', '¡Debes ser un instructor para ver esta página!');
            redirect('/');
        }

        $identidad = $this->session->userdata["identity"];
        $this->data['user'] = model('user')->get($this->session->userdata['identity']);
        
        $query = "Select * from intecapt_constancias.verificacions where evento_id = $evento_id;";

        
        $this->data['constancias'] =  $this->db->query($query)->result();
 

        //print_r($datos);
        
       view('herramientas/listado_constancias', $this->data);    
  
    }







}
