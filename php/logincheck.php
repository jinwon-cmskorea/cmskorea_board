<?php 
require_once "../dbcontroller.php";
if(!session_id()) {
	session_start();
}

$loginId = $_POST['name'];
$loginPw = $_POST['password'];

$md5Pw = md5($loginPw);

$logincheckDBclass = new DBconn();

if($logincheckDBclass->login_data_search($loginId, $md5Pw)) {
	$_SESSION['userName'] = $loginId;
	header("location:../web/board/boardlist.php");
} else{
	echo "<script>
			alert('아이디 또는 비밀번호가 일치하지 않습니다!');
			location.replace('../web/login.php');
		</script>";
}
?>