<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
        parent::__construct();
		//$this->data['menu'] = 'dashboard';
		$this->load->model('user_model', 'user');
		
		$this->data['user'] = (isset($this->session->userdata["identity"])) ? $this->user->get($this->session->userdata["identity"]) : $this->ion_auth->user()->row() ;
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
		} elseif ($this->ion_auth->get_users_groups()->row()->id == 5) { // compara el rol del usuario, 2 = instructor
			view('dashboard', $this->data);
		} elseif ($this->ion_auth->get_users_groups()->row()->id == 2) { // compara el rol del usuario, 2 = instructor
			$instructor = model('instructor')->get_by('email_instructor',$this->ion_auth->user()->row()->email);
			$this->data['eventos'] = model('evento')->order_by('fecha_inicio','desc')->get_many_by('instructor_id',$instructor->id);
			$this->data['user'] = $this->ion_auth->user()->row();
			
			view('dashboard_i', $this->data);
		} elseif ($this->ion_auth->get_users_groups()->row()->id == 3) { // compara el rol del usuario, 3 = estudiantes

			$this->data['bandera'] = 1;
			$this->data['eventos'] = model('eventousuario')->order_by('evento_id','desc')->get_many_by('user_id',$this->data['user']->id);
			//$this->data['contenidos'] =  model('tema')->order_by('orden','asc')->get_all();
			view('dashboard_e', $this->data);
		}
		
	}
}
