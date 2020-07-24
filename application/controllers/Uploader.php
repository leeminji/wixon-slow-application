<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploader extends SL_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('upload');	
	}

	public function index()
	{

	}

	public function do_upload(){
		
		$json_data = null;
		$config = array(
			'upload_path' => './uploads/',
			'allowed_types' => 'pdf|jpg|gif|png|jpeg|txt|exe|zip',
			'max_size' => 1024*10, //1MB 1024
		);

		$files = $_FILES;
		$file_count = count($_FILES['userfile']['name']);

		for($i=0;$i<$file_count;$i++){
			$_FILES['userfile'] = array(
				'name'=>$files['userfile']['name'][$i],
				'type'=>$files['userfile']['type'][$i],
				'tmp_name'=>$files['userfile']['tmp_name'][$i],
				'error'=>$files['userfile']['error'][$i],
				'size'=>$files['userfile']['size'][$i],
			);

			$this->upload->initialize($config);

			if ( !$this->upload->do_upload() ){
				$error = array('error' => $this->upload->display_errors());
				var_dump($error);
			} else {
				$data = array('upload_data' => $this->upload->data());
				var_dump($data);
			}
		}
		alert_close("업로드하였습니다.");
	}

	public function ajax_upload()
	{
	
		$json_data = null;
		$config = array(
			'upload_path' => './uploads/',
			'allowed_types' => 'pdf|jpg|gif|png|jpeg|txt|exe|zip|pptx|csv|xlsx',
			'max_size' => 1024*10,
		);

		$files = $_FILES;
	
		$_FILES['userfile'] = array(
			'name'=>$files['userfile']['name'],
			'type'=>$files['userfile']['type'],
			'tmp_name'=>$files['userfile']['tmp_name'],
			'error'=>$files['userfile']['error'],
			'size'=>$files['userfile']['size'],
		);

		$this->upload->initialize($config);

		if ( !$this->upload->do_upload() ){
			$error = array('error' => $this->upload->display_errors());
			$json_data = array(
				"error" => $error,
				"msg"=>'fail',
				"files"=>$files
			);
		} else {
			$data = array('upload_data' => $this->upload->data());
			$json_data = array(
				"data" => $data,
				"msg"=>'success',
			);
		}


		$this->_json_view($json_data);
		
	}	
}
