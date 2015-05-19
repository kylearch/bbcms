<?php

class Controller
{

	public $Router;
	public $Nodes;
	public $action = "index";

	public static $controller = "root";
	public static $_handoff;

	public function __construct()
	{
		$this->View = Booster::get("View");
		$this->Model = Booster::get("Model");
		$this->Nodes = Booster::set("Node_model");
		self::$_handoff = new stdClass();
		$this->parse_action();
	}

	public static function load($controller = NULL)
	{
		$router = Booster::get("Router");
		$config = Booster::get("Config");

		if (is_null($controller))
		{
			$controller_class = $config->routes->default_controller;
			if ( ! empty($router->route[0]) && Booster::find_class_file($router->route[0]))
			{
				$controller_class = $router->route[0];
			}
			foreach ($router->routes as $route => $directive)
			{
				if ($router->request === $route)
				{
					$controller_class = $router->route[0];
					break;
				}
			}
		}
		else
		{
			$controller_class = $controller;
		}
		self::$controller = $controller_class;
		return Booster::set($controller_class, "Controller");
	}

	public function parse_action()
	{
		$this->Router = Booster::get("Router");
		if (self::$controller !== $this->Router->route[0] && ! empty($this->Router->route[0]))
		{
			$this->action = $this->Router->route[0];
		}
		else if (self::$controller === $this->Router->route[0] && ! empty($this->Router->route[1]))
		{
			$this->action = $this->Router->route[1];
		}
	}
	
	public function go()
	{
		if (method_exists($this, $this->action))
		{
			$args = $this->Router->get_args($this instanceof REST_Controller);
			call_user_func_array(array($this, $this->action), $args);
		}
		else
		{
			echo "Could not find method {$this->action} in class " . get_class($this);
		}
	}

	public function handoff($var, $value)
	{
		self::$_handoff->{$var} = $value;
	}

	public static function get_handoff($array = TRUE)
	{
		return ($array) ? (array)self::$_handoff : self::$_handoff ;
	}

}