<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploader extends SL_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

	}

	public function do_upload()
	{

	}

	public function tester(){
		$data = array(
			"title" => "업로드"
		);
		$this->_modal_view('uploader/tester_v', $data);
	}

}
