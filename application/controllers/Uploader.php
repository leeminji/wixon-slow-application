<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploader extends CI_Controller {
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

	public function binary(){
		$filename = "C:\\Users\\MJ\\Downloads\\test.png";
		$handle = fopen($filename, "rb");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
		echo $contents;
	}
}
