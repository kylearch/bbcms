<?php

class View
{

	public $html;
	public $output_to_browser = TRUE;
	public $ob_level;

	public function __construct()
	{
		$this->ob_level = ob_get_level();
	}

	public function load($view)
	{
		$file = "application/views/{$view}.php";
		if ( ! file_exists($file))
		{
			throw new Exception("Could not find view file: {$file}");
		}
		else
		{
			extract(Controller::get_handoff());
			ob_start();
			include($file);
			// Borrowed from Code Igniter
			// Allows for nested loading of files
			if (ob_get_level() > $this->ob_level + 1)
			{
				ob_end_flush();
			}
			else
			{
				$this->html .= ob_get_contents();
				@ob_end_clean();
			}
		}
	}

	public function render()
	{
		@ob_end_clean();
		echo $this->html;
	}

}