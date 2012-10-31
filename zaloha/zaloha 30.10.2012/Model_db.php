<?php

/**
 * Description of Model_db
 *
 * @author Petr Kukrál
 */

class Model_db {
	
	private $host;
	private $dbname;
	private $user;
	private $password;
	private $id_connect;

	public function __construct($host, $dbname, $user, $password)
	{
		$this->host = $host;
		$this->dbname = $dbname;
		$this->user = $user;
		$this->password = $password;
	}
	
	public function query($query)
	{
	    $this->connect();
	    
	    $rows = mysql_query($query,  $this->id_connect);
	    
	    $this->disconnect();
	    
	    return $rows;
	}

	private function connect()
	{
		$this->id_connect = mysql_connect($this->host,$this->user,$this->password);

		mysql_select_db($this->dbname,$this->id_connect);
	}
	
	private function disconnect()
	{
		mysql_close($this->id_connect);
	}
    
}

?>
