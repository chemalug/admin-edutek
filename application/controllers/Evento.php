<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evento extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->name = 'evento';
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
	public function index()	{
        $config['upload_path']          = base_url() . 'uploads/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 5000;
        $config['max_width']            = 5000;
        $config['max_height']           = 2000;

        $this->load->library('upload', $config);

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		view('dashboard', $this->data);
    }

    public function dosificacion($id) { 
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->users(2)->result()) {
            $this->session->set_flashdata('message', '¡Debes ser un instructor para ver esta página!');
            redirect('/');
        }

        $instructor = model('instructor')->get_by('email_instructor', $this->ion_auth->user()->row()->email);
        $this->data['eventos']              = model('evento')->get_many_by('instructor_id', $instructor->id);
        $this->data['existe_participantes'] = model('eventousuario')->count_by('evento_id', $id);
        $this->data['eventousuario']        = model('eventousuario')->get_many_by('evento_id', $id);
        $evento = model('evento')->get_by('id', $id);
        //print_r($evento);
        date_default_timezone_set('America/Guatemala');
        $hoy = date('Y-m-d'); 
        if ($hoy < $evento->fecha_final) {
            $this->data['banderacerrar'] = 0;
        } elseif ($hoy >= $evento->fecha_final) {
            if ($evento->estado == 0) {
                $this->data['banderacerrar'] = 0;
            } else {
                $this->data['banderacerrar'] = 1;
            }
        }
        
        $evento_data = model('evento')->get_by('id', $id);

        $this->data["evento_data"]=$evento_data;
        $this->data["id"]=$id;
        view('evento/upload', $this->data);


    }


    public function evento($id) {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->users(2)->result()) {
            $this->session->set_flashdata('message', '¡Debes ser un instructor para ver esta página!');
            redirect('/');
        }
        $instructor = model('instructor')->get_by('email_instructor', $this->ion_auth->user()->row()->email);
        $this->data['eventos']              = model('evento')->get_many_by('instructor_id', $instructor->id);
        $this->data['existe_participantes'] = model('eventousuario')->count_by('evento_id', $id);
        $this->data['eventousuario']        = model('eventousuario')->get_many_by('evento_id', $id);
        $evento = model('evento')->get_by('id', $id);
        //print_r($evento);
        date_default_timezone_set('America/Guatemala');
        $hoy = date('Y-m-d'); 
        if ($hoy < $evento->fecha_final) {
            //$this->data['banderacerrar'] = 0; descomentar esta y borrar la siguiente
            $this->data['banderacerrar'] = 1;
        } elseif ($hoy >= $evento->fecha_final) {
            if ($evento->estado == 0) {
                //$this->data['banderacerrar'] = 0; descomentar esta y borrar la siguiente
                $this->data['banderacerrar'] = 1;
            } else {
                $this->data['banderacerrar'] = 1;
            }
        }

        //$this->data['evento'] = $evento;
        $this->data['evento_id'] = $id;
        $this->session->set_userdata('eventousuario', $this->data['eventousuario']);
        $this->session->set_userdata('evento_no', model('evento')->get_by('id', $id));
        $this->data['bandera'] = 2;
        $this->session->set_userdata('evento_id', $id);
        $this->session->set_userdata('curso_id', $evento->curso_id);
        $this->session->set_userdata('instructor_id', $evento->instructor_id);
        view('instructor/index', $this->data);

    }

    
    public function notas(){
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->users(2)->result()) {
            $this->session->set_flashdata('message', '¡Debes ser un instructor para ver esta página!');
            redirect('/');
        }

        $this->data['bandera'] = 2;
        $this->data['evento_id'] = $this->session->userdata('evento_id');
        $this->data['eventos'] = model('eventousuario')->get_many_by('user_id',$this->data['user']->id);
        $this->data['temas'] = model('tema')->get_many_by('curso_id',$this->session->userdata('curso_id'));
        $curso_id = $this->session->userdata('curso_id');
        $user = model('user')->get($this->session->userdata["identity"]);
        $this->data['user'] = $user;
        $user_id = $this->data['user_id'] = $this->data['user']->id;
        $this->data['evento_no'] = $this->session->userdata('evento_no');
        $this->data['contenidos'] =  model('leccion')->order_by('orden','asc')->get_many_by(['curso_id'=>$curso_id ]);


        //print_r($this->session->userdata());
        //print_r($this->data['temas'] );
        view('blades/est/notas',$this->data);
    }
    private function get_token() {
    	$authorizedChar = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789&@=.:;_-";
    	$codigo_verificacion = '';
    	$codigo_verificacion = substr(str_shuffle($authorizedChar), 0, 8);
    	return $codigo_verificacion;
    }
    public function agregarParticipante() {
        
        $carnet     = $this->input->post('carnet');
        $nombres    = $this->input->post('nombres');
        $apellidos  = $this->input->post('apellidos');
        $email      = $this->input->post('email');
        $evento_id  = $this->session->userdata('evento_id');
        if (!$carnet) {
            echo '-1';
            return;
        }
        if (!$nombres) {
            echo '-2';
            return;
        }
        if (!$apellidos) {
            echo '-3';
            return;
        }
        if (!$email) {
            echo '-4'; 
            return;
        }
        $existe_participante = model('user')->get_by('username',$email);
        if ($existe_participante == null) {
            $password = $this->get_token();
            $user_id = $this->ion_auth->register($email, $password, $email, array( 'first_name' => $nombres, 'last_name' => $apellidos,'active' => '1','carnet'=>$carnet ), array('3') );
            
            $data = array(
                'user_id'   => $user_id, 
                'evento_id' => $evento_id,
                'progreso'  => '0.00'
            );
            model('eventousuario')->insert($data);

            /*$this->email->from('intecap@intecap.tech', 'Elearning INTECAP Centro Tics');
			$this->email->to($email);
			$this->data['email'] = $email;
			$this->data['pass'] = $password;
			$body = $this->load->view('/auth/email/send_pasword',$this->data,TRUE);*/
//----------------------------------------------------- aqui va el mensaje de bienvenida
            $asunto = 'Ingreso a la plataforma';
            $mensaje = 'Bienvenido a la plataforma, se te ha creado la cuenta con las siguientes credenciales <br>
							<strong>Usuario:  </strong>' . $email . ' <br>
							<strong>Password: </strong>' . $password;
            $this->enviar_email($asunto, $email, $mensaje);


			/*$this->email->subject('Intecap CTI - Accesos a la plataforma Elearning');
            $this->email->message($body);
            ob_start();
            try {
                if ($this->email->send()) {
                echo "0";
                return;
			} else {
                var_dump(error_get_last());
                error_clear_last();
                var_dump(error_get_last());
                
                ob_end_clean();
                echo '-5';
                return;
			}
            } catch (Exception $e) {
                
                echo '-5';
            }*/
			
        } else {
            
            $existe_usuario_evento = model('eventousuario')->get_by(['user_id'   => $existe_participante->id, 'evento_id' => $evento_id,]);
            if ($existe_usuario_evento == null) {
                $data = array(
                    'user_id'   => $existe_participante->id, 
                    'evento_id' => $evento_id,
                    'progreso'  => '0.00'
                );
                
                model('eventousuario')->insert($data);
                
                $evento = model('evento')->get_by('id',$evento_id);
                $instructor = model('instructor')->get_by('email_instructor',$this->session->userdata('email'));
                $curso = model('curso')->get_by('id',$evento->curso_id);
                $asunto = 'Ingreso a la plataforma';
                $mensaje = '<br>Bienvenido:<br>

                            INTECAP le da la más cordial bienvenida al curso de <b>'. $curso->nombre.'</b>, mi nombre es
                            <b>'. $instructor->nombre_instructor .', ' . $instructor->apellido_instructor .'</b>, soy el tutor asignado.<br><br>
                            Mi objetivo es apoyarlo, supervisar el desarrollo de su aprendizaje y resolver dudas u observaciones, durante el tiempo que dure el curso.</br>

                            Puede comunicarse con mi persona por medio de la plataforma o al correo <b>'. $instructor->email_instructor.'</b><br><br>

                            Su curso estará disponible del <b>'. $evento->fecha_inicio .'</b> hasta el <b>'. $evento->fecha_final .'</b> (no se realizarán prorrogas). 
                            Puede ingresar en el horario que usted pueda ya que está habilitado las 24 horas.  Se sugiere que le pueda dedicar por lo menos una hora diaria.<br><br>


                            Adjunto el vínculo al normativo del participante, es una lectura obligatoria. <a href="'. base_url() .'files/normativo.pdf"> VER DOCUMENTO </a><br><br>

                            Una vez ingrese a la plataforma le recomendamos ver los videos sobre el uso de la misma, la entrega de tareas y la forma de realizar evaluaciones.<br>

                            Atentamente,<br>

                            <b>'. $instructor->nombre_instructor .', ' . $instructor->apellido_instructor .'<b><br>

                            Instructor.';

                //print_r($this->session->userdata);
                $this->enviar_email($asunto, $email.', '.$instructor->email_instructor, $mensaje);
                echo "0";
                return;
            } else {
                echo '-6';
                return;
            }

        }
        echo '0';
    }
    public function archivo() {
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
			$uploadFileDir = './uploads/listado/';
			$dest_path = $uploadFileDir . $fileName;
			
            $id = $this->input->post('evento_id');
            
			//model('tema')->update($id,['archivo'=>$fileName]);
			if(move_uploaded_file($fileTmpPath, $dest_path)) {
				$message ='File is successfully uploaded.';
				$this->session->set_flashdata('message', '¡Archivo cargado satisfactoriamente!'.$id);
				
			} else {
				$message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
			}
        }
    }
    public function listar() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
            $this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
            redirect('/');
        }
        $this->data['list'] = model('evento')->order_by('fecha_inicio','desc')->get_all();
        view('administrador/'.$this->name.'/show', $this->data);
    }    
    
    public function agregar() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
            $this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
            redirect('/');
        }
        $this->data['instructores'] = model('instructor')->get_all();
        $this->data['cursos'] = model('curso')->get_all();
        view('administrador/'.$this->name.'/add', $this->data);
    }
    public function editar($id) {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
            $this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
            redirect('/');
        }
        $this->data['instructores'] = model('instructor')->get_all();
        $this->data['cursos'] = model('curso')->get_all();
        $this->data['datos'] = model('evento')->get_by('id',$id);
        view('administrador/' . $this->name . '/edit', $this->data);
    }
    
    public function addaction() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
            $this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
            redirect('/');
        }
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', 'Hacen falta algunos datos');
            redirect(site_url($this->name).'/agregar');
        } else {
            foreach ($this->items as $key => $value) {
                if ($key != 'id') {
                    $data[$key] = $this->input->post($key,TRUE);
                }
            }
//--------- zona de validaciones y condiciones para asegurar que los datos en el array $data sean válidos

//--------- termina zona de validaciones
            //inserción de los datos
            $data['estado'] = 1;
            $data['fecha_alargue'] = $data['fecha_final'];
            $data['porcentaje'] = 0;
            
            $respuesta = model('evento')->insert($data);
            
            if ($respuesta != 0) {
                $this->session->set_flashdata('message', '¡Dato agregado correctamente!');
                $this->data['list'] = model('evento')->get_all();
                redirect($this->name.'/listar');
            } else {
                $this->session->set_flashdata('message', '¡Ocurrió un problema en la inserción!');
                view('administrador/'.$this->name.'/add', $this->data);
            }
        }
        
    }
    public function editaction() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
            $this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
            redirect('/');
        }

        
        //    $this->session->set_flashdata('message', 'Hacen falta algunos datos');
        //    redirect(site_url($this->name) . '/edit/'. $this->input->post('id'));
        
            foreach ($this->items as $key => $value) {
                if ($key != 'id') {
                    $data[$key] = $this->input->post($key, TRUE);
                }
            }
            //--------- zona de validaciones y condiciones para asegurar que los datos en el array $data sean válidos

            //--------- termina zona de validaciones
            //inserción de los datos
            $data['estado'] = 1;
            $data['fecha_alargue'] = $data['fecha_final'];
            $data['porcentaje'] = 0;
            //$data['id'] = $this->input->post('id');

            //print_r($data);
            $respuesta = model('evento')->update($this->input->post('id'),$data);
            /*$respuesta = model('evento')->insert($data);*/

            if ($respuesta != 0) {
                $this->session->set_flashdata('message', '¡Registros editados correctamente!');
                $this->data['list'] = model('evento')->get_all();
                redirect($this->name . '/listar');
            } else {
                $this->session->set_flashdata('message', '¡Ocurrió un problema en la inserción!');
                view('administrador/' . $this->name . '/edit', $this->data);
            }
        
    }
    public function addtema() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $titulo         = $this->input->post('titulo');
        $descripcion    = $this->input->post('descripcion');
        $link           = $this->input->post('link');
        $punteo         = $this->input->post('punteo');
        $es_actividad   = $this->input->post('es_actividad');
        //$posicion       = model('tema')->get_count() + 1;
        $data = array(
            'titulo'        => $titulo, 
            'descripcion'   => $descripcion,
            'link'          => $link,
            'punteo'        => $punteo,
            'es_actividad'  => $es_actividad,
            //'orden'         => $posicion,
        );
        $respuesta = model('tema')->insert($data);
        redirect($this->name.'/construir');
        return $respuesta;
    }
    public function getConteo() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        return model('tema')->get_count();
    }
    private function _rules() {
        foreach ($this->items as $key => $value) {
            if ($value != null) {
                $this->form_validation->set_rules($key , ' ', $value);
            }
        }
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function construir () {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
            $this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
            redirect('/');
        }
        $this->data['lecciones'] = model('leccion')->get_all();
        
        $path = 'administrador/'.$this->name.'/build2';
        view($path, $this->data);
    }
    public function ordenar() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $data = $this->input->post();
        $datos = explode(';',$data['data']);
        $contador = 0;
        foreach ($datos as $key => $value) {
            $contador++;
            $id = explode('-',$value)[0];
            model('tema')->update($id,['orden'=>$contador]);
        }
    }
    public function modificarfecha(){
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        //print_r($this->input->post());
        $fecha  = $this->input->post('fecha');
        $id     = $this->input->post('id');
        $fecha_final = model('evento')->get_by('id',$id)->fecha_final;
        if (!$fecha) {
            echo -1;
            return;
        }
        if ($fecha_final >= $fecha) {
            echo -2;
            return;
        }
        $respuesta = model('evento')->update($id,['fecha_alargue'=> $fecha]);
        echo $respuesta;
    }
    public function evaluar($id) {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $instructor = model('instructor')->get_by('email_instructor', $this->ion_auth->user()->row()->email);
        $this->data['eventos'] = model('evento')->get_many_by('instructor_id', $instructor->id);
        $evento = model('evento')->get_by('id', $id);
        $this->data['evento'] = $evento;
        $this->data['no_evento'] = $evento->no_evento;
        $this->data['bandera'] = 2;
        $this->data['eventousuarios'] = model('eventousuario')->get_many_by('evento_id',$evento->id);
        $this->data['contenidos'] =  model('leccion')->order_by('orden', 'asc')->get_many_by('curso_id', $evento->curso_id);;

        view('instructor/evaluar', $this->data);
    }
    public function participante() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $carnet = $this->input->post('carnet'); 
        if (!$carnet) {
            echo 0;
            return ;
        }
        $user = model('user')->get_by('carnet',$carnet);
        if ($user ) {
            $respuesta = array(
                'nombres'   => $user->first_name,
                'apellidos' => $user->last_name,
                'email'     => $user->email
             );
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            return;
        } else {
            echo 0;
            return;
        }
    }
    public function eliminarevento() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $id = $this->input->post('id');
        $respuesta = model('evento')->delete($id);
        echo $id;
        return;
        /*$sql = 'select * from intecapt_constancias.eventos';
        
        $respuesta = $this->db->query($sql);
        print_r($respuesta->result_array());*/
    }
    public function getinstructor(){
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $respuesta = model('instructor')->get_all();
        echo json_encode($respuesta);
    }
    public function modificareventoinstructor(){
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $instructor_id  = $this->input->post('instructor_id');
        $evento_id      = $this->input->post('evento_id');
        if (!$instructor_id) {
            echo -1;
            return;
        }
        $respuesta = model('evento')->update($evento_id,['instructor_id'=>$instructor_id]);
        echo $respuesta;
        $asunto = 'Asignación al evento '. model('evento')->get_by('id', $evento_id)->no_evento;
        $mensaje = 'Se te ha asignado el evento: <strong>'. model('evento')->get_by('id', $evento_id)->no_evento . '</strong>, del curso: <strong>' . model('curso')->get_by('id', model('evento')->get_by('id', $evento_id)->curso_id)->nombre . '</strong>';
        $this->enviar_email($asunto, model('instructor')->get_by('id',$instructor_id)->email_instructor, $mensaje);
        return;
    }
    public function confirmarEliminar() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $email      = model('user')->get($this->session->userdata["identity"])->email;
        $password   = $this->input->post('password');
        //print_r($this->input->post());
        $respuesta = $this->ion_auth->login($email,$password);
        print_r($respuesta);
    }
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
    public function inscripcionArchivo(){
    
        //print_r($_FILES);
        $file = $this->uploaded($_FILES['fileToUpload'], 'fileToUpload','participantes','./uploads/assets',$this->session->userdata('evento_id'));
        $excel = PHPExcel_IOFactory::load($file);
        $cell = $excel->getActiveSheet()->getCellCollection();
        $arr_data = null;
        //print_r($excel);
        foreach ($cell as $key) {
            $columna = $excel->getActiveSheet()->getCell($key)->getColumn();
            $fila    = $excel->getActiveSheet()->getCell($key)->getRow();
            $dato   = $excel->getActiveSheet()->getCell($key)->getValue();
            if ($fila >= 10 ) {
                $arr_data[$fila][$columna] = $dato;
            }
            //$this->data['cabecera'] = $header;
        }
        //print_r($arr_data);
        $datos = array();
        foreach ($arr_data as $key => $value) {
            $listado= (object) array(
                'carnet'        => $value['B'],
                'nombre'        => $value['C'],
                'apellido'      => $value['D'],
                'email'         => $value['E'],
                'telefono'      => $value['F'],
            );
            echo $listado->carnet;
            $this->inscribirParticipante($listado->carnet, $listado->nombre, $listado->apellido, $listado->email, $listado->telefono, $this->session->userdata('evento_id'));
            echo '<br>';
            //array_push($datos,$listado);
        }
        redirect('/');
        //print_r($datos);
    }
    private function inscribirParticipante($carnet, $nombres, $apellidos, $email, $telefono, $evento_id) {
        if (!$carnet) {
            echo '-1';
            return;
        }
        if (!$nombres) {
            echo '-2';
            return;
        }
        if (!$apellidos) {
            echo '-3';
            return;
        }
        if (!$email) {
            echo '-4';
            return;
        }
        $existe_participante = model('user')->get_by('username', $email);
        if ($existe_participante == null) {
            $password = $this->get_token();
            $user_id = $this->ion_auth->register($email, $password, $email, array('first_name' => $nombres, 'last_name' => $apellidos, 'active' => '1', 'carnet' => $carnet, 'telefono' => $telefono), array('3'));

            $data = array(
                'user_id'   => $user_id,
                'evento_id' => $evento_id,
                'progreso'  => '0.00'
            );
            model('eventousuario')->insert($data);
            $asunto = 'Ingreso a la plataforma';
            $mensaje = 'Bienvenido a la plataforma, se te ha creado la cuenta con las siguientes credenciales <br>
							<strong>Usuario:  </strong>' . $email . ' <br>
							<strong>Password: </strong>' . $password;
            $this->enviar_email($asunto, $email, $mensaje);
            echo 'envió email<br>';
        } else {
            $existe_usuario_evento = model('eventousuario')->get_by(['user_id'   => $existe_participante->id, 'evento_id' => $evento_id,]);
            if ($existe_usuario_evento == null) {
                $data = array(
                    'user_id'   => $existe_participante->id,
                    'evento_id' => $evento_id,
                    'progreso'  => '0.00'
                );
                model('eventousuario')->insert($data);
                echo "0";
                return;
            } else {
                echo '-6';
                return;
            }
        }
        echo '0';
    }
    private function uploaded($file, $id, $prex, $destino, $name) {
        $archivo = $file['name']; //captura el nombre del archivo
        $nombre  = str_replace(' ', '', $name);
        $nuevo_nombre_archivo = $nombre . "_" . $prex;
        $partir = explode(".", $archivo);
        $ext = $partir[count($partir) - 1];
        $nuevo_nombre_archivo  .= "." . $ext;
        $path = $destino . '/' . $nombre . '/';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $full_path = $path . $nuevo_nombre_archivo;
        $archivo = (isset($file)) ? $file : null;

        move_uploaded_file($file['tmp_name'], $full_path);
        return $full_path;
    }





    public function subir_archivo($evento_id)
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
	
         $usuario = $this->session->userdata["identity"];
         
        $archivo = $_FILES['archivo']['name']; //captura el nombre del archivo


        $nuevo_nombre_archivo = "evento -- " . $evento_id . "--". $archivo;
        $partir = explode(".", $archivo);
        $ext = $partir[count($partir) - 1];
        //$nuevo_nombre_archivo  .= "." . $ext;
        $path = "carpeta_dosificaciones/" ;
		
		
		//$path = "/" . $tema_id . "/";

        if (!file_exists($path)) {
            mkdir($path);
           // echo "no existe!!!!";
        }
        $full_path = $path . $nuevo_nombre_archivo;
        // para ver si subio
        $tamaño = $_FILES['archivo']['size'];

        $archivo = (isset($_FILES['archivo'])) ? $_FILES['archivo'] : null;

        move_uploaded_file($_FILES['archivo']['tmp_name'], $full_path);


        $evento_data = model('evento')->get_by('id', $evento_id);

        

        model('evento')->update($evento_id,['dosificacion' => $full_path]);
        

       
        redirect(base_url()."evento/evento/" . $evento_id);


                

        




        



    }

}