<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends SL_Controller {
	public function index()
	{
		$this->main();
	}

	public function main(){
		$option = array(
			"list" => ['1111','2222'],
			"title" => "대시보드"
		);
		$this->_view("/dashboard_v", $option);
	}
}
