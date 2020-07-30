<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Actividad extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!isset($this->session->userdata["identity"])) {
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
        $this->load->library('upload');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }

    public function index()
    { }


    public function mostrar_actividad($tema_id)
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        // $actividad_id = $this->input->post("actividad_id");
        // $usuario = $this->session->userdata["identity"];

        //$tema_id = 89;
        $usuario = ($this->session->userdata["identity"]);

        $this->data["tema_id"] = $tema_id;
        



        $registro = model('tema')->get_by('id', $tema_id);

        if (is_null($registro)) {
            
        } else {

            $this->data["usuario"]  = $usuario;
            $this->data["es_actividad"] = $registro->es_actividad;
            $this->data["actividad_titulo"] = $registro->titulo;
            $this->data["actividad_descripcion"] = $registro->descripcion;
            $this->data["actividad_archivo"]  = "../" . $registro->archivo;
            $this->data["actividad_punteo"]  = $registro->punteo;
            $this->data["es_actividad"]  = $registro->es_actividad;
        }

        //vamos a ver la cantidad de veces que se ha subido el archivo, solo permite 3
        $registro = $this->db->query("SELECT id,intentos FROM archivos_temas WHERE tema_id = $tema_id and usuario = '$usuario';");
        $a = $registro->result_array();
        $intentos = 0;

        if(count($a) > 0) {
            foreach ($registro->result() as $row) {
                $intentos =  $row->intentos;
            
            }
        }
        $tema     = model('tema')->get_by('id', $tema_id);
        $orden = $tema->orden;
        $leccion         = model('leccion')->get_by('id', $tema->leccion_id);
        $this->data['contenidos']     = model('leccion')->order_by('orden', 'asc')->get_many_by('curso_id', $leccion->curso_id);
        $this->data['bandera']         = 2;
        $this->data["intentos"]  = $intentos;
        
        view('alumno/upload', $this->data);
      

	}


    public function subir_archivo()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
	
         $usuario = $this->session->userdata["identity"];
         $tema_id = $this->input->post('tema_id');
         $tipo_actividad = $this->input->post('tipo_actividad');

        $now = new DateTime();
        $now->format('Y-m-d-H-i-s');    // MySQL datetime format
        $now->getTimestamp();




        $fecha_hora =  $now->format('Y-m-d-H-i-s');
        $archivo = $_FILES['archivo']['name']; //captura el nombre del archivo


        $now = new DateTime();
        $fecha = $now->format('d-m-Y-H-i-s');    // MySQL datetime format
        $fecha = strlen($fecha);

        $nuevo_nombre_archivo = $archivo . "--" . $usuario . "--id activ " . $tema_id;
        $partir = explode(".", $archivo);
        $ext = $partir[count($partir) - 1];
        $nuevo_nombre_archivo  .= "--" . $fecha_hora . "." . $ext;
        $path = "carpeta_archivos/" . $this->session->userdata('evento_no') . "/";
		
		
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

        //ahora actualizamos las tablas de log_generals y archivos_temas


        $fechaSQL = $now->format('Y-d-m');
        $hora = $now->format('H:i:s');
        // consultar la base de datos
        $es_actividad =  $this->input->post("es_actividad");



        $datos_log_general = array(
            "usuario" => $usuario, "tema_id" => $tema_id, "fecha" => $fechaSQL, "hora" => $hora,
            "tipo_actividad" => $es_actividad, "nombre_archivo" => $nuevo_nombre_archivo
        );


        model('log_general')->insert($datos_log_general);


        //debe verificar si el archivo ya existe, si ya existe incrementar el intento hasta 3 veces
        $registro = $this->db->query("SELECT id,intentos FROM archivos_temas WHERE tema_id = $tema_id and usuario = '$usuario';");
        $a = $registro->result_array();
        $intentos = 1;
 
        if (count($a) > 0) {
            foreach ($registro->result() as $row) {
                $intentos =  $row->intentos;
                $intentos++;
                $id =$row->id;
                $datos_update_datos_temas = array("usuario" => $usuario, "tema_id" => $tema_id, "archivo" => $full_path, "intentos" => $intentos, 
                "evento_no"=>$this->session->userdata('evento_no'), "eventousuario_id"=>$this->session->userdata('eventousuarios_id'));
                model('archivos_tema')->update($id,$datos_update_datos_temas);
                
                
            }
        } else {
            
                $intentos = 1;
                $datos_archivos_temas = array("usuario" => $usuario, "tema_id" => $tema_id, "archivo" => $full_path, "intentos" => $intentos, 
                "evento_no"=>$this->session->userdata('evento_no'), "eventousuario_id"=>$this->session->userdata('eventousuarios_id'));
                
                model('archivos_tema')->insert($datos_archivos_temas);   
                
             
        }
        $this->data['intentos']=$intentos;
        //this->db->query('SELECT from eventos where eventos.evento_no =');

        //aqui debo escribir visto en la actividad evento_alumno
        //necesito evento_usuario y tema_id
        $eventousuarios_id = $this->session->userdata('eventousuarios_id');

        //instrucciones SQL para ver si existe el registro, si existe lo actualiza y si no lo inserta.    
         $sqlnota1 = "SELECT * FROM notas WHERE eventousuario_id ='" . $eventousuarios_id . "' AND tema_id = '" . $tema_id ."'";
         $sqlnota2 = "UPDATE notas SET visto = 1 WHERE eventousuario_id ='" . $eventousuarios_id . "' AND tema_id = '" . $tema_id ."'";
         $sqlnota3 = "INSERT INTO notas(nota, eventousuario_id,tema_id, visto) VALUES(0,$eventousuarios_id,$tema_id,1)";

        $result1 = $this->db->query($sqlnota1);

        $cantidadfilas = $result1->num_rows();


        if($cantidadfilas == 0 ){
            $this->db->query($sqlnota3);

        }else{

            $this->db->query($sqlnota2);

        }
        
        $instructor = model('instructor')->get_by('id', model('evento')->get_by('id', $this->session->userdata('evento_id'))->instructor_id);
        
        $mensajearchivo = '';
        if($tamaño == 0){
            $mensajearchivo = 'El archivo no se cargó a la plataforma intenta de nuevo';
        }else{
            $mensajearchivo = 'El archivo se cargó a la plataforma correctamente';
            $asunto = 'Notificación de archivo enviado';
            $mensaje = 'Hola, este mensaje es solo para informar que tu archivo, correspondiente a la actividad: <strong>'. model('tema')->get_by('id', $tema_id)->titulo .'</strong> ha sido cargado a la plataforma correctamente';
            //echo $mensaje;
            $this->enviar_email($asunto, $usuario, $mensaje);
            $asunto = 'Entrega de tarea';
            $mensaje = 'Este mensaje es solo para informar que el participante <strong>'. model('user')->get_by('email',$usuario)->first_name . ' ' . model('user')->get_by('email', $usuario)->last_name . '</strong>, ha completado la actividad: <strong>' . model('tema')->get_by('id', $tema_id)->titulo . '</strong>, de manera que ya se puede ponderar esta actividad';
            //echo $mensaje;
            //$this->enviar_email($asunto, $usuario, $mensaje);
            $this->enviar_email($asunto, $instructor->email_instructor, $mensaje);
            
        }





        $this->session->set_flashdata('message', $mensajearchivo);
        redirect('curso/evento/' . $this->session->userdata('evento_no'));
  



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




