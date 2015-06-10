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
				$token = $this->make_token($user);
				$this->set_token($token);
				$this->User->update($user->id, $token);
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

	public function make_token($user)
	{
		return array(
			"id" => $user->id,
			"token" => password_hash(json_encode($user), PASSWORD_DEFAULT),
			"expires" => date("Y-m-d H:i:s", strtotime("+2 weeks")),
		);
	}

	public function check_token()
	{
		if (isset($_COOKIE["token"]))
		{
			$cookie = json_decode($_COOKIE["token"], TRUE);
			if ( ! empty($cookie["id"]))
			{
				$user = $this->User->lookup($cookie["id"]);
				return ($cookie["token"] === $user->token && date('Y-m-d H:i:s') < $user->expires);
			}
		}
		return FALSE;
	}

	public function set_token($token)
	{
		setcookie("token", json_encode($token), strtotime($token["expires"]));
	}

}