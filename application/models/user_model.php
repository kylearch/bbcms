<?php

class User_model extends Model
{

	public $_table = "users";

	public function find($username)
	{
		$username = $this->db->quote($username);
		$this->where("`username` = {$username}");
		$this->build_select_query();
		$result = $this->query();
		return (count($result) === 1) ? $result[0] : FALSE ;
	}

}