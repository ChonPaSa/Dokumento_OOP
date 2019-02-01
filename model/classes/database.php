 <?php
class Database
{
	public $host="localhost";
	public $port=3306;
	public $dbname="ChangeMe";
	public $user="ChangeMe";
	public $password="ChangeMe";
	public $dbObject;	// PDO Object
	
	
	public function __construct()
	{
		$this->connect();
	}
	
	protected function connect()
	{
		$this->dbObject = new PDO("mysql:host=".$this->host."; dbname=".$this->dbname.";port:".
		$this->port."",$this->user, $this->password,
			array
			(
				PDO::ATTR_ERRMODE 					=> PDO::ERRMODE_WARNING,
				PDO::ATTR_DEFAULT_FETCH_MODE 		=> PDO::FETCH_ASSOC,
				PDO::MYSQL_ATTR_USE_BUFFERED_QUERY 	=> true,
				PDO::MYSQL_ATTR_INIT_COMMAND 		=> "SET NAMES utf8"
			)
		);		
	}

	public function run($sql, $array = array())
	{
		$result = $this->dbObject->prepare($sql);
		$result->execute($array);
		return $result;
	}
	public function sqlInsert($sql, $array = array())
	{
		$result = $this->run($sql, $array);
		return $this->dbObject->lastInsertId();
	}

	public function sqlUpdate($sql, $array = array())
	{
		$result = $this->run($sql, $array);
	}
	public function sqlDelete($sql, $array = array())
	{
		$result = $this->run($sql, $array);
	}
	public function sqlSelect($sql, $array = array())
	{
		$result = $this->run($sql, $array);
		$data = $result->fetchAll(); 
		return $data;
	}		
}

?>