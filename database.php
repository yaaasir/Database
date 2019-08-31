<?php

class Database
{
	
	var $query = '';

	var $conn ;
	
	function __construct() {
		//establish the connection on class initialization

		$this->conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME) or die ("<br><br><center>Duh! Couldn't connect to DB: " . mysqli_error() . "</center>");
	}
	
	function clear() {

		// clear the query

		$this->query = '';
	}
	
	function customQuery($sql) {

		$this->query = $sql;

		return $this;
	}
	

	function select($table,$fields = '*',$alias = '') {

		$this->query = 'SELECT ' . $fields . ' FROM ' . $table;

		if($alias!='') $this->query .= ' as ' . $alias;
		
		return $this;
	}
	

	function insert($table,$values,$fields='') {

		$this->query = 'INSERT INTO  ' . $table;

		if($fields!='') {

			$this->query .= ' (' . $fields . ')';
			$this->query .= ' VALUES (' . $values . ')';

		} else {

			// get the fields and values
			$this->query .= $this->getFieldsInsert($values);
		}

//		echo $this->query; exit;

		return $this;
	}

	
	function update($table,$set) {

		$this->query = 'UPDATE ' . $table . ' SET ' . $set;
		
		$i=0;

		/*
		 * if $set is array()
		foreach($set as $s) {
			if($i!=0) {
				$this->query .= ', ';
				$i=1;
			}
			$this->query .= $s;
		}
		*/

		return $this;

	}
	
	function delete($table) {

		$this->query = 'DELETE FROM ' . $table;
		
		return $this;
	}
	

	function join($join,$type='INNER') {

		$this->query .= ' ' . $type . ' JOIN ' . $join;
		
		return $this;
	}
	

	function where($where = array()) {

		if(count($where) > 0) {

			$i=0;

			$this->query .= ' WHERE ';

			foreach($where as $name => $value) {

				if($i!=0) {
					$this->query .= ' AND ';
				}

				$this->query .= $name. "=\"$value\"";
				
				$i=1;
			}
		}
		
		return $this;
	}

	
	function orderby($order) {

		$this->query .= ' ORDER BY ' . $order;
		
		return $this;
	}
	

	function groupby($group) {

		$this->query .= ' GROUP BY ' . $group;
		
		return $this;
	}
	
	function limit($limit) {

		$this->query .= ' LIMIT ' . $limit;
		
		return $this;
	}
	
	function run($stop = 0) {

		if($stop==1) {
			echo $this->query; exit;
		}
		
		
		$q = mysqli_query( $this->conn , $this->query) or die( mysqli_error($this->conn).$this->query);

		if( $last_id = mysqli_insert_id($this->conn) ) return $last_id;
		
		return $q;

	}
	

	function trataString($str) {
		return "'" . $str . "'";
	}
	

	// get the fields and values from an array (except if it's the $exclude)
	function getFields($fields,$separator=',',$exclude='') {

		$out = '0';

		foreach($fields as $name => $value) {

			if($name!=$exclude) {

				$out .= $separator . ' ' . $name . " = '" . $value . "'";

			}
		}
		
		$out = str_replace('0'.$separator.' ', '', $out);
		
		return $out;
		
	}
	
	// get the fields for the insert statement
	function getFieldsInsert($f) {

		$fields = '(0';
		$values = '(0';

		foreach($f as $name => $value) {

			$fields .= ',' . $name;
			$values .= ",'" . $value . "'";

		}
		
		$fields = str_replace('0,', '', $fields);
		$values = str_replace('0,', '', $values);
		
		$out = $fields . ') VALUES ' . $values . ')';
		
		return $out;
		
	}
}
?>