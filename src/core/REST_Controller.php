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
		else
		{
			$data = $this->get_post();
		}
		return ( ! empty($data)) ? $data : NULL ;
	}

	// Currently only supports 1 file (until otherwise becomes necessary)
	public function get_post()
	{
		$data = $_REQUEST;
		if ( ! empty($_FILES))
		{
			$data["file"] = $_FILES[key($_FILES)];
		}
		return $data;
	}

}