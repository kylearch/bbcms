<?php

class API extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->model = Booster::set("Node_model");
		$this->Auth = Booster::get("Auth");
		if ( ! $this->Auth->check_token())
		{
			header('HTTP/1.1 401 Unauthorized');
			die('Unauthorized. Please login to access this endpoint');
		}
	}

	public function node_get($id)
	{
		$node = $this->model->lookup($id);
		$this->response($node);
	}

	public function node_put()
	{
		$node = $this->parse_request();
		$this->model->update($node["id"], $node);
		$this->response($node);
	}

	public function nodes_get()
	{
		$nodes = $this->model->query();
		$this->response($nodes);
	}

	public function file_post()
	{
		$file = Booster::set("File");
		$request = $this->parse_request();
		$request["src"] = $file->node_file($request);
		$this->response($request);
	}

}