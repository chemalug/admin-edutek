<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curso extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->name = 'curso';
        if(!isset($this->session->userdata["identity"])){
            redirect('auth/login');
        }
        $this->data['user'] = model('user')->get($this->session->userdata["identity"]);

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }

    }
    public function index() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
            $this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
            redirect('/');
        }
    }

    public function agregar() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
            $this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
            redirect('/');
        }
        view('administrador/'.$this->name.'/add', $this->data);
    }

    public function listar() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
            $this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
            redirect('/');
        }
        if($this->ion_auth->get_users_groups()->row()->id  == 5) {
            $this->data['list'] = model('curso')->get_all();
        } else {
            $this->data['list'] = model('curso')->get_many_by('user_id', $this->data['user']->id);
        }
        /*if (!$this->ion_auth-)
        $this->data['list'] = model('curso')->get_many_by('user_id', $this->data['user']->id);*/
        view('administrador/'.$this->name.'/show', $this->data);
    }




    public function addaction() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
            $this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
            redirect('/');
        }
       $logocurso = "";
        //ubicamos la imagen del curso
        $archivo = $_FILES['archivo']['name']; //captura el nombre del archivo
        $nombre  = $this->input->post('nombre') ;
        $nuevo_nombre_archivo = $nombre . "_" . "logo";
        $partir = explode(".", $archivo);
        $ext = $partir[count($partir) - 1];
        $nuevo_nombre_archivo  .= "." . $ext;
        $path = "logos_cursos/";
        $full_path = $path . $nuevo_nombre_archivo;
        $archivo = (isset($_FILES['archivo'])) ? $_FILES['archivo'] : null;

        move_uploaded_file($_FILES['archivo']['tmp_name'], $full_path);


        $datos = array(
            'nombre'        => $this->input->post('nombre') ,
            'descripcion'  => $this->input->post('descripcion') ,
            'id_categoria' => $this->input->post('categoria_id') ,
            //'logo' => $this->input->post('logo') ,
            'objetivos' => $this->input->post('objetivos') ,
            'duracion' => $this->input->post('duracion') ,
            'requisitos' => $this->input->post('requisitos') ,
            'dirigido' => $this->input->post('dirigido_a') ,
            'logo'=> $full_path ,
            'codigo_plan_formacion' => $this->input->post('codigo_plan') ,
            'user_id'=> $this->data['user']->id,
        );
        $dato = model('curso')->insert($datos);
        
        if ($dato != 0) {

            $evento = array(
                'no_evento'     => trim($this->input->post('nombre')) .'_preview',
                'fecha_inicio'  => '2019-01-01',
                'fecha_final'   => '2030-12-31',
                'instructor_id' => 16,
                'estado'        => 0,
                'fecha_alargue' => '2030-12-31',
                'no_horas'      => 40,
                'porcentaje'    => 0,
                'curso_id'      => $dato,
            );
            $resp = model('evento')->insert($evento);
            model('eventousuario')->insert([
                'user_id'   => 55,
                'evento_id' => $resp,
                'progreso'  => 0
            ]);

            $this->session->set_flashdata('message', '¡Dato agregado correctamente!');
            $this->data['list'] = model('curso')->get_all();
            redirect($this->name.'/listar');
        } else {
            $this->session->set_flashdata('message', '¡Ocurrió un problema en la inserción!');
            view('administrador/'.$this->name.'/add', $this->data);
        }

    }
    public function editaction() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
            $this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
            redirect('/');
        }
       $logocurso = "";
        //ubicamos la imagen del curso
        $archivo = $_FILES['archivo']['name']; //captura el nombre del archivo
        $nombre  = $this->input->post('nombre') ;
        $nuevo_nombre_archivo = $nombre . "_" . "logo";
        $partir = explode(".", $archivo);
        $ext = $partir[count($partir) - 1];
        $nuevo_nombre_archivo  .= "." . $ext;
        $path = "logos_cursos/";
        $full_path = $path . $nuevo_nombre_archivo;
        $archivo = (isset($_FILES['archivo'])) ? $_FILES['archivo'] : null;
        $full_path = str_replace(' ','', $full_path);

        move_uploaded_file($_FILES['archivo']['tmp_name'], $full_path);
        if ($archivo['size'] != 0) {
            $datos = array(
                'nombre'        => $this->input->post('nombre'),
                'descripcion'  => $this->input->post('descripcion'),
                'id_categoria' => $this->input->post('categoria_id'),
                //'logo' => $this->input->post('logo') ,
                'objetivos' => $this->input->post('objetivos'),
                'duracion' => $this->input->post('duracion'),
                'requisitos' => $this->input->post('requisitos'),
                'dirigido' => $this->input->post('dirigido_a'),
                'logo' => $full_path,
                'codigo_plan_formacion' => $this->input->post('codigo_plan'),
                'user_id' => $this->data['user']->id
            );
            
        } else {
            $datos = array(
                'nombre'        => $this->input->post('nombre'),
                'descripcion'  => $this->input->post('descripcion'),
                'id_categoria' => $this->input->post('categoria_id'),
                //'logo' => $this->input->post('logo') ,
                'objetivos' => $this->input->post('objetivos'),
                'duracion' => $this->input->post('duracion'),
                'requisitos' => $this->input->post('requisitos'),
                'dirigido' => $this->input->post('dirigido_a'),
            //    'logo' => $full_path,
                'codigo_plan_formacion' => $this->input->post('codigo_plan'),
                'user_id' => $this->data['user']->id
            );
        }
      
       $dato = model('curso')->update($this->input->post('id'),$datos);
        if ($dato != 0) {
            $this->session->set_flashdata('message', '¡Registros editados correctamente!');
            $this->data['list'] = model('curso')->get_all();
            redirect($this->name.'/listar');
        } else {
            $this->session->set_flashdata('message', '¡Ocurrió un problema en la inserción!');
            view('administrador/'.$this->name.'/edit', $this->data);
        }

    }
    public function evento($id) {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }



        $this->data['bandera'] = 2;
        $this->data['eventos'] = model('eventousuario')->get_many_by('user_id',$this->data['user']->id);

        $curso_id = model('evento')->get_by('no_evento',$id)->curso_id;
        $user = model('user')->get($this->session->userdata["identity"]);
        $this->data['user'] = $user;
        $user_id = $this->data['user_id'] = $this->data['user']->id;
        $this->data['evento_no'] = $id;


        //Creacion de nuestras variables de sesion "Globales"   id_usuario, id_evento, evento_no, id_curso, eventousuarios_id
        $this->session->set_userdata('evento_no',$id);
        $this->session->set_userdata('curso_id',$curso_id);
        $this->session->set_userdata('usuario_id',$user_id);

        $this->session->set_userdata('curso_nombre',model('curso')->get_by('id',$curso_id)->nombre);
        //calcular el evento_id en base al evento_no
        $result = $this->db->query("SELECT * FROM eventos WHERE no_evento = '$id';");
        $fila = $result->row();
        $evento_id = $fila->id;
        $this->session->set_userdata('evento_id',$evento_id);
        //ahora calcular el eventousuario_id
        $result = $this->db->query("SELECT * FROM eventousuarios WHERE user_id = $user_id and evento_id = $evento_id;");
        $fila = $result->row();
        $eventousuarios_id = $fila->id;
        
        $this->session->set_userdata('eventousuarios_id',$eventousuarios_id);
        $this->data['contenidos'] =  model('leccion')->order_by('orden','asc')->get_many_by('curso_id',$curso_id);;
        view('dashboard_e', $this->data);
    }


    
    public function preview_evento($id)
    {
            
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
            $this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
            redirect('/');
        }



        $this->data['bandera'] = 2;
        $this->data['eventos'] = model('eventousuario')->get_many_by('user_id', $this->data['user']->id);

        $curso_id = model('evento')->get_by('id', $id)->curso_id;
        //$user = 
        $this->data['user'] = model('user')->get($this->session->userdata["identity"]);
        $user_id = $this->data['user_id'] = $this->data['user']->id;
        $this->data['evento_no'] = model('evento')->get_by('id', $id)->no_evento;


        //Creacion de nuestras variables de sesion "Globales"   id_usuario, id_evento, evento_no, id_curso, eventousuarios_id
        $this->session->set_userdata('evento_no', $id);
        $this->session->set_userdata('curso_id', $curso_id);
        $this->session->set_userdata('usuario_id', $user_id);
        //calcular el evento_id en base al evento_no
       

        //$this->session->set_userdata('evento_id', $id);
        //ahora calcular el eventousuario_id
        $data = array(
            'user_id' => 55, 'evento_id' => $id
        );
        $this->session->set_userdata('eventousuarios_id', model('eventousuario')->get_by($data) ->id);



        $this->data['contenidos'] =  model('leccion')->order_by('orden', 'asc')->get_many_by('curso_id', $curso_id);;
       view('dashboard_e', $this->data);
    }

    public function editar($id) {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
            $this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
            redirect('/');
        }
        $this->data['datos'] = model('curso')->get_by('id',$id);
        
        view('administrador/' . $this->name . '/edit', $this->data);
    }
    public function visualizar($id) {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } elseif (!$this->ion_auth->is_admin() && $this->ion_auth->get_users_groups()->row()->id  != 5) {
            $this->session->set_flashdata('message', '¡Debes ser un administrador para ver esta página!');
            redirect('/');
        }
        $this->data['datos'] = model('curso')->get_by('id', $id);
        view('administrador/' . $this->name . '/dis', $this->data);
    }

    public function leccion($id){
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }

        $user           = model('user')->get($this->session->userdata["identity"]);
        $leccion        = model('leccion')->get_by('id',$id);
      // $evento_id = model('evento')->get_by('no_evento',$id)->curso_id;
        $user_id = $this->data['user']->id;

        $this->data['user'] = $user;
        $this->data['user_id'] = $user_id;



        /* $leccion        = model('leccion')->get_by('id',$id);
        $eventousuario  = model('eventousuario')->get_many_by('user_id',$user->id);
        $inscrito = 0;
        foreach ($eventousuario as $value) {
            //print_r($value);
            $evento = model('evento')->get_by('id',$value->evento_id);
            //print_r($evento);
            if ($evento->curso_id == $leccion->curso_id) {
                echo 'Esta en el curso';
            }

        } */

        $this->data['bandera']      = 2;
        $this->data['temas']        = model('tema')->order_by('orden','asc')->get_many_by('leccion_id',$id);

        $this->data['contenidos']   =  model('leccion')->order_by('orden','asc')->get_many_by('curso_id',$leccion->curso_id);
        //echo '<br>';
       // print_r($this->data['temas']);
       //print_r( $this->session->userdata('evento_no'));
        view('listado',$this->data);
    }


    public function cambiarimagen($id_curso){
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $this->data['curso_id']=$id_curso;
        view('blades/curso/cambiar_logo', $this->data);
    }

    public function subir_logo(){
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $curso_id =  $this->input->post('curso_id');
        $sql = "SELECT * FROM cursos WHERE id = $curso_id";
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            $fila = $result->row();
            $nombre_archivo = $fila->nombre;

        }



        $archivo = $_FILES['archivo']['name']; //captura el nombre del archivo

        $partir = explode(".", $archivo);
        $ext = $partir[count($partir) - 1];
        $path = "logos_cursos/";
        $nuevo_nombre_archivo = $nombre_archivo;
        $nuevo_nombre_archivo  .= "." . $ext;

        $full_path = $path .  $nuevo_nombre_archivo;
        $archivo = (isset($_FILES['archivo'])) ? $_FILES['archivo'] : null;

        move_uploaded_file($_FILES['archivo']['tmp_name'], $full_path);

        $archivo_en_bd = $path .  $nuevo_nombre_archivo;

        $sql = "UPDATE cursos SET logo = '$archivo_en_bd' WHERE id = $curso_id;";
        $this->db->query($sql);
        $baseurl = base_url() . 'leccion/construir/' . $curso_id;
        echo "<script type='text/javascript'> window.location='$baseurl'; </script>";







    }





 }
