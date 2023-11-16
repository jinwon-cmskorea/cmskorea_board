<?php 
include 'dbsql/dbconn.php';
if(!session_id()) {
	session_start();
}

$loginId = $_POST['name'];
$loginPw = $_POST['password'];
//$binary = bin2hex($loginPw);
//echo( "<script>alert('$loginPw');</script>");
//echo( "<script>alert('$binary');</script>");
if(data_search(connetDB(), "member", "id", $loginId) /*&& data_search(connetDB(), "auth_identity", "pw", $loginPw)*/){
	$_SESSION['userName'] = $loginId;
	echo ("<script>location.replace('../html/board/boardlist.html?page=1');</script>");
	
}elseif(!(data_search(connetDB(), "member", "id", $loginId))) {
	echo( "<script>alert('아이디가 존재하지 않습니다!');</script>");
	echo("<script>location.replace('../html/login.html');</script>");
}
/* else if(!(data_search(connetDB(), "auth_identity", "pw", $loginPw))) {
	echo( "<script>alert('비밀번호가 일치하지 않습니다!');</script>");
	echo("<script>location.replace('../html/login.html');</script>");
} */

?>