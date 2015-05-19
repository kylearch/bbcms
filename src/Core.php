<?php

class BBCMS
{

	private $_required = array(
		"Booster",
		"Config",
		"Controller",
		"Model",
		"REST_Controller",
		"Router",
		"View",
	);

	public function __construct()
	{
		// Needs to check if files exist and handle erros if not (fatal)
		foreach ($this->_required as $file) {
			require("{$file}.php");
		}

		$this->Config = Booster::set("Config");
		$this->Router = Booster::set("Router");
		$this->View = Booster::set("View");
		$this->Model = Booster::set("Model");
	}

	public function run()
	{
		$this->Controller = Controller::load();
		$this->Controller->go();
		$this->View->render();
	}

}