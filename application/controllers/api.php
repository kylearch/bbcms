<?php

class API extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->model = Booster::set("Node_model");
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

}