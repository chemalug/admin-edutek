<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Actividad extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->data['user'] = model('user')->get($this->session->userdata["identity"]);
        $this->load->library('upload');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }

    public function index()
    { }


    public function mostrar_actividad($tema_id)
    {

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
            $this->data["actividad_archivo"]  = "../uploads/" . $registro->archivo;
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
    {  //echo "<script type='text/javascript'>alert(".getcwd() .");</script>";
	
	
         $usuario = $this->session->userdata["identity"];
         $tema_id = $this->input->post('tema_id');
         $tipo_actividad = $this->input->post('tipo_actividad');

        //temporalmente quemamos los datos que deberian venir en data
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
        $path = "carpeta_archivos/" . $tema_id . "/";
		
		
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
                $datos_update_datos_temas = array('intentos'=>$intentos);
                model('archivos_tema')->update($id,$datos_update_datos_temas);
                
            }
        } else {
            
                $intentos = 1;
                $datos_archivos_temas = array("usuario" => $usuario, "tema_id" => $tema_id, "archivo" => $full_path, "intentos" => $intentos);
                model('archivos_tema')->insert($datos_archivos_temas);   
                
             
        }
        $this->data['intentos']=$intentos;
        echo '<script type="text/javascript">
        window.location="https://e-learning.intecap.tech/curso/evento/30-26";
        </script>';
    }
}




