<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Upload extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->library('upload');
        }

        
        public function do_upload()
        {
                if (!$this->ion_auth->logged_in()) {
                        redirect('auth/login');
                }
            $config['upload_path']   = './uploads/'; 
            $config['allowed_types'] = 'xls|xlsx'; 
            $config['max_size']      = 1024; 
            $config['max_width']     = 4000; 
            $config['max_height']    = 2000; 
            $this->upload->initialize($config);
                
                if ( ! $this->upload->do_upload('excelFile'))
                {
                        $error = array('error' => $this->upload->display_errors());

                        print_r($error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());

                        $this->load->view('upload_success', $data);
                }
        }
}