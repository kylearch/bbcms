<?php

class REST_Controller extends Controller
{
	
	public $method;
	public $action_plain;

	public function __construct()
	{
		parent::__construct();
		$this->method = $_SERVER["REQUEST_METHOD"];
		$this->action_plain = $this->action;
		$this->action = $this->action . "_" . strtolower($this->method);
	}

	public function response($data)
	{
		die(json_encode($data));
	}

	public function parse_request()
	{
		$raw_data = file_get_contents("php://input");
		if ( ! empty($raw_data))
		{
		    $data = @json_decode($raw_data, TRUE);
		}
		return ( ! empty($data)) ? $data : NULL ;
	}

}