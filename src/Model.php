<?php

class Model
{

	public $db;
	public $_table;

	public function __construct()
	{
		$this->config = Booster::get("Config");
		$this->db = new PDO("mysql:host={$this->config->db->host};dbname={$this->config->db->database};charset=utf8", $this->config->db->user, $this->config->db->pass);
	}

	public function query($query_string)
	{
		try {
	    	$query = $this->db->query($query_string);
	    	$result = $query->fetchAll(PDO::FETCH_OBJ);
	    	return $result;
		} catch(PDOException $ex) {
	    	echo "An Error occured!";
		}
	}

	public function lookup($id)
	{
		$result = $this->query("SELECT * FROM `{$this->_table}` WHERE `id`='{$id}'");
		return (count($result) > 0) ? $result[0] : FALSE ;
	}

	public function update($id, $data)
	{
		$set = "";
		$data = $this->reduce_fields($data);
		foreach ($data as $field => $value)
		{
			$set .= "`{$field}` = :{$field}, ";
		}
		$set = trim($set, ", ");
		$query = "UPDATE `{$this->_table}` SET {$set} WHERE `id` = :id";
		$update = $this->db->prepare($query);
		foreach ($data as $field => $value)
		{
			$update->bindValue(":{$field}", $value);
		}
		$update->execute();
	}

	public function reduce_fields($data)
	{
		$columns = array();
		$result = $this->query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='{$this->config->db->database}' AND `TABLE_NAME`='{$this->_table}';");
		foreach ($result as $column)
		{
			$columns[$column->COLUMN_NAME] = "";
		}
		return array_intersect_key($data, $columns);
	}

}