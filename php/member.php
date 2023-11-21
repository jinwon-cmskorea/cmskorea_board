<?php

include 'dbsql/dbconn.php';

function insert_member(){
	$inputId = $_POST['memberId'];
	$inputPw = $_POST['memberPw'];
	$inputName = $_POST['memberName'];
	$inputTel = $_POST['memberTel'];
	
// 	$binary = bin2hex($inputPw);
    //$normal = $inputPw;
    
	$query = "INSERT INTO member ( id, name, telNumber, insertTime, updateTime) VALUE( '". $inputId."' ,'". $inputName."' ,'". $inputTel."' , now(), now());";
	$rs = mysqli_query(connetDB(), $query);
	if (!$rs) {
		//echo "등록실패 : " . mysqli_error($sql);
	}
	$query = "INSERT INTO auth_identity ( id, pw, name, insertTime) VALUE( '". $inputId ."' ,'". md5($inputPw) ."' ,'". $inputName."' , now());";
 	//$query = "INSERT INTO auth_identity ( id, pw, name, insertTime) VALUE( '". $inputId ."' ,'". $binary ."' ,'". $inputName."' , now());";
	//$query = "INSERT INTO auth_identity ( id, pw, name, insertTime) VALUE( '". $inputId ."' ,'". $normal ."' ,'". $inputName."' , now());";
	$rs = mysqli_query(connetDB(), $query);
	
	if (!$rs) {
		//echo "등록실패 : " . mysqli_error($sql);
	}
}



//$call_name = $_POST['call_name'];
//switch ($call_name){
//	case  "insert_member":
	insert_member();
	?><script>alert('회원 가입이 완료되었습니다!');</script>")
	<script>location.href = '../web/login.php';</script><?php
//	break;
//}

?>