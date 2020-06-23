<?php

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends CI_Controller {
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
			'$select' => 'subject,organizer,start,end',
			'$orderby' => 'createdDateTime DESC'
		);

		$getEventsUrl = '/me/events?'.http_build_query($queryParams);
		$events = $graph->createRequest('GET', $getEventsUrl)
		->setReturnType(Model\Event::class)
		->execute();

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($events));	  		
	}
}
