<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends SL_Controller {
	public function index()
	{
		// $this->load->view('welcome_message');
		// $this->session->set_userdata("test", ['1'=>'gggg', '2'=>'12121212']);
		// $this->session->set_userdata("test[2]", "11111");
		// var_dump($this->session->userdata);
		$this->main();
	}

	public function main(){
		$option = array(
			"list" => ['1111','2222'],
			"title" => "Welcome"
		);
		$this->_view("/welcome_v", $option);
	}
	public function exe(){
		exec("C:\\cclib-allimi\\cclib-allimi.exe");
	}

}
