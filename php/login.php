<meta charset="utf-8">
<?php 
include 'dbsql/dbconn.php';

$loginId = $_POST['name'];
$loginPw = $_POST['password'];

if(data_list_search(connetDB(), "member", "id", $loginId)){
	echo ("<script>location.replace('../html/board/boardlist.html');</script>");
}
else {
	echo( "<script>alert('아이디가 존재하지 않습니다!');</script>");
	echo("<script>location.replace('../html/login.html');</script>");

}

?>