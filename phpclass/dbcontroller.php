<?php
class DBconn {
	private $host = 'localhost';
	private $userid = "root";
	private $password = "cmskorea";
	private $database = "dbboard";
	protected $db;
	
	//생성자
	public function __construct(){
		$this->db = $this->connetDB();
	}
	//소멸자
	function __destruct() {
		;
	}	
	
	private function connetDB() {
		$dbconn = mysqli_connect($this->host, $this->userid, $this->password, $this->database);
		if ($dbconn) {
			//echo "DB연결 성공";
			return $dbconn;
		} else {
			//echo "DB연결 실패 : " . mysqli_error($mysql);
			return false;
		};
		
	}
	
	function data_list($table) {
		$query = "SELECT * FROM " . $table;
		$rs = mysqli_query($this->db, $query);
		// 	$rows = mysqli_fetch_all($rs);
		
		// 	echo "<pre>";
		// 	var_dump($rows);
		// 	echo "</pre>";
		// 	return $rows;
		
		$rows = array();
		while(!!($row = mysqli_fetch_assoc($rs))) {
			$rows[] = $row;
		}
		
		return $rows;
	}
	function data_search($table, $searchrow, $row, $var) {
		$query = "SELECT " . $searchrow . " FROM " . $table . " where " . $row . "='" . $var . "';";
		$rs = mysqli_query($this->db, $query);
		
		$rows = mysqli_fetch_all($rs);
		
		
		if (empty($rows))
			return false;
			else
				return $rows[0][0];
	}
}

?>