<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends CI_Controller {
	public function __construct() {
        parent::__construct();
		$this->name = 'tema';
		//$this->data['user'] = model('user')->get($this->session->userdata["identity"]);
	    if (!$this->ion_auth->logged_in()) {
	    	redirect('auth/login');
        }
	}
	

	public function index()	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
	
	}


	public function mostrar() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$identidad = $this->session->userdata["identity"];
		$this->data['user'] = model('user')->get($this->session->userdata['identity']);
		
		
		$sql = "SELECT * FROM users WHERE username ='$identidad';";
		$resultado = $this->db->query($sql);
		
		$datos = $resultado->row();
		$this->data['datos'] = $datos;

		view('blades/perfil/mostrar', $this->data);
	}

	
	public function modificar() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$identidad = $this->session->userdata["identity"];
		$this->data['user'] = model('user')->get($this->session->userdata['identity']);
		
		
		$sql = "SELECT * FROM users WHERE username ='$identidad';";
		$resultado = $this->db->query($sql);
		
		$datos = $resultado->row();
		$this->data['datos'] = $datos;

		view('blades/perfil/modificar', $this->data);
	}


	   public function subir_foto_perfil(){
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}

		 $telefono = $this->input->post("telefono");
		 $usuario = $this->session->userdata["identity"];
         $tema_id = $this->input->post('tema_id');
         $tipo_actividad = $this->input->post('tipo_actividad');

        $now = new DateTime();
        $now->format('Y-m-d-H-i-s');    // MySQL datetime format
        $now->getTimestamp();

		$fecha_hora =  $now->format('Y-m-d-H-i-s');
		$tamaño = $_FILES['archivo']['size'];
		$archivo = $_FILES['archivo']['name']; //captura el nombre del archivo


        $now = new DateTime();
        $fecha = $now->format('d-m-Y-H-i-s');    // MySQL datetime format
        $fecha = strlen($fecha);

        $nuevo_nombre_archivo = $usuario;
        $partir = explode(".", $archivo);
        $ext = $partir[count($partir) - 1];
        $nuevo_nombre_archivo  .= "." . $ext;
        $path = "profiles_images/";
		
		
		//$path = "/" . $tema_id . "/";

        if (!file_exists($path)) {
            mkdir($path);
           // echo "no existe!!!!";
        }
        $full_path = $path . $nuevo_nombre_archivo;
        $archivo = (isset($_FILES['archivo'])) ? $_FILES['archivo'] : null;
        move_uploaded_file($_FILES['archivo']['tmp_name'], $full_path);

        //ahora actualizamos las tablas de log_generals y archivos_temas


        $fechaSQL = $now->format('Y-d-m');
        $hora = $now->format('H:i:s');
        // consultar la base de datos
        $es_actividad =  $this->input->post("es_actividad");



        $datos_log_general = array(
            "usuario" => $usuario,  "fecha" => $fechaSQL, "hora" => $hora,
             "nombre_archivo" => $nuevo_nombre_archivo . " - Cambio foto perfil -"
        );

		model('log_general')->insert($datos_log_general);

		if($tamaño == 0){
			$SQL2 = "UPDATE users SET telefono='$telefono' where username = '$usuario'";
			$this->db->query($SQL2);	


		}else{


		$SQL2 = "UPDATE users SET profile_image = '$full_path', telefono='$telefono' where username = '$usuario'";
		$this->db->query($SQL2);
		}

        //debe verificar si el archivo ya existe, si ya existe incrementar el intento hasta 3 veces
        
 
        
        
		// Cambiar para que redireccione al perfil mostrar
       // redirect('/mostrar');
	
		echo "<script type='text/javascript'>window.location='/perfil/mostrar'</script>;";
        
    }
	
	
}