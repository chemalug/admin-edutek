<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailer extends CI_Controller {
	public function __construct() {
		parent::__construct();
		/*$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://mail.edutek.org',
			'smtp_port' => 465,
			'smtp_user' => 'elearning@edutek.org',
			'smtp_pass' => 'Hola1234#',
			'mailtype'  => 'html', 
			'charset' => 'utf-8',
			'wordwrap' => TRUE
		);
		$this->load->library('email', $config);
		$this->email->initialize($config);*/
	    
	}
	

	public function index()	{
	 echo 'hola';
	$this->enviar_email('prueba de envio', 'jose.miranda@encodely.dev', 'Esto es una prueba');
	}
	function probar() {
		echo 'hola';
	}
	

	private function get_token() {
    	$authorizedChar = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789&@=.:;_-";
    	$codigo_verificacion = '';
    	$codigo_verificacion = substr(str_shuffle($authorizedChar), 0, 8);
    	return $codigo_verificacion;
	}
	

	

	//funcion de envio de emails
	public function email ($email,$password) {
		$this->email->from('elearning@edutek.org', 'Elearning Edutek');
		$this->email->to($email);
		$this->data['curso'] = 'Excel basico';
		$this->data['titulo'] = 'Recuperación de contraseña';
		$this->data['mensaje'] = 'Esta es una prueba de recuperaciómn de contraseña';
		$body = $this->load->view('/blades/password/email_template',$this->data,TRUE);
		
		$this->email->subject('Edutek - Accesos a la plataforma Elearning');
		$this->email->message($body);
		if ($this->email->send()) {
			//echo"Your email was sent successfully";
		} else {
			show_error($this->email->print_debugger());
		}
		
	}
	//funcion para reseteo de password
	public function mostrar_ventana_reset() {
		//$username = $this->session->userdata["identity"];
		//$sql = "SELECT * FROM users WHERE users.username = '$username';";
		//$resultado = $this->db->query($sql);
		//$fila = $resultado->row();
		//$id = $fila->id;
		//$email = $fila->email;
		
		//$this->data["email"] = $username;
		//$this->data["id"] = $id;
		//$this->data["nombres"] = $fila->first_name;
		//$this->data["apellidos"] = $fila->last_name;
		view('blades/password/reset');



	}

	public function reset_password() {
		$email = $this->input->post("email");
		$password = $this->get_token();
		//$cambio = $this->ion_auth->reset_password($user->username,$password);
		$this->email("chemalug@gmail.com",$password);
		
		
		
		
		
		
		//$cambio = $this->ion_auth->reset_password($user->username,'12345678');
		//$this->email($instructor->email_instructor,'12345678');
		//print_r($cambio);
	}


	//funcion para reenvio de password
	public function reenviar() {
		
		
		
		
		$id = $this->input->post('id');
		$instructor = model('instructor')->get_by('id',$id);
		$user = model('user')->get_by('email',$instructor->email_instructor);
		$password = $this->get_token();
		$cambio = $this->ion_auth->reset_password($user->username,$password);
		$this->email($instructor->email_instructor,$password);
		print_r($cambio);
	}

	public function ejemplo () {
		$respuesta = model('tema')->get_all();
		echo json_encode($respuesta);
	}


	public function enviar_email($asunto, $email, $mensaje) {
		echo 'hola';
		$this->email->from('elearning@edutek.org', 'Elearning Edutek');
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
