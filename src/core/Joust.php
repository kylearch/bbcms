<?php

class Joust
{

	private $_required = array(
		"Booster",
		"Config",
		"Controller",
		"File",
		"Model",
		"REST_Controller",
		"Router",
		"View",
	);

	public function __construct()
	{
		session_start();

		// Needs to check if files exist and handle erros if not (fatal)
		foreach ($this->_required as $file) {
			require("{$file}.php");
		}

		$this->Config = Booster::set("Config");
		$this->Router = Booster::set("Router");
		$this->View = Booster::set("View");
		$this->Model = Booster::set("Model");

		date_default_timezone_set($this->Config->timezone);
	}

	public function run()
	{
		$this->Controller = Controller::load();
		if ($this->Controller->go())
		{
			$this->View->render();
		}
	}

}