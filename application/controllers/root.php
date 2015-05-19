<?php

class Root extends Controller
{

	public function index()
	{
		$this->handoff("title", "BBCMS");
		$this->handoff("page_content", "pages/home");
		$this->handoff("node", $this->Nodes->lookup(1));

		$this->View->load("layouts/default");
	}

	public function test()
	{
		$this->handoff("title", "Test Page");
		$this->handoff("page_content", "pages/test");
		$this->handoff("node", $this->Nodes->lookup(1));

		$this->View->load("layouts/default");
	}

}