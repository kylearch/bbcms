<?php

class Root extends Controller
{

	public function index()
	{
		$this->handoff("title", "Joust CMS");
		$this->handoff("page_content", "pages/home");
		$this->handoff("node", $this->Nodes->lookup(1));
		$this->handoff("sidebar", $this->Nodes->lookup(2));
		$this->handoff("image", $this->Nodes->lookup(3));

		$this->View->load("layouts/default");
	}

	public function test()
	{
		$this->handoff("title", "Joust CMS");
		$this->handoff("page_content", "pages/test");
		$this->handoff("node", $this->Nodes->lookup(1));

		$this->View->load("layouts/default");
	}

	public function login()
	{
		$this->handoff("title", "Login");

		if ($this->Request->is_post())
		{
			$username = $this->Request->post('username');
			$password = $this->Request->post('password');
			if ($this->Auth->login($username, $password) === TRUE)
			{
				$this->Router->redirect("/");
			}
			else
			{
				$this->handoff("error", "Incorrect username or password");
			}
		}

		$this->View->load("layouts/login");

	}

}