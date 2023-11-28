<?php
require_once "../dbcontroller.php";
if(!session_id()) {
	session_start();
}

function write_post(){
	$writeTitle = $_POST['writeTitle'];
	$writeContent = $_POST['writeContent'];
	$writer = $_POST['writer'];
	
	$boardDBclass = new DBconn();
	$iferror = $boardDBclass->post_write_set($writeTitle, $writeContent, $writer);
	if(isset($iferror)){
		echo $iferror;
	}
}
function view_post(){
	$viewPk = $_POST['viewPk'];
	
	$boardDBclass = new DBconn();
	$row = $boardDBclass->getDbData("board", "pk", $viewPk, "*");
	echo json_encode($row);
}
function update_post(){
	$viewPk = $_POST['viewPk'];
	$updateTitle = $_POST['updateTitle'];
	$updateContent = $_POST['updateContent'];
	$updateWriter = $_POST['updateWriter'];
	
	$boardDBclass = new DBconn();
	
	$iferror = $boardDBclass->post_update_set($viewPk, $updateTitle, $updateContent, $updateWriter);
	if(isset($iferror)){
		echo $iferror;
	}
}


function delete_post(){
	$deletePk = $_POST['deletePk'];
	$boardDBclass = new DBconn();
	$iferror = $boardDBclass->getDbDelete("board", "pk", $deletePk);
	if(isset($iferror)){
		echo $iferror;
	}
}
if(isset($_POST['call_name'])){
$call_name = $_POST['call_name'];
call_user_func($call_name);
}else{echo "전달 받은 값이 없습니다!";}
?>