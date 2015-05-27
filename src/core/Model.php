<?php

class Model
{

	public $db;
	public $_table;
	public $_select;
	public $_where = "";
	public $_limit = "";
	public $_offset = "";

	public function __construct()
	{
		$this->config = Booster::get("Config");
		$this->db = new PDO("mysql:host={$this->config->db->host};dbname={$this->config->db->database};charset=utf8", $this->config->db->user, $this->config->db->pass);
		$this->_select = "SELECT * FROM `{$this->_table}`";
	}

	public function build_query()
	{
		$sql = "{$this->_select} {$this->_where} {$this->_limit} {$this->_offset}";
		// Reset query pieces for next query
		$this->_select = "SELECT * FROM `{$this->_table}`";
		$this->_where = "";
		$this->_limit = "";
		$this->_offset = "";
		return $sql;
	}

	public function query()
	{
		$sql = $this->build_query();
		try {
	    	$query = $this->db->query($sql);
	    	$result = $query->fetchAll(PDO::FETCH_OBJ);
	    	return $result;
		} catch(PDOException $ex) {
	    	echo "An Error occured! Tried to do: " . $sql;
		}
	}

	public function select($what, $from = NULL)
	{
		$select = "SELECT ";
		$from = is_null($from) ? $this->_table : trim($from, "`") ;
		$what = is_array($what) ? $what : array($what) ;
		for ($i = 0; $i < count($what); $i++)
		{
			$select .= ($what[$i] === "*") ? $what[$i] : "`{$what[$i]}`" ;
			$select .= ($i == count($what) - 1) ? "" : ", " ;
		}
		$select .= " FROM `{$from}`";
		$this->_select = $select;
	}

	public function where($clause, $join = "AND")
	{
		$clauses = is_array($clause) ? $clause : array($clause) ;
		$where = "WHERE (";
		for ($i = 0; $i < count($clauses); $i++)
		{
			$where .= "{$clauses[$i]}";
			$where .= ($i == count($clauses) - 1) ? ")" : " {$join} " ;
		}
		$this->_where .= $where;
	}

	// Both of these (or_where and and_where) need to handle cases where someone doesn't first instantiate a plain where() first
	public function or_where($clause, $join = "AND")
	{
		$this->_where .= " OR ";
		$this->where($clause, $join);
	}

	public function and_where($clause, $join = "AND")
	{
		$this->_where .= " AND ";
		$this->where($clause, $join);
	}


	public function lookup($id)
	{
		$this->where("`id` = {$id}");
		$result = $this->query();
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
		$this->select("COLUMN_NAME", "`INFORMATION_SCHEMA`.`COLUMNS`");
		$this->where(array("`TABLE_SCHEMA`='{$this->config->db->database}'", "`TABLE_NAME`='{$this->_table}'"));
		$result = $this->query();
		foreach ($result as $column)
		{
			$columns[$column->COLUMN_NAME] = "";
		}
		return array_intersect_key($data, $columns);
	}

}