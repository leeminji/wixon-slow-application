<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Elfinder_mod extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('common_function');
	}

	/**
	 * 주소에서 메소드가 생략되었을 때 실행되는 기본 메소드
	 */
	public function index()
	{
		$this->main();
	}


	/*	문서관리 시작 메소드 */
	public function main()
	{
		switch ($this->input->get("mode"))
		{
			case 48 : $division = "pub";
						break;
			case 49 : $division = "org";
						break;
			case 83 : $division = "design";
						break;
		}

		$data['mid'] = $division;
		$this->load->view('modules/elfinder_main_v', $data);
	}

	/*	공통자료실 Elfinder */
	public function elfinder_pub(){

		$this->load->helper('path');

		// $org_code = $this->session->userdata('org_code');
		// $org_name = $this->orgname_array[$org_code];

		// $upload_path = "/menu48";
		// $upload_save_path = "files/menu48/".$org_name."(".$org_code.")";

		$org_code = "C01";
		$org_name = "무역부";
		
		$upload_path = "/menu48";
		$upload_save_path = "files/menu48/".$org_name."(".$org_code.")";

		if( $this->common_function->bt_mkdir($upload_save_path) < 0 ) exit;

		$alias_name = "Public";

		$opts = array(
			'debug' => true,
			'roots' => array(
			  array(
				'driver' => 'LocalFileSystem',
				'path'   => set_realpath(realpath(APPPATH.'../files')).$upload_path,
				'URL'    => set_realpath(realpath(APPPATH.'libraries/')).'elfinder'.DIRECTORY_SEPARATOR.'connector.minimal.php?cmd=file&target=HASH_TO_FILE_PATH',
				'alias'  => $alias_name,
				'rememberLastDir' => false,
				// more elFinder options here
				'uploadMaxSize' => '200M',
				'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
				'uploadAllow'   => array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png',  'image/x-png', 'image/tiff', 'video/mpeg', 'application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 'application/xls', 'application/x-xls', 'application/excel', 'application/download', 'application/vnd.ms-office', 'application/msword', 'application/powerpoint', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/x-zip', 'application/zip', 'application/pdf', 'application/force-download', 'application/x-download', 'binary/octet-stream', 'application/s-compressed', 'audio/mpeg', 'audio/mpg', 'audio/mpeg3', 'audio/mp3', 'video/mp4', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/x-compressed', 'application/x-zip-compressed', 'multipart/x-zip', 'application/haansofthwp', 'application/x-hwp', 'application/unknown', 'application/octet-stream', 'text/plain', 'text/xml', 'application/cdfv2-corrupt', 'application/acad', 'image/vnd.dwg', 'image/x-dwg','application/csv'),// Mimetype `image` and `office program` and 'hwp' and 'zip' allowed to upload
				'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only  'application/pdf', 'application/force-download', 'application/x-download', 'binary/octet-stream'
				'accessControl' => 'access',
				'acceptedName' => 'validName',
				'defaults'   => array('read' => true, 'write' => false),
				'attributes' => array(
					array( // hide readmes
						'pattern' => '/'.$org_code.'/',
						'read' => true,
						'write' => true,
						'hidden' => false,
						'locked' => false
					),
					array(
						'pattern' => '/(\.tmb|\.quarantine)/',
						'hidden' => true
					)
				)
			  )
			)
		);

		$this->load->library('elfinder_lib', $opts);
		//$this->elfinder_lib->connect_index();
	}

	/*	조직자료실 Elfinder */
	public function elfinder_org(){

		$this->load->helper('path');

		$org_code = $this->session->userdata('org_code');
		$org_name = $this->common_function->euckr($this->orgname_array[$org_code]);
		//$org_name = $this->orgname_array[$org_code];
		//$org_name = $org_code;

		$upload_path = "/menu49";
		$upload_save_path = "files/menu49/".$org_code;

		if( $this->common_function->bt_mkdir($upload_save_path) < 0 ) exit;

		$alias_name = "HOME";

		$opts = array(
			//'debug' => true,
			'roots' => array(
			  array(
				'driver' => 'LocalFileSystem',
				'path'   => set_realpath(realpath(APPPATH.'../files')).$upload_path."/".$org_code,
				'URL'    => set_realpath(realpath(APPPATH.'libraries/')).'elfinder'.DIRECTORY_SEPARATOR.'connector.minimal.php?cmd=file&target=HASH_TO_FILE_PATH',
				'alias'  => $alias_name,
				'rememberLastDir' => false,
				// more elFinder options here
				'uploadMaxSize' => '200M',
				'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
				'uploadAllow'   => array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png',  'image/x-png', 'image/tiff', 'video/mpeg', 'application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 'application/xls', 'application/x-xls', 'application/excel', 'application/download', 'application/vnd.ms-office', 'application/msword', 'application/powerpoint', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/x-zip', 'application/zip', 'application/pdf', 'application/force-download', 'application/x-download', 'binary/octet-stream', 'application/s-compressed', 'audio/mpeg', 'audio/mpg', 'audio/mpeg3', 'audio/mp3', 'video/mp4', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/x-compressed', 'application/x-zip-compressed', 'multipart/x-zip', 'application/haansofthwp', 'application/x-hwp', 'application/unknown', 'application/octet-stream', 'text/plain', 'text/xml', 'application/cdfv2-corrupt', 'application/acad', 'image/vnd.dwg', 'image/x-dwg'),// Mimetype `image` and `office program` and 'hwp' and 'zip' allowed to upload
				'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
				'accessControl' => 'access',
				'acceptedName' => 'validName',
				'defaults'   => array('read' => true, 'write' => true),
				'attributes' => array(
					array(
						'pattern' => '/[^(\.tmb|\.quarantine)]/',
						'hidden' => false
					),
					array(
						'pattern' => '/(\.tmb|\.quarantine)/',
						'hidden' => true
					)
				)
			  )
			)
		);

		$this->load->library('elfinder_lib', $opts);
		//$this->elfinder_lib->connect_index();
	}

	/*	설계자료실 Elfinder */
	public function elfinder_design(){

		$this->load->helper('path');

		$org_code = $this->session->userdata('org_code');

		$isAdmin = ( $this->session->userdata('org_code') == 'C00' ) ? 1 : 0;

		$upload_path = "/menu83";
		$upload_save_path = "files/menu83/";

		if( $this->common_function->bt_mkdir($upload_save_path) < 0 ) exit;

		$alias_name = "Design";

		$opts = array(
			'debug' => true,
			'roots' => array(
			  array(
				'driver' => 'LocalFileSystem',
				'path'   => set_realpath(realpath(APPPATH.'../files')).$upload_path,
				'URL'    => set_realpath(realpath(APPPATH.'libraries/')).'elfinder'.DIRECTORY_SEPARATOR.'connector.minimal.php?cmd=file&target=HASH_TO_FILE_PATH',
				'alias'  => $alias_name,
				'rememberLastDir' => false,
				// more elFinder options here
				'uploadMaxSize' => '200M',
				'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
				'uploadAllow'   => array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png',  'image/x-png', 'image/tiff', 'video/mpeg', 'application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 'application/xls', 'application/x-xls', 'application/excel', 'application/download', 'application/vnd.ms-office', 'application/msword', 'application/powerpoint', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/x-zip', 'application/zip', 'application/pdf', 'application/force-download', 'application/x-download', 'binary/octet-stream', 'application/s-compressed', 'audio/mpeg', 'audio/mpg', 'audio/mpeg3', 'audio/mp3', 'video/mp4', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/x-compressed', 'application/x-zip-compressed', 'multipart/x-zip', 'application/haansofthwp', 'application/x-hwp', 'application/unknown', 'application/octet-stream', 'text/plain', 'text/xml', 'application/cdfv2-corrupt', 'application/acad', 'image/vnd.dwg', 'image/x-dwg'),// Mimetype `image` and `office program` and 'hwp' and 'zip' allowed to upload
				'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only  'application/pdf', 'application/force-download', 'application/x-download', 'binary/octet-stream'
				'accessControl' => $isAdmin ? 'rwaccess' : 'roaccess',
				'acceptedName' => 'validName'
			  )
			)
		);

		//echo print_r($opts);

		$this->load->library('elfinder_lib', $opts);
		//$this->elfinder_lib->connect_index();
	}
}

/* End of file Elfinder_mod.php */
/* Location: ./application/controllers/modules/Elfinder_mod.php */