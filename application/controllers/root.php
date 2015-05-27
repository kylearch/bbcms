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

}