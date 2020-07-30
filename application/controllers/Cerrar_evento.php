<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cerrar_evento extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		
		$this->name = 'leccion';
		$this->data['user'] = model('user')->get($this->session->userdata["identity"]);
	    if (!$this->ion_auth->logged_in()) {
	    	redirect('auth/login');
        }
    }

	public function index()	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		if ($this->ion_auth->get_users_groups()->row()->id == 1 || $this->ion_auth->get_users_groups()->row()->id == 5 ) {// compara el rol del usuario, 1 = administrador
			view('dashboard', $this->data);
		} elseif ($this->ion_auth->get_users_groups()->row()->id == 2) { // compara el rol del usuario, 2 = instructor
			view('dashboard_i', $this->data);
		} elseif ($this->ion_auth->get_users_groups()->row()->id == 3) { // compara el rol del usuario, 3 = estudiantes
			$this->data['contenidos'] =  model('tema')->order_by('orden','asc')->get_all();
			view('dashboard_e', $this->data);
		}
    }

	private function get_token(){
		
		do {
			$token = $this->create_token();	
			$existe = $this->db->query('SELECT COUNT(*) AS EXISTE FROM intecapt_constancias.verificacions WHERE token = "'.$token. '" COLLATE utf8_unicode_ci;');
			//$existe->row()->EXISTE;
			
		} while ($existe->row()->EXISTE >= 1);
		return $token;
	}

	private function create_token() {
		$authorizedChar = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$codigo_verificacion = '';
		$codigo_verificacion = substr(str_shuffle($authorizedChar), 0, 8);
		

		return $codigo_verificacion;
	}

public function cerrar_evento($evento_id){
	if (!$this->ion_auth->logged_in()) {
		redirect('auth/login');
	}

	//se lee todos los datos del evento
	$evento = model('evento')->get_by('id',$evento_id);
	//Se obtienen los datos del curso que completentan los datos del evento para el diploma
	$curso = model('curso')->get_by('id',$evento->curso_id);
	$eventousuario = model('eventousuario')->get_many_by('evento_id',$evento_id);
	
	
	//Datos de la tabla cursos 
	$curso_id = $evento->curso_id ;
	$nombre_curso = $curso->nombre ; 
	$duracion = $curso->duracion ; 
	// ya tiene datos $evento_id
	$no_evento = $evento->no_evento;
	$fecha_inicio =$evento->fecha_inicio ;
	$fecha_final = $evento->fecha_final;
	$token = "";
	$fecha_cierre = $evento->fecha_alargue ;
	//ya se tiene $id_usuario = ;


	$tempcontador = 0;

	foreach ($eventousuario as $value) {
	 $user_id =  $value->user_id;
	 $usuario = model('user')->get_by('id',$user_id);
		 $token = $this->get_token();
		 $nombres =  $usuario->first_name;
		 $apellidos = $usuario->last_name;
		 $email = $usuario->username;
		 $carnet = $usuario->carnet;
		 $progreso = 5;
		 //averiguar el progreso
		 //echo $carnet . " " . $email . " " . $progreso . " " . $user_id . " " . $evento_id ;
		  $sql2 = "SELECT id from eventousuarios WHERE user_id = $user_id and evento_id = $evento_id; ";
		 $resultado2 = $this->db->query($sql2);
		 if ($resultado2->num_rows()){
			$eventousuario_id =$resultado2->row()->id;
			$sql3 = "SELECT sum(nota) as notafinal FROM notas WHERE notas.eventousuario_id =$eventousuario_id;";
			$resultado3 = $this->db->query($sql3);
			if ($resultado3->num_rows()){
				$notafinal =$resultado3->row()->notafinal;

			}




		 }
		// "$notafinal , $eventousuario_id <br>";




		 	if($notafinal >= 70){
				$sql = "SELECT count(*) as total FROM intecapt_constancias.verificacions WHERE evento_id = $evento_id and email='$email';";
				$resultado = $this->db->query($sql);
				$cantidad_registros = 0;
								
				if ($resultado->num_rows()){
					$cantidad_registros =$resultado->row()->total;
					
				}

				$sql = "INSERT INTO intecapt_constancias.verificacions (nombres, apellidos, curso_id, 
				nombre_curso, evento_id, no_evento, fecha_inicio, fecha_final, duracion, token, carnet, email, 
				fecha_cierre, id_usuario) VALUES ('$nombres','$apellidos',$curso_id,
				'$nombre_curso',$evento_id,'$no_evento','$fecha_inicio','$fecha_final','$duracion','$token'
				,'$carnet','$email','$fecha_cierre',$user_id);" ;
				 $sql;
			
				if($cantidad_registros == 0){		
					$tempcontador++;
					$this->db->query($sql);				;


				 }
				
				 

				 	
			}
			
		}
		echo "<html><body style='background-color:#000000;'><script> alert('Se ha generado los diplomas para los participantes con una nota mayor a 70 puntos. Se generaron $tempcontador diplomas' );window.location=('" . base_url() . "evento/evento/$evento_id');</script></body></html>";
		
	}
	
}