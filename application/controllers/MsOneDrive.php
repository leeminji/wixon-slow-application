<?php

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use Microsoft\Graph\Model\UploadSession;

defined('BASEPATH') OR exit('No direct script access allowed');

class MsOneDrive extends MS_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library("loaddata");
		$this->load->model("tokenCache_m");
	}
	
	public function view(){

	}

	public function index()
	{
		$viewData = $this->loaddata->get();

		$accessToken = $this->tokenCache_m->getAccessToken();

		$graph = new Graph();
		$graph->setAccessToken($accessToken);

		$getEventsUrl = '/me/drive';
		$events = $graph->createRequest('GET', $getEventsUrl)
		->setReturnType(Model\Event::class)
		->execute();

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($events));	  		
	}

	public function sites(){
		$site_id = $this->input->get('site_id') == null ? "root" : $this->input->get('site_id');
		
        $loadData = $this->loaddata->get();
		$accessToken = $this->tokenCache_m->getAccessToken();
		$queryParams = array(
			// '$select' => 'subject,organizer,start,end',
			// '$orderby' => 'createdDateTime DESC'
		);
		$graph = new Graph();
		$graph->setAccessToken($accessToken);
		$getEventsUrl = "/sites/{$site_id}/lists?".http_build_query($queryParams);
		echo $getEventsUrl;

		$events = $graph->createRequest('GET', $getEventsUrl)
		->setReturnType(Model\Event::class)
		->execute();
		
		$this->output->set_content_type('text/json');
		$this->output->set_output(json_encode($events));
	}

	public function sites2(){
		$hostname = $this->input->get('hostname') == null ? "root" : $this->input->get('hostname');
		$path = $this->input->get('path') == null ? "" : $this->input->get('path');

        $loadData = $this->loaddata->get();
		$accessToken = $this->tokenCache_m->getAccessToken();

		$graph = new Graph();
		$graph->setAccessToken($accessToken);
		$getEventsUrl = "/sites/{$hostname}:/{$path}";
		echo $getEventsUrl;

		$events = $graph->createRequest('GET', $getEventsUrl)
		->setReturnType(Model\Event::class)
		->execute();
		
		$this->output->set_content_type('text/json');
		$this->output->set_output(json_encode($events));
	}

	public function drives(){

		$drive_id = $this->input->get('drive_id');
		
        $loadData = $this->loaddata->get();
		$accessToken = $this->tokenCache_m->getAccessToken();
		$queryParams = array(
			// '$select' => 'subject,organizer,start,end',
			// '$orderby' => 'createdDateTime DESC'
		);

		$graph = new Graph();
		$graph->setAccessToken($accessToken);
		$getEventsUrl = "/drives/{$drive_id}/root/children?".http_build_query($queryParams);

		$events = $graph->createRequest('GET', $getEventsUrl)
		->setReturnType(Model\DriveItem::class)
		->execute();

		//다시가공
		$drive_list = array();
		foreach($events as $event){
			$item = array(
				"id" => $event->getId(),
				"name" => $event->getName(),
				"modified_date" => $event->getLastModifiedDateTime(),
				"is_folder" => $event->getFile() != null ? true : false,
				"type" => $this->get_type($event->getName()),
				"thumbnail" => null
			);

			//이미지인경우 썸네일생성
			if( $item['type'] == 'image' ){
				//$item['thumbnail'] = $this->thumbnail($item['id']);
			}

			//링크
			if( $item['type'] == 'folder'){
				$item['link'] = "/MsOneDrive/items?item_id={$item['id']}&back_id={$drive_id}";
			}else{
				$downloadUrl = "";
				$properties = $event->getProperties();
				if (array_key_exists("@microsoft.graph.downloadUrl", $properties)){
					$downloadUrl = $properties["@microsoft.graph.downloadUrl"];
				}
				$item['link'] = $downloadUrl;
			}
			$drive_list[] = $item;
		}

		$data = array(
			"title"=> "MS dirve 가져오기",
			"drive_list" => $drive_list,
			"back_link" => null
		);

		$this->_win_view("ms/drives_v", $data);
	}

	public function items(){
		$item_id = $this->input->get("item_id");
		$back_id = $this->input->get("back_id");

        $loadData = $this->loaddata->get();
		$accessToken = $this->tokenCache_m->getAccessToken();

		$graph = new Graph();
		$graph->setAccessToken($accessToken);
		$getEventsUrl = "/me/drive/items/{$item_id}/children";
		$events = $graph->createRequest('GET', $getEventsUrl)
		->setReturnType(Model\DriveItem::class)
		->execute();

		//다시가공
		$drive_list = array();
		foreach($events as $event){
			$item = array(
				"id" => $event->getId(),
				"name" => $event->getName(),
				"modified_date" => $event->getLastModifiedDateTime(),
				"is_folder" => $event->getFile() != null ? true : false,
				"type" => $this->get_type($event->getName()),
				"thumbnail" => null
			);

			//이미지인경우 썸네일생성
			if( $item['type'] == 'image' ){
				//$item['thumbnail'] = $this->thumbnail($item['id']);
			}

			//링크
			if( $item['type'] == 'folder'){
				$item['link'] = "/MsOneDrive/items?item_id={$item['id']}&back_id={$back_id}";
			}else{
				$downloadUrl = "";
				$properties = $event->getProperties();
				if (array_key_exists("@microsoft.graph.downloadUrl", $properties)){
					$downloadUrl = $properties["@microsoft.graph.downloadUrl"];
				}
				$item['link'] = $downloadUrl;
			}
			$drive_list[] = $item;
		}

		$back_link = strpos($back_id, "!") > -1 ? "/MsOneDrive/items?item_id={$item_id}" : "/MsOneDrive/drives?drive_id={$back_id}";
		
		$data = array(
			"title"=> "MS dirve 가져오기",
			"drive_list" => $drive_list,
			"back_link" => $back_link,
		);

		$this->_win_view("ms/drives_v", $data);
	}

	//확장자 알아내기
	public function get_type($filename){
		$result = "folder";
		if( strpos($filename, ".") ){
			$array = explode('.', $filename);
			$ext = $array[count($array)-1];
			switch($ext){
				case "xlsx" : 
					$result = "excel";
					break;				
				case "png" : 
					$result = "image";
					break;
				case "jpg" : 
					$result = "image";
					break;
				case "jpeg" : 
					$result = "image";
					break;
				case "bmp" : 
					$result = "image";
					break;
				case "pdf" : 
					$result = "pdf";
					break;
				case "txt" : 
					$result = "doc";
					break;
				default :
					break;
			}
		}
		return $result;
	}

	public function thumbnail($item_id){
        $loadData = $this->loaddata->get();
		$accessToken = $this->tokenCache_m->getAccessToken();

		$graph = new Graph();
		$graph->setAccessToken($accessToken);
		$getEventsUrl = '/me/drive/items/'.$item_id.'/thumbnails';
		$events = $graph->createRequest('GET', $getEventsUrl)
		->setReturnType(Model\Thumbnail::class)
		->execute();

		$thumbnail_list = array();
		foreach($events as $event){
			$item = array(
				"url" => $event->getUrl()
			);
			$thumbnail_list[] = $item;
		}
		return $thumbnail_list;		
	}

	public function shared(){
		$item_id = $this->input->get("item_id");
        $data['page'] = '/ms/file_explore_v';
        
        $loadData = $this->loaddata->get();
		$accessToken = $this->tokenCache_m->getAccessToken();
		$queryParams = array(
			// '$select' => 'subject,organizer,start,end',
			// '$orderby' => 'createdDateTime DESC'
		);
		$graph = new Graph();
		$graph->setAccessToken($accessToken);
		$getEventsUrl = '/me/drive/sharedWithMe?'.http_build_query($queryParams);
		$events = $graph->createRequest('GET', $getEventsUrl)
		->setReturnType(Model\Event::class)
		->execute();

		$this->output->set_content_type('text/json');
		$this->output->set_output(json_encode($events));
		// var_dump($events);

		// var_dump($loadData);

        // $data['data'] = $data;
        // $this->load->view("/layout/layout_v", $data);		
	}

	public function download(){
		$item_id = $this->input->get("item_id");
		
        $loadData = $this->loaddata->get();
		$accessToken = $this->tokenCache_m->getAccessToken();
		$queryParams = array(
			// '$select' => 'subject,organizer,start,end',
			// '$orderby' => 'createdDateTime DESC'
		);
		$graph = new Graph();
		$graph->setAccessToken($accessToken);
		$getEventsUrl = "/me/drive/items/{$item_id}/content";
		$events = $graph->createRequest('GET', $getEventsUrl)
		->setReturnType(Model\Event::class)
		->execute();
		//redirect($events);

		$this->output->set_content_type('text/json');
		$this->output->set_output(json_encode($events));
		// var_dump($events);

		// var_dump($loadData);

        // $data['data'] = $data;
        // $this->load->view("/layout/layout_v", $data);		
	}

	public function findUploadPath($filepath){

		$filepath = str_replace("Public", "", $filepath);
		$upload_path = "menu48";
		$path = set_realpath(realpath(APPPATH.'../files')).$upload_path;

		return $path.$filepath;
	}

	//item_id (폴더명)-> 파일선택 바이너리파일로 올림.
	public function upload(){
		$this->load->helper(array('path', 'file'));

		$item_id = $this->input->get("item_id");
		$filename = $this->input->get("filename");
		$return_url = $this->input->get('return_url');
		$path = $this->input->get('path');

		//파일경로
		$file = $this->findUploadPath($path);
		if( read_file($file) && $filename == null ){
			$file_info = get_file_info($file);
			$filename = $file_info['name'];
		}

        $loadData = $this->loaddata->get();
		$accessToken = $this->tokenCache_m->getAccessToken();

		$graph = new Graph();
		$graph->setAccessToken($accessToken);
		$getEventsUrl = "/me/drive/items/{$item_id}:/{$filename}:/createUploadSession";
		
		$uploadSession = $graph->createRequest('POST', $getEventsUrl)
		->addHeaders(["Content-Type" => "application/json"])
		->attachBody([
			"item" => [
				"@microsoft.graph.conflictBehavior" => "rename",
				"description"    => 'File description here'
			]
		])
		->setReturnType(Model\UploadSession::class)
		->execute();
		//redirect($events);

		$handle = fopen($file, 'r');
		$fileSize = fileSize($file);
		$fileNbByte = $fileSize - 1;
		$chunkSize = 1024*1024*4;
		$fgetsLength = $chunkSize + 1;
		$start = 0;
		while (!feof($handle)) {
			$bytes = fread($handle, $fgetsLength);
			$end = $chunkSize + $start;
			if ($end > $fileNbByte) {
				$end = $fileNbByte;
			}
			/* or use stream
			$stream = \GuzzleHttp\Psr7\stream_for($bytes);
			*/
			$res = $graph->createRequest("PUT", $uploadSession->getUploadUrl())
				->addHeaders([
					'Content-Length' => ($end - 1) - $start,
					'Content-Range' => "bytes " . $start . "-" . $end . "/" . $fileSize
				])
				->setReturnType(Model\UploadSession::class)
				->attachBody($bytes)
				->execute();
		
			$start = $end + 1;
		}
		
		if( $return_url ){
			redirect($return_url);
		}	
	}	
}
