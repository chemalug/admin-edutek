<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensaje extends CI_Controller {
    public function __construct() { 
        parent::__construct();
        $this->name = 'curso';
        $this->data['user'] = model('user')->get($this->session->userdata["identity"]);
        
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } 
        
    }
    public function index() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }
    public function enviar() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $instructor_id  = model('evento')->get_by('id', $this->session->userdata('evento_id'))->instructor_id;
        //$tema_id         = $this->input->post('tema_id');
        $asunto         = $this->input->post('asunto');
        $mensaje        = $this->input->post('mensaje');
        if (!$asunto) {
            echo -2;
            return;
        }
        if (!$mensaje) {
            echo -1;
            return;
        }
        $data = array(
            'asunto'            => $asunto,
            'mensaje'           => $mensaje,
            'estado'            => 1,
            'user_id'           => $this->session->userdata('user_id'),
            'instructor_id'     => $instructor_id,
            'evento_id'         => $this->session->userdata('evento_id'),
            'eventousuario_id'  => $this->session->userdata('eventousuarios_id'),
        );
        $conversacion_id = model('conversacion')->insert($data);
       $datos = array(
            'mensaje'           => $mensaje,
            'visto'             => 0,
            'conversacion_id'   => $conversacion_id,
            'destino'           => 'I',
        );
        $respuesta = model('imensaje')->insert($datos);
        echo $respuesta;
        //redirect('tema/ver/'.$tema_id);
    }
    public function ver($id) {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $conversacion = model('conversacion')->get_by(['eventousuario_id' => $id]);
        //print_r($this->session->userdata());
        $this->data['eventos']              = model('evento')->get_many_by('instructor_id', $this->session->userdata('instructor_id'));
        //$this->data['existe_participantes'] = model('eventousuario')->count_by('evento_id', $conversacion->evento_id);
        $this->data['participantes'] = model('eventousuario')->get_many_by('evento_id', $this->session->userdata('evento_id'));
        //$this->data['eventousuario']        = model('eventousuario')->get_many_by('evento_id', $conversacion->evento_id);
        $this->data['evento_id'] = $this->session->userdata('evento_id');
        $this->data['bandera'] = 2;
        $this->data['conversacion'] = '0';
        $this->data['asunto'] = $conversacion;
        if ($conversacion) {
            $this->data['conversacion'] = $conversacion->id;
            $this->data['mensajes'] = model('imensaje')->order_by('fecha', 'asc')->get_many_by('conversacion_id', $conversacion->id);
            if ($this->ion_auth->get_users_groups()->row()->id == 2) {
                $this->data['conversaciones'] = model('conversacion')->order_by('fecha', 'desc')->get_many_by('instructor_id', $conversacion->instructor_id);
            } elseif ($this->ion_auth->get_users_groups()->row()->id == 3) {
                $this->data['conversaciones'] = model('conversacion')->order_by('fecha', 'desc')->get_many_by('user_id', $conversacion->user_id);
            }
            foreach (model('imensaje')->get_many_by(['conversacion_id' => $id, 'visto' => 0 ]) as $value) {
                if ($this->ion_auth->get_users_groups()->row()->id == 2 && $value->destino == 'I') {
                    
                    model('imensaje')->update($value->id, ['visto' => 1]);
                } elseif ($this->ion_auth->get_users_groups()->row()->id == 3 && $value->destino == 'E') {
                    model('imensaje')->update($value->id, ['visto' => 1]);
                    
                }
            }
        } else {
            $data = array(
                'asunto'            => '',
                'mensaje'           => '',
                'estado'            => 0,
                'user_id'           => model('eventousuario')->get_by('id',$id)->user_id,
                'instructor_id'     => $this->session->userdata('instructor_id'),
                'evento_id'         => $this->session->userdata('evento_id'),
                'eventousuario_id'  => $id,
            );
            $resultado = model('conversacion')->insert($data);
            $this->data['conversacion'] = $resultado;
        }
        
        if ($this->ion_auth->get_users_groups()->row()->id == 2) {
            model('conversacion')->update($this->data['conversacion'],['estado'=>1]);
            view('mensaje',$this->data);
        } elseif ($this->ion_auth->get_users_groups()->row()->id == 3) {
            $this->data['bandera'] = 1;
            $this->data['eventos'] = model('eventousuario')->get_many_by('user_id', $this->data['user']->id);
            view('mensaje_e', $this->data);
        }

    }
    public function mensajenuevo(){
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $destino = '';
        if ($this->ion_auth->get_users_groups()->row()->id == 2) { 
            $destino = 'E';
        } elseif ($this->ion_auth->get_users_groups()->row()->id == 3) {
            $destino = 'I';
        }

        $datos = array(
            'mensaje'           => $this->input->post('mensaje'),
            'visto'             => 0,
            'conversacion_id'   => $this->input->post('conversacion'),
            'destino'           => $destino,
        );
        $respuesta = model('imensaje')->insert($datos);
        model('conversacion')->update($this->input->post('conversacion'),['fecha'=> date('Y-m-d H:i:s'),'estado'=>0]);
        echo $respuesta;
    }
    public function modificar(){
        $mensaje = $this->input->post('mensaje');
        $id = $this->input->post('id');
        //print_r($this->input->post());
        $mensaje_ant = model('imensaje')->get_by('id',$id);
        model('imensaje')->update($id,['mensaje'=>$mensaje,'visto'=>0]);
        model('conversacion')->update($mensaje_ant->conversacion_id,['estado'=>0]);
        model('log_imensaje')->insert($mensaje_ant);
        echo 1;

    }
    public function myfunction ($valor) {
        return $valor.'iouaysdf';
    }
    public function timeString($ptime) {
        $etime = time() - $ptime;
        if ($etime < 1) {
            return '0 seconds';
        }

        $a = array(
            365 * 24 * 60 * 60  =>  'año',
            30 * 24 * 60 * 60  =>  'mes',
            24 * 60 * 60  =>  'dia',
            60 * 60  =>  'hora',
            60  =>  'minuto',
            1  =>  'segundo'
        );
        $a_plural = array(
            'año'       => 'años',
            'mes'          => 'meses',
            'dia'        => 'dias',
            'hora'       => 'horas',
            'minuto'     => 'minutos',
            'segundo'     => 'segundos'
        );

        foreach ($a as $secs => $str) {
            $d = $etime / $secs;
            if ($d >= 1) {
                $r = round($d);
                return 'hace ' . $r . ' ' . ($r > 1 ? $a_plural[$str] : $str);
            }
        }
    }
    public function getall() {
        if ($this->ion_auth->get_users_groups()->row()->id == 2) {
           
            $instructor = model('instructor')->get_by('email_instructor', $this->ion_auth->user()->row()->email);
            $this->data['eventos'] = model('evento')->get_many_by('instructor_id', $instructor->id);
            $this->data['participantes'] = model('eventousuario')->get_many_by('evento_id', $this->session->userdata('evento_id'));
            $this->data['evento_id'] = $this->session->userdata('evento_id');
            $this->data['conversacion'] = $this->session->userdata('evento_id');
            //$this->data['conversaciones'] = model('conversacion')->order_by('fecha', 'desc')->get_many_by('instructor_id', $instructor->id);
            //print_r($this->session->userdata());
            view('mensaje', $this->data);
        } elseif ($this->ion_auth->get_users_groups()->row()->id == 3) {
            $this->data['bandera'] = 1;
            $this->data['eventos'] = model('eventousuario')->get_many_by('user_id', $this->data['user']->id);
            $this->data['conversaciones'] = model('conversacion')->order_by('fecha','desc')->get_many_by('user_id', $this->data['user']->id);

            view('mensaje_e', $this->data);
        }        
    }
    public function sendAll() {
        //print_r();
        $mensaje = $this->input->post('mensaje');
        $participantes = model('eventousuario')->get_many_by('evento_id',$this->session->userdata('evento_id'));
        foreach ($participantes as $value) {
            $existe = model('conversacion')->get_by('eventousuario_id',$value->id);
            $data = array(
                'asunto'            => '',
                'mensaje'           => '',
                'estado'            => 0,
                'user_id'           => $value->user_id,
                'instructor_id'     => $this->session->userdata('instructor_id'),
                'evento_id'         => $this->session->userdata('evento_id'),
                'eventousuario_id'  => $value->id,
            );
            if (!$existe) {
                $resultado = model('conversacion')->insert($data);
                $datos = array(
                    'mensaje'           => $mensaje,
                    'visto'             => 0,
                    'conversacion_id'   => $resultado,
                    'destino'           => 'E',
                );
                $respuesta = model('imensaje')->insert($datos);
            } else {
                $datos = array(
                    'mensaje'           => $mensaje,
                    'visto'             => 0,
                    'conversacion_id'   => $existe->id,
                    'destino'           => 'E',
                );
                $respuesta = model('imensaje')->insert($datos);
            }
        }
    }
}