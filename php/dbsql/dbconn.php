<?php 

function connetDB(){
	$mysql = mysqli_connect('localhost', 'root', 'cmskorea', 'dbboard');
	
	if ($mysql) {
		//echo "DB연결 성공";
		return $mysql;
	} else {
		//echo "DB연결 실패 : " . mysqli_error($mysql);
		return false;
	};
}

function data_list($sql, $table) {
	$query = "SELECT * FROM " . $table;
	$rs = mysqli_query($sql, $query);
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
};
function data_search($sql, $table, $searchrow, $row, $var) {
	$query = "SELECT " . $searchrow . " FROM " . $table . " where " . $row . "='" . $var . "';";
	$rs = mysqli_query($sql, $query);
	
//	$num_record=mysqli_num_rows($rs);
	$rows = mysqli_fetch_all($rs);
/* 	echo $query;
 	echo "<pre>";
	var_dump($rows);
	echo "</pre>"; */
	//return $rows;
	 
	
	if (empty($rows))
		return false;
	else
		return $rows[0][0];
};
//data_list(connetDB(), "test")
?>