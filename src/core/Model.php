<?php

class Model
{

	public $db;
	public $_table;
	public $_sql = "";
	public $_type = "select";

	public $_select;
	public $_where = "";
	public $_limit = "";
	public $_offset = "";
	
	public $_id;

	public function __construct()
	{
		$this->config = Booster::get("Config");
		$this->db = new PDO("mysql:host={$this->config->db->host};dbname={$this->config->db->database};charset=utf8", $this->config->db->user, $this->config->db->pass);
	}

	public function reset($var)
	{	
		$tmp = $this->{$var};
		$this->{$var} = "";
		return $tmp;
	}

	public function type($type = null)
	{
		if ( ! is_null($type))
		{
			$this->_type = $type;
		}	
		return $this->_type;
	}

	public function id($id = null)
	{
		if ( ! is_null($id))
		{
			$this->_id = $id;
		}	
		return $this->_id;	
	}

	public function build_select_query()
	{
		$this->type("select");
		$this->_select = empty($this->_select) ? "SELECT * FROM `{$this->_table}`" : $this->_select ;
		$this->_sql = "{$this->_select} {$this->_where} {$this->_limit} {$this->_offset}";

		$this->reset("_where");
		$this->reset("_limit");
		$this->reset("_offset");
	}

	public function build_insert_query($values)
	{
		$this->type("insert");
		$fields_str = "(`" . implode("`, `", array_keys($values)) . "`)";
		$values_str = "(:" . implode(", :", array_keys($values)) . ")";
		$sql = "INSERT INTO `{$this->_table}` {$fields_str} VALUES {$values_str}";
		$this->_sql = $this->db->prepare($sql);
		foreach ($values as $field => $value)
		{
			$this->_sql->bindValue(":{$field}", $value);
		}
	}

	public function build_update_query($values)
	{
		$this->type("update");
		$set = "";
		foreach ($values as $field => $value)
		{
			$set .= "`{$field}` = :{$field}, ";
		}
		$set = trim($set, ", ");
		$query = "UPDATE `{$this->_table}` SET {$set} WHERE `id` = :id";
		$this->_sql = $this->db->prepare($query);
		foreach ($values as $field => $value)
		{
			$this->_sql->bindValue(":{$field}", $value);
		}
	}

	public function query($sql = null)
	{
		if (is_null($sql))
		{
			$sql = $this->reset("_sql");
		}
		else
		{
			$this->type(strtolower(strtok($sql, " ")));
		}
		$type = $this->reset("_type");

		$this->reset("_select");
		$this->reset("_where");
		$this->reset("_limit");
		$this->reset("_offset");

		try {
			if ($type == "select")
			{
				$query_string = $sql;
				$query = $this->db->query($sql);
				$result = $query->fetchAll(PDO::FETCH_OBJ);
			}
			else
			{
				$query_string = $sql->queryString;
				$sql->execute();
				switch ($type)
				{
					case 'update':
					case 'delete':
						$result = $this->lookup($this->id());
					break;
					case 'insert':
						$result = $this->lookup($this->db->lastInsertId());
					break;
				}
			}
	    	return $result;
		} catch(PDOException $ex) {
	    	echo "An Error occured! Tried to do: " . $query_string;
	    	echo "<pre>"; print_r($ex); echo "</pre>";
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
		$this->id($id);
		$this->where("`id` = {$id}");
		$this->build_select_query();
		$result = $this->query();
		return (count($result) > 0) ? $result[0] : FALSE ;
	}

	public function insert($data)
	{
		$values = $this->reduce_fields($data);
		$this->build_insert_query($values);
		$this->query();
	}

	public function update($id, $data)
	{
		$this->id($id);
		$values = $this->reduce_fields($data);
		$values["id"] = $id;
		$this->build_update_query($values);
		$this->query();
	}

	public function delete($id)
	{
		//stub
	}

	public function reduce_fields($data)
	{
		$this->type("select");
		$columns = array();
		$this->select("COLUMN_NAME", "`INFORMATION_SCHEMA`.`COLUMNS`");
		$this->where(array("`TABLE_SCHEMA`='{$this->config->db->database}'", "`TABLE_NAME`='{$this->_table}'"));
		$this->build_select_query();
		$result = $this->query();
		foreach ($result as $column)
		{
			$columns[$column->COLUMN_NAME] = "";
		}
		return array_intersect_key($data, $columns);
	}

}