<?php

class Auth
{

	public $User;

	public function __construct()
	{
		$this->User = Booster::get("User_model");
	}

	public function login($username, $password)
	{
		if ($user = $this->User->find($username))
		{
			if (password_verify($password, $user->password))
			{
				// Set cookie and proceed
				return TRUE;
			}
		}
		return FALSE;
	}

	public function encrypt($str)
	{
		$options = array(
			"salt" => $this->_salt(),
			"cost" => 12,
		);
		return password_hash($str, PASSWORD_DEFAULT, $options);
	}

	private function _salt()
	{
		// stub
		return base64_encode("joust_salt_value");
	}

}