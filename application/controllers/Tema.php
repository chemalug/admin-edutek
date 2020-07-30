<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tema extends CI_Controller {
	public function __construct() {
        parent::__construct();
		$this->name = 'tema';
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
	    if (!$this->ion_auth->logged_in()) {
	    	redirect('auth/login');
        }
    }
	public function index()	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		if ($this->ion_auth->get_users_groups()->row()->id == 1) {// compara el rol del usuario, 1 = administrador
			view('dashboard', $this->data);
		} elseif ($this->ion_auth->get_users_groups()->row()->id == 2) { // compara el rol del usuario, 2 = instructor
			view('dashboard_i', $this->data);
		} elseif ($this->ion_auth->get_users_groups()->row()->id == 3) { // compara el rol del usuario, 3 = estudiantes
			$this->data['contenidos'] =  model('tema')->order_by('orden','asc')->get_all();
			view('dashboard_e', $this->data);
		}
	}
	public function pregunta() {
		//print_r($this->input->post());
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$pregunta = $this->input->post('pregunta');
		$tema_id =  $this->input->post('tema_id');
		if (!$pregunta) {
			echo "0";
			return;
		}
		$data = array(
			'pregunta' 	=> $pregunta, 
			'tema_id'	=> $tema_id,
		);
		$respuesta = model('pregunta')->insert($data);
		echo $respuesta;
		return;
	}
	public function eliminarPregunta(){
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$id = $this->input->post('id');
		$respuesta = model('pregunta')->delete($id);
	}
	public function eliminarRespuesta()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$id = $this->input->post('id');
		$respuesta = model('respuesta')->delete($id);
	}
	public function ver($id) {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$tema 	= model('tema')->get_by('id',$id);
		$orden = $tema->orden;
		$leccion 		= model('leccion')->get_by('id',$tema->leccion_id);
		$this->data['tema_id'] = $id;
		$this->data['bandera'] 		= 2;
		$this->data['contenidos'] 	= model('leccion')->order_by('orden','asc')->get_many_by('curso_id',$leccion->curso_id);
		$this->data['datos'] 		= model('tema')->get_by(['orden' => $orden, 'leccion_id' => $tema->leccion_id ]);
		$siguiente = $orden + 1;
		$anterior  = $orden - 1;
		$this->data['siguiente'] 	= model('tema')->get_by(['orden' => $siguiente, 'leccion_id' => $tema->leccion_id, 'es_actividad' => '1' ]);
		$this->data['anterior'] 	= model('tema')->get_by(['orden' => $anterior, 'leccion_id' => $tema->leccion_id, 'es_actividad' => '1' ]);



		$user = model('user')->get($this->session->userdata["identity"]);
		$eventousuario = model('eventousuario')->get_by('user_id',$user->id);
		$existe_nota = model('nota')->get_by(['eventousuario_id'=> $this->session->userdata['eventousuarios_id'], 'tema_id'=>$id]);
		if (!$existe_nota) {
			$datos = array(
				'nota'				=>	0,
				'eventousuario_id' 	=> $this->session->userdata['eventousuarios_id'],
				'tema_id'			=> $id,
				'intentos'			=>	0,
				'visto'				=>	1
			);
			model('nota')->insert($datos);
		}
		
		view('player',$this->data);
	}
	public function eliminar() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$id = $this->input->post('id');
		//$leccion_id = model('tema')->get_by('id',$id)->leccion_id;
		$respuesta = model('tema')->delete($id);
		//print_r($respuesta);
	}
	public function respuesta() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$respuesta 	= $this->input->post('respuesta');
		$punteo		= $this->input->post('punteo');
		$pregunta_id= $this->input->post('pregunta_id');
		if (!$respuesta) {
			echo "-1";
			return;
		}
		
		if (!$punteo) {
			$punteo = 0;
		}
		$data =array(
			'respuesta'		=> $respuesta,
			'valoracion'	=> $punteo,
			'pregunta_id'	=> $pregunta_id,
		);
		$result = model('respuesta')->insert($data);
		echo $result;
		return;
	}
	public function modificarLeccion() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$id 	= $this->input->post('id');
		$texto 	= $this->input->post('texto');
		$descripcion = $this->input->post('descripcion');
		$duracion = $this->input->post('duracion');
		if (!$texto) {
			echo -1;
			return;
		}
		if (!$descripcion) {
			echo -1;
			return;
		}
		$respuesta = model('leccion')->update($id,['titulo'=>$texto, 'descripcion'=>$descripcion, 'duracion'=>$duracion]);
		echo $respuesta; 
		//print_r($this->input->post());
	}
	public function modificarContenido() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		//print_r($this->input->post());
		$id 	= $this->input->post('id');
		$texto 	= $this->input->post('texto');
		$punteo = $this->input->post('punteo');
		$descripcion = $this->input->post('descripcion');
		if (!$texto) {
			echo -1;
			return;
		}
		print_r($this->input->post());
		$respuesta = model('tema')->update($id, ['titulo' => $texto, 'punteo'=> $punteo, 'descripcion'=> $descripcion]);
		echo $respuesta; 
	}
	public function modificarVideo() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		//print_r($this->input->post());
		$id = $this->input->post('id');
		$titulo = $this->input->post('nombre');
		$descripcion = $this->input->post('descripcion');
		$link = $this->input->post('link');
		if (!$titulo) {
			echo -1;
			return;
		}
		if (!$descripcion) {
			echo -1;
			return;
		}
		if (!$link) {
			echo -1;
			return;
		}
		$respuesta = model('tema')->update($id, ['titulo'=> $titulo, 'descripcion'=>$descripcion, 'link'=>$link]);
		return $respuesta;
	}
	public function modificarExamen() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		//print_r($this->input->post());
		$id = $this->input->post('id');
		$titulo = $this->input->post('nombre');
		$descripcion = $this->input->post('descripcion');
		$punteo = $this->input->post('punteo');
		if (!$titulo) {
			echo -1;
			return;
		}
		if (!$descripcion) {
			echo -1;
			return;
		}
		if (!$punteo) {
			echo -1;
			return;
		}
		$respuesta = model('tema')->update($id, ['titulo' => $titulo, 'descripcion' => $descripcion, 'punteo' => $punteo]);
		//echo $respuesta;
		return $respuesta;
	}
	public function modificarPregunta() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		//print_r($this->input->post());
		$id 	= $this->input->post('id');
		$texto 	= $this->input->post('texto');
		if (!$texto) {
			echo -1;
			return;
		}
		$respuesta = model('pregunta')->update($id, ['pregunta' => $texto]);
		echo $respuesta; 
	}
	public function modificarRespuesta()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		//print_r($this->input->post());
		$id 	= $this->input->post('id');
		$texto 	= $this->input->post('texto');
		$punteo = $this->input->post('punteo');
		if (!$texto) {
			echo -1;
			return;
		}
		if (!$punteo) {
			echo -1;
			return;
		}
		$respuesta = model('respuesta')->update($id, ['respuesta' => $texto, 'valoracion'=>$punteo]);
		echo $respuesta;
	}
	public function ponderar($id) {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$instructor = model('instructor')->get_by('email_instructor', $this->ion_auth->user()->row()->email);
        //print_r($this->session->userdata);
        $evento = model('evento')->get_by('id',$this->session->userdata('evento_id') );
        $this->data['evento'] = $evento;
        $this->data['no_evento'] = $evento->no_evento;
        $this->data['bandera'] = 3;
        $this->data['eventousuarios'] = model('eventousuario')->get_many_by('evento_id',$evento->id);
		$this->data['contenidos'] =  model('leccion')->order_by('orden', 'asc')->get_many_by('curso_id', $evento->curso_id);;
		$this->data['actividades'] = model('tema')->order_by('id','asc')->get_many_by(['curso_id'=>$this->session->userdata('curso_id'),'es_actividad' => 0]);
		$this->data['tema'] = model('tema')->get_by('id',$id);

		view('instructor/ponderar',$this->data);
	}
	public function participante($eventousuario_id) {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$instructor = model('instructor')->get_by('email_instructor', $this->ion_auth->user()->row()->email);
		$eventousuario = model('eventousuario')->get_by('id',$eventousuario_id);
		$usuario = model('user')->get_by('id',$eventousuario->user_id);

        //print_r($this->session->userdata);
        $evento = model('evento')->get_by('id',$this->session->userdata('evento_id') );
        $this->data['evento'] = $evento;
        $this->data['no_evento'] = $evento->no_evento;
        $this->data['bandera'] = 3;
		$this->data['eventousuario_id'] = $eventousuario_id;
		$this->data['contenidos'] =  model('leccion')->order_by('orden', 'asc')->get_many_by('curso_id', $evento->curso_id);;
		$this->data['actividades'] = model('tema')->order_by('id','asc')->get_many_by(['curso_id'=>$this->session->userdata('curso_id'),'es_actividad' => 0]);
		$this->data['usuario'] = $usuario;

		view('instructor/participante',$this->data);

	}
	public function guardar () {
		
		$eventousuario_id = $this->input->post('eventousuario_id');
		$tema_id = $this->input->post('tema_id');
		$punteo = $this->input->post('nota');
		$comentario = $this->input->post('comentario');

		//print_r($this->input->post());
		if (!$eventousuario_id){
			echo -1;
			return;
		}
		if (!$tema_id){
			echo -2;
			return;
		}
		if (!$punteo){
			echo -3;
			return;
		}
		if (!$comentario) {
			echo -4;
			return;
		}
		$tema = model('tema')->get_by('id',$tema_id);
		if ($punteo > $tema->punteo) {
			echo -3;
			return;
		}
		$nota = model('nota')->get_by(['eventousuario_id'=> $eventousuario_id, 'tema_id' => $tema_id ]);
		model('nota')->update($nota->id, ['nota' => $punteo,'comentario' => $comentario]);
		$archivo = model('archivos_tema')->get_by(['eventousuario_id'=> $eventousuario_id, 'tema_id' => $tema_id ]);
		model('archivos_tema')->update($archivo->id, ['comentario' => $comentario]);
		
		$asunto = 'Ponderación actividad: '. $tema->titulo;
		
		$mensaje = 'Se ha ponderado la actividad que subiste
			tu nota es de:<strong> '. $punteo . '.</strong> <br>
			El comentario sobre tu entrega: <strong>'. $comentario  . '</strong> <br>
			Si tienes dudas con respecto a tu punteo asignado, consulta con tu instructor';

		$this->enviar_email($asunto, $archivo->usuario, $mensaje);
		echo 1;
		return;
	}

	public function calificarsin() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$eventousuario_id = $this->input->post('eventousuario_id');
		$tema_id = $this->input->post('tema_id');
		$punteo = $this->input->post('punteo');
		$comentario = $this->input->post('comentario');
		$existe_nota = model('nota')->get_by(['eventousuario_id'=>$eventousuario_id,'tema_id'=>$tema_id]);
		if (!$existe_nota) {
			$datos = array(
				'eventousuario_id'	=>	$eventousuario_id
				,'tema_id'			=>	$tema_id
				,'nota'				=> 	$punteo
				,'comentario'		=>	$comentario
				,'visto'			=> 0
				,'intentos'			=> 0

			);
			model('nota')->insert($datos);
		} else {
			$datos = array(
				'eventousuario_id'	=>	$eventousuario_id
				,'tema_id'			=>	$tema_id
				,'nota'				=> 	$punteo
				,'comentario'		=>	$comentario
				,'visto'			=> 0
				,'intentos'			=> 0

			);
			model('nota')->update($existe_nota->id,$datos);
		}
		echo 1;
		

	}

	public function enviar_email($asunto, $email, $mensaje) {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$this->email->from('elearning.tics@intecap.edu.gt', 'Elearning INTECAP Centro Tics');
		$this->email->to($email);
		//$this->data['curso'] = 'Excel basico';
		$this->data['titulo'] = $asunto;
		$this->data['mensaje'] = $mensaje;
		$body = $this->load->view('/blades/password/email_template_v', $this->data, TRUE);

		$this->email->subject($asunto);
		$this->email->message($body);
		if ($this->email->send()) {
			//echo"Your email was sent successfully";
		} else {
			show_error($this->email->print_debugger());
		}
	}


	function timeString($ptime) {
		$etime = time() - $ptime;
		if ($etime < 1)
		{
			return '0 seconds';
		}

		$a = array( 365 * 24 * 60 * 60  =>  'año',
					30 * 24 * 60 * 60  =>  'mes',
						24 * 60 * 60  =>  'dia',
							60 * 60  =>  'hora',
									60  =>  'minuto',
									1  =>  'segundo'
					);
		$a_plural = array( 'año'   	=> 'años',
						'mes'  		=> 'meses',
						'dia'    	=> 'dias',
						'hora'   	=> 'horas',
						'minuto' 	=> 'minutos',
						'segundo' 	=> 'segundos'
					);

		foreach ($a as $secs => $str)
		{
			$d = $etime / $secs;
			if ($d >= 1)
			{
				$r = round($d);
				return 'hace '. $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) ;
			}
		}
	}
}