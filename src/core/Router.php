<?php

class Router
{

	public $request;
	public $route;
	public $method;
	public $args;

	public $routes;

	public function __construct()
	{
		$this->request = trim($_SERVER["REQUEST_URI"], "/ ");
		$this->route = explode("/", $this->request);
		$this->method = $_SERVER["REQUEST_METHOD"];

		$config = Booster::get("Config");
		$this->routes = $config->routes;
	}

	public function get_args($rest = FALSE)
	{
		$controller = Booster::get("Controller");
		$action = ($rest) ? $controller->action_plain : $controller->action ;
		$key = array_search($action, $this->route) + 1;
		return array_slice($this->route, $key);
	}

}