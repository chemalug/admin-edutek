<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leccion extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		
		$this->name = 'leccion';
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
		if ($this->ion_auth->get_users_groups()->row()->id == 1 || $this->ion_auth->get_users_groups()->row()->id == 5 ) {// compara el rol del usuario, 1 = administrador
			view('dashboard', $this->data);
		} elseif ($this->ion_auth->get_users_groups()->row()->id == 2) { // compara el rol del usuario, 2 = instructor
			view('dashboard_i', $this->data);
		} elseif ($this->ion_auth->get_users_groups()->row()->id == 3) { // compara el rol del usuario, 3 = estudiantes
			$this->data['contenidos'] =  model('tema')->order_by('orden','asc')->get_all();
			view('dashboard_e', $this->data);
		}
    }
    public function agregar() {
        if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$titulo         = $this->input->post('titulo');
		$descripcion    = $this->input->post('descripcion');
		$curso_id 		= $this->input->post('curso_id');
		$duracion 		= $this->input->post('duracion');

		//aqui va la duracion 
		$orden 	      	= model('leccion')->get_count($curso_id) + 1;

		if (!$titulo) {
			echo '0';
			return;
		}
		if (!$descripcion) {
			echo '0';
			return;
		}
		
		if(!isset($duracion))
			$duracion = 1000;

        $data = array(
            'titulo'        => $titulo, 
			'descripcion'   => $descripcion,
			'orden'			=> $orden,
			'curso_id'		=> $curso_id,
			'duracion'	=> $duracion,
        );
        $respuesta = model('leccion')->insert($data);
		//redirect($this->name.'/construir');
		echo $respuesta;
        return;
	}

	public function actividad(){
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		} elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
			$this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
			redirect('/');
		}
		/*$config['upload_path']          = base_url().'./uploads/';
    	$config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 2000;
        $config['max_width']            = 5000;
        $config['max_height']           = 2000;
		$this->load->library('upload', $config);
		if ( !$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());
			print_r($error);
		} else {
            $data = array('upload_data' => $this->upload->data());
            $this->load->view('upload_success', $data);
		}*/
		//print_r($this->input->post());
		$leccion 		= $this->input->post('leccion');
		$titulo 		= $this->input->post('titulo');
		$descripcion 	= $this->input->post('descripcion');
		$punteo 		= $this->input->post('punteo');
		
		//$orden 			= model('leccion')->count_all();
		$posicion       = model('tema')->get_count($leccion) + 1;
		$data = array(
            'titulo'        => $titulo, 
            'descripcion'   => $descripcion,
            'punteo'        => $punteo,
            'es_actividad'  => 0,
			'orden'         => $posicion,
			'leccion_id'	=> $leccion,
			'curso_id'		=> $this->session->userdata('curso_id'),
        );
		$respuesta = model('tema')->insert($data);
		echo $respuesta;
	}
	public function video(){
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		} elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
			$this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
			redirect('/');
		}
		/*$config['upload_path']          = base_url().'./uploads/';
    	$config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 2000;
        $config['max_width']            = 5000;
        $config['max_height']           = 2000;
		$this->load->library('upload', $config);
		if ( !$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());
			print_r($error);
		} else {
            $data = array('upload_data' => $this->upload->data());
            $this->load->view('upload_success', $data);
		}*/
		//print_r($this->input->post());
		$leccion 		= $this->input->post('leccion');
		$titulo 		= $this->input->post('titulo');
		$descripcion 	= $this->input->post('descripcion');
		$link 			= 'https://player.vimeo.com/video/';
		$link	 		.= $this->input->post('link');
		
		//$orden 			= model('leccion')->count_all();
		$posicion       = model('tema')->get_count($leccion) + 1;
		$data = array(
            'titulo'        => $titulo, 
            'descripcion'   => $descripcion,
            'link'	        => $link,
            'es_actividad'  => 1,
			'orden'         => $posicion,
			'leccion_id'	=> $leccion,
			'curso_id'		=> $this->session->userdata('curso_id'),
        );
		$respuesta = model('tema')->insert($data);
		echo $respuesta;
	}
	public function construir ($id) {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		} elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
			$this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
			redirect('/');
		}
		$this->reordenar();
		$this->data['lecciones'] = model('leccion')->order_by('orden','asc')->get_many_by('curso_id',$id);
		$this->data['curso_id'] = $id;
		$this->session->set_userdata('curso_id', $id);
		$totales = 0;
		foreach ($this->data['lecciones'] as $value) {
			$temas = model('tema')->get_many_by(['leccion_id'=> $value->id]);
			foreach ($temas as $tema) {
				$totales = $totales + $tema->punteo;
			}
		}
		if ($totales > 100) {
			$this->data['mensaje']	= 'El punteo general del curso sobrepasa los 100 puntos, verifica por favor';	
		}
		$this->data['total_punteo']	= $totales;
		$path = 'administrador/'. $this->name .'/build2';
		
        view($path, $this->data);
	}
	public function ordenar() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		} elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
			$this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
			redirect('/');
		}
		$data = $this->input->post();
		print_r($data);
		$dataA = $this->input->post('a');
		$dataB = $this->input->post('b');
		
		$datosA = explode(';',$dataA);
		
		foreach ($datosA as $key => $value) {
            $contador = explode('-',$value)[2];
			$id = explode('-',$value)[1];
			model('leccion')->update($id,['orden'=>$contador]);
		}
		$datosB = explode(';',$dataB);
		
		foreach ($datosB as $key => $value) {
            $contador = explode('-',$value)[3];
			$id = explode('-',$value)[1];
			model('tema')->update($id,['orden'=>$contador]);
		}
		//redirect('leccion/construir');
		//print_r($datos);
        /*
        $contador = 0;
        foreach ($datos as $key => $value) {
            $contador++;
			$id = explode('-',$value)[0];
			$char = explode('-',$value)[2];
			if ($char == 'a') {
				model('leccion')->update($id,['orden'=>$contador]);
			} elseif ($char == 'b') { 
				model('tema')->update($id,['orden'=>$contador]);
			}
        }*/
	}
	public function archivos($id) {

	}

	private function reordenar() {
		$lecciones = model('leccion')->get_all();
		foreach($lecciones as $leccion) {
			$temas = model('tema')->order_by('orden','asc')->get_many_by('leccion_id',$leccion->id);
	
			$contador = 0;
			foreach($temas as $tema) {
				$contador ++;
				model('tema')->update($tema->id, ['orden' => $contador]);
			}
		}
	}
	public function eliminar() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$id = $this->input->post('id');
		$respuesta = model('leccion')->delete($id);
	}

	public function subir($id) {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		} elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
			$this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
			redirect('/');
		}
		$this->data['id'] = $id;
		$path = 'administrador/'. $this->name .'/subir';
        view($path, $this->data);
	}

	public function subiendo() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload') {
			// get details of the uploaded file
			$fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
			$fileName = $_FILES['uploadedFile']['name'];
			$fileSize = $_FILES['uploadedFile']['size'];
			$fileType = $_FILES['uploadedFile']['type'];
			$fileNameCmps = explode(".", $fileName);
			$fileExtension = strtolower(end($fileNameCmps));
			$newFileName = md5(time() . $fileName) . '.' . $fileExtension;
			// directory in which the uploaded file will be moved
			$id = $this->input->post('id');
			$leccion_id = model('tema')->get_by('id', $id)->leccion_id;
			$curso_id = model('leccion')->get_by('id', $leccion_id)->curso_id;

			$uploadFileDir = './uploads/' . str_replace(' ', '', model('curso')->get_by('id', $curso_id)->nombre);
			if (!file_exists($uploadFileDir)) {
				mkdir($uploadFileDir, 0777, true);
			}
			$dest_path = $uploadFileDir .'/'. str_replace(' ', '', $fileName);
			
			
			model('tema')->update($id,['archivo'=>$dest_path]);
			if(move_uploaded_file($fileTmpPath, $dest_path)) {
				$message ='File is successfully uploaded.';
				$this->session->set_flashdata('message', '¡Archivo cargado satisfactoriamente!');
				redirect('leccion/construir/'.$curso_id);
			} else {
				$message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
			}
		}
		
	}
	public function examen() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$leccion 		= $this->input->post('leccion');
		$titulo 		= $this->input->post('titulo');
		$descripcion 	= $this->input->post('descripcion');
		$punteo	 		= $this->input->post('punteo');
		$posicion       = model('tema')->get_count($leccion) + 1;
		$data = array(
            'titulo'        => $titulo, 
            'descripcion'   => $descripcion,
            'punteo'	    => $punteo,
            'es_actividad'  => 2,
			'orden'         => $posicion,
			'leccion_id'	=> $leccion,
			'curso_id'		=> $this->session->userdata('curso_id'),
        );
		$respuesta = model('tema')->insert($data);
		echo $respuesta;
	}
	public function ponderar() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$eventousuario 	= $this->input->post('eventousuario');
		$tema			= $this->input->post('tema');
		$nota			= $this->input->post('valor');
		if (!$eventousuario) {
			echo -1;
			return;
		}
		if (!$tema) {
			echo -1;
			return;
		}
		if (!$nota) {
			if ($nota != 0 ) {
				echo -1;
				return;
			}
		}
		//validar que la nota ingresada no sea mayor a la asignada en la tabla temas
		if ($nota > model('tema')->get_by('id',$tema)->punteo) {
			echo -2;
			return;
		}
		$existe_registro = model('nota')->get_by(['eventousuario_id' => $eventousuario, 'tema_id' => $tema]);
		if (!$existe_registro) {
			$datos = array(
				'nota'				=> $nota,
				'eventousuario_id' 	=> $eventousuario,
				'tema_id'			=> $tema,
				'intentos'			=>	0,
				'visto'				=>	1
			);
			model('nota')->insert($datos);
			$this->actualizarpunteo($eventousuario);
			echo 1;
			return;
		} else {
			$datos = array(
				'nota'				=> $nota,
				'eventousuario_id' 	=> $eventousuario,
				'tema_id'			=> $tema,
				'intentos'			=>	0,
				'visto'				=>	1
			);
			model('nota')->update($existe_registro->id, $datos);
			$this->actualizarpunteo($eventousuario);
			echo 1;
			return;
		}
		$notas = model('nota')->get_many_by('eventousuario_id',$eventousuario);
		$suma = 0;
		foreach ($notas as $nota) {
			$suma = $suma + $nota->nota;
		}
		model('eventousuario')->update($eventousuario,['progreso'=> $suma]);
		//consultar si existe registro del eventousuario con el tema
		
	}
	private function actualizarpunteo($eventousuario) {
		$total = 0.0;
		foreach (model('nota')->get_many_by('eventousuario_id',$eventousuario) as $value) {
			$total = $value->nota + $total;
		}
		model('eventousuario')->update($eventousuario,['progreso' => $total ]);
		
	}

	public function getPunteo()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$eventousuario = $this->input->post('eventousuario');
		$total = 0.0;
		foreach (model('nota')->get_many_by('eventousuario_id', $eventousuario) as $value) {
			$total = $value->nota + $total;
		}
		model('eventousuario')->update($eventousuario, ['progreso' => $total]);
		echo $total;
	}
	public function comentario() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$eventousuario 	= $this->input->post('eventousuario');
		$tema			= $this->input->post('tema');
		$actualizacion	= $this->input->post('actualizacion');
		$texto			= $this->input->post('comentario');
		//print_r($this->input->post());
		$nota = model('nota')->get_by(['eventousuario_id' => $eventousuario, 'tema_id' => $tema]);

		if (!$eventousuario) {
			echo -1;
			return;
		}
		if (!$tema) {
			echo -1;
			return;
		}
		if ($actualizacion == 0) {
			//$comentario = model('archivos_tema')->get_by(['eventousuario_id' => $eventousuario, 'tema_id' => $tema])->comentario;
			print_r($nota->comentario);

		} elseif ($actualizacion == 1) {
			$idtabla = model('archivos_tema')->get_by(['eventousuario_id' => $eventousuario, 'tema_id' => $tema])->id;
			$asunto = 'Ponderación actividad: '. model('tema')->get_by('id',$tema)->titulo;
			$email = model('archivos_tema')->get_by(['eventousuario_id' => $eventousuario, 'tema_id' => $tema])->usuario;
			$mensaje = 'Se ha ponderado la actividad que subiste
						tu nota es de:<strong> '. $nota->nota . '.</strong> <br>
						El comentario sobre tu entrega: <strong>'. $texto  . '</strong> <br>
						Si tienes dudas con respecto a tu punteo asignado, consulta con tu instructor';
			model('archivos_tema')->update($idtabla, ['comentario' => $texto]);
			model('nota')->update($nota->id,['comentario' => $texto]);
			$this->enviar_email($asunto, $email, $mensaje);
		}

	}
	public function cerrar(){
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$evento_id = $this->input->post('id');
		$evento = model('evento')->get_by('id',$evento_id);
		if ($evento->estado == 0) {
			return;
		}
		$curso = model('curso')->get_by('id',$evento->curso_id);
		$eventousuario = model('eventousuario')->get_many_by('evento_id',$evento_id);
		//print_r($eventousuario);
		
		$asunto = 'Finalización del evento: ' . $evento->no_evento . '';
		foreach ($eventousuario as $value) {
			$user = model('user')->get_by('id',$value->user_id);
			
			$token = $this->get_token();
			/*do {
				$token = $this->get_token();
				$token = '12345678';
				$existe = $this->db->query('SELECT COUNT(*) AS EXISTE FROM mydb2.verificacions WHERE token = "'.$token. '" COLLATE utf8_unicode_ci;');
				print_r($existe->row()->EXISTE);
			} while ($existe->row()->EXISTE == 1);*/
			//$query = 'INSERT INTO mydb2.verificacions 
			$query = 'INSERT INTO intecapt_constancias.verificacions 
			(nombres, apellidos, curso_id, nombre_curso, evento_id, no_evento, fecha_inicio, fecha_final, duracion, token, carnet, email) VALUES 
			("'.$user->first_name.'","'.$user->last_name.'","'.$curso->id.'","'.$curso->nombre.'","'.$evento_id.'","'.$evento->no_evento.'","'.$evento->fecha_inicio.'","'.$evento->fecha_final.'","'.$evento->no_horas.'","'.$token.'","'.$user->carnet.'","'.$user->email.'")';
			$resultado = $this->db->query($query);
			if ($value->progreso >= 70) {
				$mensaje = 'Te notificamos que el evento: <strong>' . $evento->no_evento . '</strong>, del curso <strong>' . $curso->nombre . '</strong> de ha finalizado, 
				por favor descarga tu constancia de participacion con el siguiente token: <strong>'. $token .'.</strong> <br> ';
			} else {
				$mensaje = 'Te notificamos que el evento: <strong>' . $evento->no_evento . '</strong>, del curso <strong>' . $curso->nombre . '</strong> de ha finalizado ,
				gracias por participar en el evento';	
			}


			//$this->enviar_email($asunto,'chemalug@gmail.com',$mensaje);
			$this->enviar_email($asunto, $user->email, $mensaje);

		}
		model('evento')->update($evento_id,['estado'=> 0]);
		echo 1;
	}
	private function get_token() {
		$authorizedChar = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$codigo_verificacion = '';
		$codigo_verificacion = substr(str_shuffle($authorizedChar), 0, 8);
		return $codigo_verificacion;
	}
	//-----------------------------------funcion de envio de emails
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

}