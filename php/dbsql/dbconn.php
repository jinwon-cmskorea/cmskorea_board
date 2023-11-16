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
function data_search($sql, $table, $row, $var) {
	$query = "SELECT * FROM " . $table . " where " . $row . "='" . $var . "';";
	$rs = mysqli_query($sql, $query);
	
	$num_record=mysqli_num_rows($rs);
	// 	$rows = mysqli_fetch_all($rs);
	
	// 	echo "<pre>";
	// 	var_dump($rows);
	// 	echo "</pre>";
	// 	return $rows;
	return $num_record;
};
//data_list(connetDB(), "test")
?>