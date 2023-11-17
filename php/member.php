<?php

include 'dbsql/dbconn.php';

function insert_member($sql){
	$inputId = $_POST['memberId'];
	$inputPw = $_POST['memberPw'];
	$inputName = $_POST['memberName'];
	$inputTel = $_POST['memberTel'];
	
	$binary = bin2hex($inputPw);
	
	$query = "INSERT INTO member ( id, name, telNumber, insertTime, updateTime) VALUE( '". $inputId."' ,'". $inputName."' ,'". $inputTel."' , now(), now());";
	$rs = mysqli_query($sql, $query);
	if (!$rs) {
		//echo "등록실패 : " . mysqli_error($sql);
	}
	$query = "INSERT INTO auth_identity ( id, pw, name, insertTime) VALUE( '". $inputId ."' ,'". $binary ."' ,'". $inputName."' , now());";
	$rs = mysqli_query($sql, $query);
	
	if (!$rs) {
		//echo "등록실패 : " . mysqli_error($sql);
	}
}



//$call_name = $_POST['call_name'];
//switch ($call_name){
//	case  "insert_member":
	insert_member(connetDB());
	?><script>alert('회원 가입이 완료되었습니다!');</script>")
	<script>location.href = '../web/login.php';</script><?php
//	break;
//}

?>