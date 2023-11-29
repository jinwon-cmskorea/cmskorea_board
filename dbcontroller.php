<?php
class DBconn {
	private $host = 'localhost';
	private $userid = "root";
	private $password = "cmskorea";
	private $database = "dbboard";
	protected $db;
	
	//생성자
	public function __construct(){
		$this->db = $this->classConnectDB();
	}
	//소멸자
	function __destruct() {
		mysqli_close($this->classConnectDB());
	}	
	
	private function classConnectDB() {
		$classdbconn = mysqli_connect($this->host, $this->userid, $this->password, $this->database);
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		} else {
			return $classdbconn;
		}
	}
	
	//DB Query Custom 함수
	function getDbData($table, $row, $var, $column) {
		$result = mysqli_query($this->db,'select '. $column .' from ' . $table . ' where ' . $row . "=" . $var . ";");
		$row = mysqli_fetch_assoc($result);
		return $row;
	}
	// DB Query result 함수
	function Dbresult($table, $row, $var, $column){
		$result = mysqli_query($this->db,'select ' . $column . ' from ' . $table . ' where ' . $row . "='" . $var . "';");
		return $result;
	}
	
	//데이터 정보에 맞게 출력하기
	function page_data_list($table=null, $flddata=null, $arr=null, $start_list=null, $last_list=null){
		$query = "select " . $flddata . " from " . $table;
		//검색, 정렬 배열 값 꺼내기
		if (array_key_exists('searchInput', $arr)) {
			$query .= " where " . $arr["searchTag"] . " LIKE '%" . $arr["searchInput"] . "%'";
		}
		if (array_key_exists('orderName', $arr)) {
			$query .= " order by " . $arr["orderName"] . " " . $arr["sort"];
		}
		$query .=" limit ". $start_list .", ". $last_list. ";";
		$result =  mysqli_query($this->db,$query);
		if($result){
			return $result;
		}else{
			return mysqli_error($this->db);
		}
	}
	//DB데이터 ARRAY -> 페이징
	function getDbPageArray($table,$rowsPage,$curPage){
		$sql = 'select * from ' . $table . " limit " . (($curPage-1)*$rowsPage) . ", " . $rowsPage . ";";
		$result = mysqli_query($this->db,$sql);
		
		if($result){
			return $result;
		}
	}
	//DB데이터 레코드 총 개수
	function getDbRows($table, $row, $var){ 
		$sql = 'select count(*) from '.$table. ' where ' . $row . " LIKE '%" . $var . "%';";
		if($result = mysqli_query($this->db,$sql)){
			$rows = mysqli_fetch_row($result);
			return $rows[0] ? $rows[0] : 0;
		}
	}
	function getDbAllRows($table){
		$sql = 'select count(*) from '.$table.";";
		if($result = mysqli_query($this->db,$sql)){
			$rows = mysqli_fetch_row($result);
			return $rows[0] ? $rows[0] : 0;
		}
	}
	//DB삽입
	function getDbInsert($table,$key,$val){
		$rs = mysqli_query($this->db,"insert into " . $table . " " . $key . " values" . $val);
		if (!$rs) {
			echo "등록실패 : " . mysqli_error($this->db);
		}
	}
		
	//DB업데이트
	function getDbUpdate($table,$set, $row, $var){
		$rs = mysqli_query($this->db,"update " . $table . " set " . $set . "where " . $row . "='" . $var . "';");
		if (!$rs) {
			echo "등록실패 : " . mysqli_error($this->db);
		}
	}
	//DB삭제
	function getDbDelete($table, $row, $var){
		$rs = mysqli_query($this->db,"delete from " . $table . ' where ' . $row . "=" . $var . ";");
		if (!$rs) {
			echo "등록실패 : " . mysqli_error($this->db);
		}
	}
	//SQL필터링    
	function getSqlFilter($sql){
		return $sql;
	}
	//DB 불러오기    
	function getDBconnect(){
		return $this->db;
	}
	
	//데이터 가져오기
 	function data_list($table) {
		$query = "SELECT * FROM " . $table;
		$rs = mysqli_query($this->db, $query);
		if($rs){
			//$rows = mysqli_fetch_assoc($rs);
			//return $rows;
			return $rs;
		}
	}
	//데이터 검색
	function data_search($table, $searchrow, $row, $var) {
		$rows = mysqli_fetch_all($this->Dbresult($table, $row, $var, $searchrow));
		
		if (empty($rows))
			return false;
			else
				return $rows[0][0];
	}
}
?>