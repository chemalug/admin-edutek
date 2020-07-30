<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluacion extends CI_Controller {

	public function __construct() {
        parent::__construct();
		//$this->data['menu'] = 'dashboard';
		$this->load->model('user_model', 'user');
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
		$this->data['user'] = (isset($this->session->userdata["identity"])) ? $this->user->get($this->session->userdata["identity"]) : NULL ;
	    if (!$this->ion_auth->logged_in()) {
	    	redirect('auth/login');
	    }
    }
    
	public function index()	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
	}






	public function confirmar($tema_id){
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$this->data['tema_id'] = $tema_id;
		
		view('blades/evaluacion/confirmacion', $this->data);

		
	  
	} 

	public function ver($actividad_id,$intentos){
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		//necesito el evento_usuario_id para asignar la nota y el avance, ademas de incrementar la cantidad de intentos
		$eventousuarios_id = $this->session->userdata["eventousuarios_id"];
		$tema_id = $actividad_id;
		$intentos++;
		//con el id del examen llamar al modelo y recperar las preguntas y respuestas
		$this->data['tema_id']=$tema_id;
		$this->data["eventousuario_id"]=$eventousuarios_id;

		
		
		$username = $this->session->userdata["identity"];

		$this->data['resultado'] =model('pregunta')->get_many_by("tema_id",$tema_id);
		
		$alumno = array("username"=>$username);
		$userdata = model('user')->get_by($alumno);
		$nombre = $userdata->first_name;
		
		$sql_intentos = "UPDATE notas SET intentos = $intentos WHERE eventousuario_id = $eventousuarios_id AND tema_id = $tema_id";
		$this->db->query($sql_intentos);


		$sql = "SELECT * FROM notas WHERE eventousuario_id = $eventousuarios_id;"; 
		
		$conneccion = mysqli_connect('127.0.0.1','intecapt_admin','CentroTics2019@');
		mysqli_select_db($conneccion,'intecapt_plantilla');
		$resultado = mysqli_query($conneccion, $sql);
		if($resultado->num_rows > 0){
		
			while($row = $resultado->fetch_array()){
				$intentos =  $row[4];
			}
		}else{
		$intentos = 0;


		}
			
		$this->data["intentos"] = $intentos;
		$this->data["actividad_id"] = $actividad_id;

		$vinculo = "../../curso/evento/" . $this->session->userdata["evento_no"];
		$this->data["vinculo"] = $vinculo;
		view('blades/evaluacion/examen', $this->data);
	
	}





public function resultado($actividad_id){
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}

$this->data["resultado"]=$this->input->post();
$this->data["actividad_id"]=$actividad_id;

//print_r($this->data["resultado"]);

view('blades/evaluacion/resultado', $this->data);

}

public function guardar_resultado(){





}
	//-----------------------------------funcion de envio de emails
	public function enviar_email($asunto, $email, $mensaje)
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$this->email->from('elearning.tics@intecap.edu.gt', 'Elearning INTECAP Centro Tics');
		$this->email->to($email);
		//$this->data['curso'] = 'Excel basico';
		$this->data['titulo'] = $asunto;
		$this->data['mensaje'] = $mensaje;
		$body = $this->load->view('/blades/password/email_template', $this->data, TRUE);

		$this->email->subject($asunto);
		$this->email->message($body);
		if ($this->email->send()) {
			//echo"Your email was sent successfully";
		} else {
			show_error($this->email->print_debugger());
		}
	}



}
