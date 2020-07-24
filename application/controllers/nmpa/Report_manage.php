<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_manage extends SL_Controller{

	function __construct(){
		parent::__construct();
		
		$this->main();
	}

	function main(){
		$data = array();
		$this->_view("nmpa/report_manage_v", $data);
	}

}
?>