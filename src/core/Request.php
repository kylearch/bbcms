<?php

class Request
{

	public function method()
	{
		return $_SERVER["REQUEST_METHOD"];
	}

	public function is_post()
	{
		return $this->method() === "POST";
	}

	public function post($field = NULL)
	{
		if ($this->method() !== "POST")
		{
			return FALSE;
		}

		if (is_null($field))
		{
			return $_POST;
		}

		return (empty($_POST[$field])) ? FALSE : $_POST[$field] ;
	}

}