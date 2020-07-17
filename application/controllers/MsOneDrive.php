<?php

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use Microsoft\Graph\Model\UploadSession;

defined('BASEPATH') OR exit('No direct script access allowed');

class MsOneDrive extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library("loaddata");
		$this->load->model("tokenCache_m");
	}

	public function index()
	{
		$viewData = $this->loaddata->get();

		$accessToken = $this->tokenCache_m->getAccessToken();

		$graph = new Graph();
		$graph->setAccessToken($accessToken);

		$queryParams = array(
			// '$select' => 'subject,organizer,start,end',
			// '$orderby' => 'createdDateTime DESC'
		);

		$getEventsUrl = '/me/drive?'.http_build_query($queryParams);
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
		->setReturnType(Model\Event::class)
		->execute();
		
		$this->output->set_content_type('text/json');
		$this->output->set_output(json_encode($events));

	}	
	public function items(){
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
		$getEventsUrl = "/me/drive/items/{$item_id}/children".http_build_query($queryParams);
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
	public function thumbnail(){
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
		$getEventsUrl = '/me/drive/items/'.$item_id.'/thumbnails?'.http_build_query($queryParams);
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

	//item_id (폴더명)-> 파일선택 바이너리파일로 올림.
	public function upload(){
		$item_id = $this->input->get("item_id");
		$filename ="tester.png";
        $loadData = $this->loaddata->get();
		$accessToken = $this->tokenCache_m->getAccessToken();
		$queryParams = array(
			// '$select' => 'subject,organizer,start,end',
			// '$orderby' => 'createdDateTime DESC'
		);

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

		$file = 'C:\\Users\\MJ\\Downloads\\test.png';
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
		
		// var_dump($events);
		// var_dump($loadData);

        // $data['data'] = $data;
        // $this->load->view("/layout/layout_v", $data);		
	}	
}
