<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
     public function __construct() { 
        parent::__construct();
        $this->name = 'user';
        $this->data['user'] = model('user')->get($this->session->userdata["identity"]);
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $this->items = array(
            'email'        =>  'trim|required',
            'nombre'       =>  'trim|required',//|required
            'apellido'     =>  'trim|required',
            'password'     =>  'trim|required',
            'role'         =>  'trim|required',
        );
        $this->roles = array(
            '1'     => '1,2,3,4,5,6',
            '2'     => '2,3,4,5,6',
            '3'     => '4,5,6',
            '4'     => '5,6',
            '5'     => '6',
            '6'     => '6',
        );
        $this->rol = array(
            'root'  => '1',
            'admin' => '2',
            'super' => '3',
            'ases'  => '4',
            'inst'  => '5',
            'part'  => '6',
        );
    }
    public function index($id) {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
         }
         $this->data['list'] = model('user')->get_all();
         $this->data['error'] = ""; 
         //$this->data['action'] = site_url('Upload/do_upload');
         view($this->name.'/index', $this->data) ;
    }
    public function view ($id){
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        
        $permisos = $this->roles[$this->ion_auth->get_users_groups()->row()->id];
        if (strpos($permisos,$this->rol[$id])!== false) {
            $this->data['list'] = $this->ion_auth->users( $this->rol[$id] )->result();
        } else {
            view('/errors/html/error_403',$this->data);
            return;
        }
        $this->data['bandera'] = 0; 
        //$this->data['action'] = site_url('Upload/do_upload');
        view($this->name.'/index', $this->data);
    }
    public function create() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $this->data['action'] = site_url($this->name.'/create_action');;
        $this->data['permisos'] = $this->roles[$this->ion_auth->get_users_groups()->row()->id];
        $this->data['groups'] = $this->ion_auth->groups()->result();
        view($this->name.'/create', $this->data);
    }
    public function create_action() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $this->_rules();
         if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', 'Hacen falta algunos datos');
            redirect(site_url($this->name).'/create/');
        } else {
            foreach ($this->items as $key => $value) {
                if ($key != 'id') {
                    $data[$key] = $this->input->post($key,TRUE);
                }
            }
            $user_exist = model('user')->get_by('email',$data['email']);
            if ($user_exist == null) {
                $user_id = $this->ion_auth->register($data['email'], $data['password'], $data['email'], array( 'first_name' => $data['nombre'], 'last_name' => $data['apellido'],'active' => '0', 'carnet' => '00' ), array($data['role']) );
                $this->data['bandera'] = 1; 
                $this->data['list'] = $this->ion_auth->users( $data['role'] )->result();
                view($this->name.'/index', $this->data);
            } else {
                $this->session->set_flashdata('message', 'El email ingresado ya está registrado en el sistema');
                redirect(site_url($this->name).'/create/');

            }
            
        }
    }
    public function change_password() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $this->items = array(
            'old_password'          =>  'trim|required',
            'new_password'          =>  'trim|required',//|required
            'new_password_confirm'  =>  'trim|required',
        );
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', 'Hacen falta algunos datos');
            redirect(site_url($this->name).'/change_password');
        } else {
            foreach ($this->items as $key => $value) {
                if ($key != 'id') {
                    $data[$key] = $this->input->post($key,TRUE);
                }
            }
            $data['user_id'] = $this->data['user']->id;
            $identity = $this->session->userdata('identity');
            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            if (strlen($data['new_password']) <= 7) {
                $this->data['message'] = 'El mínimo de caracteres debe ser 8';
                $this->_render_page('auth/change_password', $this->data);
                return;
            }
            if ($data['new_password'] != $data['new_password_confirm']) {
                $this->data['message'] = 'El nuevo password no coincide con la comfirmación';
                $this->_render_page('auth/change_password', $this->data);
            } else {
                $change = $this->ion_auth->change_password($identity, $data['old_password'], $data['new_password']);
                if ($change) {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    $this->data['title'] = "Logout";
                    $update = array(
                        'carnet' => '0',
                    );
                    $this->ion_auth->update($data['user_id'], $update);
		            $logout = $this->ion_auth->logout();
		            $this->session->set_flashdata('message', $this->ion_auth->messages());
		            redirect('auth/login', 'refresh');
                } else {
                    $this->data['message'] = 'El antiguo password no es el correcto';
                    $this->_render_page('auth/change_password', $this->data);
                }
            }
        }
    }
    public function editar($id) {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $user_groups = $this->ion_auth->get_users_groups($id)->row();
        $user = $this->ion_auth->users(1)->row();
        print_r($user_groups);
        echo '<br>';
        print_r($user);
        view($this->name.'/editar',$this->data);
        
    }
    public function eliminar($id) {

    }
    private function _rules() {
        foreach ($this->items as $key => $value) {
            if ($value != null) {
                $this->form_validation->set_rules($key , ' ', $value);
            }
        }
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    private function _render_page($view, $data = NULL, $returnhtml = FALSE)//I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data : $data;

		$view_html = view($view, $this->viewdata);

		// This will return html on 3rd argument being true
		if ($returnhtml)
		{
			return $view_html;
		}
	}
}