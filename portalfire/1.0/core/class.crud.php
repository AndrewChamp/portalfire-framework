<?php

/**
 * PortalFire Framework
 *
 * Creates dynamic applications for rapid development.
 *
 * PHP versions 5.3.0 & up
 * MySQL versions 5.0.0 & up
 *
 * @category   Framework
 * @package    PortalFire
 * @author     Andrew Champ
 * @copyright  2011-2013 Andrew Champ
 * @license    The MIT License (MIT)
 * @version    1.0.0 RC
 * @link       https://github.com/AndrewChamp/portalfire-framework
 * @since      File available since Release 1.0.0
 * @deprecated n/a
 * @file       class.crud.php
 *
 * The MIT License (MIT)
 * Copyright (c) 2013 Andrew Champ
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction, 
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sub-license, 
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, 
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial 
 * portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT 
 * LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN
 * NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE 
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

class crud{
	
	private static $instance;
	
	private $server;
	private $user;
	private $password;
	private $database;
	private $dbh;
	
	
	/**
	 * Sets database connection properties.
	 * Notice: You can call the class directly or you can call to the obtain method to reuse the object.
	 */
	public function __construct($_server=null, $_user=null, $_password=null, $_database=null){
		if($_server == null || $_user == null || $_password == null || $_database == null)
			throw new Exception('Please input database credentials for '.__CLASS__.' class.');
		
		$this->server = $_server;
		$this->user = $_user;
		$this->password = $_password;
		$this->database = $_database;
		$this->connect();
	}
		
	
	/**
	 * Singleton Pattern.
	 * Allows for reusing the initial instanited object.  Prevents multiple mysql connections for the same call.
	 */
	public static function obtain($_server=null, $_user=null, $_password=null, $_database=null){
		if(!self::$instance)
			self::$instance = new crud($_server, $_user, $_password, $_database); 
		return self::$instance; 
	}
		
	
	/**
	 * Establishes the initial connection to the database.
	 */
	public function connect(){
		$this->dbh = new PDO("mysql:host=".$this->server.";dbname=".$this->database, $this->user, $this->password);
		$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
		
	
	/**
	 * Call to a table.
	 */
	public function query($sql){
		$statement = $this->dbh->prepare($sql);
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	
	
	/**
	 * Update query.
	 */
	public function update($table, $data, $where='1'){
		$q = "UPDATE `$table` SET ";
		foreach($data as $key=>$val):
			if(strtolower($val) == 'null'):
				$q .= "`$key` = NULL, ";
			elseif(strtolower($val) == 'now()'):
				$q .= "`$key` = NOW(), ";
			elseif(preg_match("/^increment\((\-?\d+)\)$/i", $val, $m)):
				$q .= "`$key` = `$key` + $m[1], "; 
			else:
				$q .= "`$key`='".$val."', ";
			endif;
		endforeach;
		$q = rtrim($q, ', ') . ' WHERE '.$where.';';
		
		$statement = $this->dbh->prepare($q);
		$statement->execute();
	}
		
	
	/**
	 * Insert query.
	 */
	public function insert($table, $data){
		$q = "INSERT INTO `$table` ";
		$v = ''; $n = '';
		foreach($data as $key=>$val):
			$n .= "`$key`, ";
			if(strtolower($val) == 'null'):
				$v .= "NULL, ";
			elseif(strtolower($val) == 'now()'):
				$v .= "NOW(), ";
			else: 
				$v .= "'".$val."', ";
			endif;
		endforeach;
		$q .= "(". rtrim($n, ', ') .") VALUES (". rtrim($v, ', ') .");";

		$statement = $this->dbh->prepare($q);
		$statement->execute();
	}
		
	
	/**
	 * Delete query.
	 */
	public function delete($table, $data){
		$statement = $this->dbh->prepare("DELETE FROM `".$table."` WHERE ".$data);
		$statement->execute();
	}
	
	
	/**
	 * Number of returned results.
	 */
	public function num($results){
		return count($results);
	}


}

?>