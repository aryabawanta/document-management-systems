<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Site extends WEB_Controller {
		protected $ispublic = true;
		
        /**
		 * Halaman login user
		 */
        public function index() {
        	$this->load->model('User_model');
			
			// jika sudah login lempar ke post
			if(SessionManagerWeb::isAuthenticated()) {
				// SessionManagerWeb::setFlashMsg(false,'Anda sudah login');
				redirect($this->getCTL('document'));
			}
			// lakukan validasi form
            $this->form_validation->set_rules('username','Username','required');
			$this->form_validation->set_rules('password','Password','required');
			
			if ($this->form_validation->run() === true) {
				$username = $this->input->post('username');
				$arr = explode(" ",$username);
				$username = implode(" ",$arr);
				list($ok,$msg,$user) = AuthManagerWeb::login($username,$this->input->post('password'));
				if($ok){
					$this->load->model("User_model");
					$user['photo'] = $this->User_model->getPhoto($user['id'], $user['photo']);
					setcookie('username',$user['username'],time() + 2592000,'/'); // 30 hari
					SessionManagerWeb::setUser($user);
					$this->setSessionVariables();
					redirect($this->getCTL('document'));
				}else{
					SessionManagerWeb::setUserName($this->input->post('username', true));
					SessionManagerWeb::setFlashMsg(false,$msg);
					redirect($this->ctl);
				}
			}else {
				$errstr = validation_errors();
				if(!empty($errstr)) {
					SessionManagerWeb::setUserName($this->input->post('username', true));
					SessionManagerWeb::setFlashMsg(false,array("error"));
					redirect($this->ctl);
				}
			}
			// $this->load->view(static::VIEW_PATH.$this->view,$this->data);
			header('Location: '.$this->config->item('app_url'));
        }
    }