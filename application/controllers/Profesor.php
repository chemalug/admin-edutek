<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profesor extends CI_Controller {
	public function __construct() {
		parent::__construct();
		
		$this->name = 'profesor';
		$this->data['user'] = model('user')->get($this->session->userdata["identity"]);
		//------------copiar esto
		$config = Array(
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
	    if (!$this->ion_auth->logged_in()) {
	    	redirect('auth/login');
	    }
	}
	//'smtp_user' => 'elearning.tics@intecap.edu.gt',
	//'smtp_pass' => 'Intecap2019@',

	public function index()	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		view('dashboard', $this->data);
	}
	public function agregar() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		view('administrador/'.$this->name.'/add', $this->data);
	}
	private function get_user ($datos) {
    	
      	return $user_id;
	}
	private function get_token() {
    	$authorizedChar = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789&@=.:;_-";
    	$codigo_verificacion = '';
    	$codigo_verificacion = substr(str_shuffle($authorizedChar), 0, 8);
    	return $codigo_verificacion;
    }
	public function addaction() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		} elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
			$this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
			redirect('/');
		}
        $nombre_profesor = $this->input->post('nombre');
		$codigo_profesor = $this->input->post('codigo');
		$email_profesor  = $this->input->post('email');
		
		if (!$nombre_profesor) {
			echo '0';
			return;
		}
		if (!$codigo_profesor) {
			echo '0';
			return;
		}
		if (!$email_profesor) {
			echo '0';
			return;
		}
		if (model('profesor')->get_by('email_profesor',$email_profesor)) {
			echo '0';
			return;
		}
		$datos = array(
            'nombre_profesor'        => $nombre_profesor,
			'apellido_profesor'  => $codigo_profesor ,
			'email_profesor'  => $email_profesor,
		);
		try {
			$user_exist = model('user')->get_by('email',$datos['email_profesor']);
			if ($user_exist == null) {
				$password = $this->get_token();
				$user_id = $this->ion_auth->register($datos['email_profesor'], 
				$password, $datos['email_profesor'], array( 'first_name' => $datos['nombre_profesor'], 
				'last_name' => $datos['apellido_profesor'],'active' => '1','carnet' => $datos['email_profesor'] ), array('2') );
				$dato = model('profesor')->insert($datos);

				/*$this->email->from('elearning.tics@intecap.edu.gt', 'Elearning INTECAP Centro Tics');
				$this->email->to($email_profesor);
				$this->data['email'] = $email_profesor;
				$this->data['pass'] = $password;
				$body = $this->load->view('/auth/email/send_pasword',$this->data,TRUE);
				
				$this->email->subject('Intecap CTI - Accesos a la plataforma Elearning');
				$this->email->message($body);
				if ($this->email->send()) {
					echo "1";
				} else {
					echo '0';
				}*/
				$asunto = 'Ingreso a la plataforma';
				$mensaje = 'Bienvenido a la plataforma, se te ha creado la cuenta con las siguientes credenciales <br>
							<strong>Usuario:  </strong>' . $email_profesor .' <br>
							<strong>Password: </strong>' . $password;
				$this->enviar_email($asunto, $email_profesor, $mensaje);
				echo 1;
				return;
			} else {
				echo '0';
				return;
			}
		} catch (mysqli_sql_exception $e) {
			echo $e->getMessage();
		}
		
		return; 
	}
	
	public function asignar() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		} elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
			$this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
			redirect('/');
		}
		$this->data['list'] = model('profesor')->get_all();
		view('administrador/'.$this->name.'/show', $this->data);
	}
	public function email ($email,$password) {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$this->email->from('elearning.tics@intecap.edu.gt', 'Elearning INTECAP Centro Tics');
		$this->email->to($email);
		$this->data['email'] = $email;
		$this->data['pass'] = $password;
		$body = $this->load->view('/auth/email/send_pasword',$this->data,TRUE);
		
		$this->email->subject('Intecap CTI - Accesos a la plataforma Elearning');
		$this->email->message($body);
		if ($this->email->send()) {
			//echo"Your email was sent successfully";
		} else {
			show_error($this->email->print_debugger());
		}
		
	}

	public function edit($id) {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		} elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
			$this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
			redirect('/');
		}
		$this->data['datos'] = model('profesor')->get_by('id',$id);
		view('administrador/' . $this->name . '/edit', $this->data);
	}

	public function editaction(){
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		} elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
			$this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
			redirect('/');
		}
		$nombre_profesor = $this->input->post('nombre');
		$codigo_profesor = $this->input->post('codigo');
		$email_profesor  = $this->input->post('email');
		$id 				= $this->input->post('id');
		if (!$nombre_profesor) {
			echo '0';
			return;
		}
		if (!$codigo_profesor) {
			echo '0';
			return;
		}
		if (!$email_profesor) {
			echo '0';
			return;
		}
		$profesor = model('profesor')->get_by('id',$id);
		
		$datos = array(
			'nombre_profesor'        => $nombre_profesor,
			'apellido_profesor'  => $codigo_profesor,
			'email_profesor'  => $email_profesor,
		);
		$user_exist = model('user')->get_by('email', $profesor->email_profesor);

		if (!$user_exist) {
			echo '0';
			return;
		} else {
			$datauser = array (
				'first_name'    => $nombre_profesor,
				'last_name'  	=> $codigo_profesor,
				'email'  		=> $email_profesor,
				'username'		=> $email_profesor,
				'id'			=> $user_exist->id,
			);
			$usuario = model('user')->updateuser($datauser);
			$respuesta = model('profesor')->update($id, $datos);
			echo $respuesta;

		}
	}
	public function reset() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$id = $this->input->post('id');
		$profesor = model('profesor')->get_by('id',$id);
		$user = model('user')->get_by('email',$profesor->email_profesor);
		$asunto = 'Ingreso a la plataforma';
		$mensaje = 'Se ha reseteado tu password de la plataforma, el ingreso a la cuenta con las siguientes credenciales <br>
							<strong>Usuario:  </strong>' . $profesor->email_profesor . ' <br>
							<strong>Password: </strong>' .'12345678';
							
		$cambio = $this->ion_auth->reset_password($user->username,'12345678');
		$this->enviar_email($asunto, $profesor->email_profesor, $mensaje);
		print_r($cambio);
	}
	public function reenviar() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$id = $this->input->post('id');
		$profesor = model('profesor')->get_by('id',$id);
		$user = model('user')->get_by('email',$profesor->email_profesor);
		$password = $this->get_token();
		$cambio = $this->ion_auth->reset_password($user->username,$password);
		$this->email($profesor->email_profesor,$password);
		print_r($cambio);
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
