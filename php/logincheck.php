        <?php 
include '../php/dbsql/dbconn.php';
if(!session_id()) {
	session_start();
}

$loginId = $_POST['name'];
$loginPw = $_POST['password'];

$md5Pw = md5($loginPw);

$searchId =data_search( "auth_identity", "id","id", $loginId);
$searchPw = data_search( "auth_identity", "pw", "pw", $md5Pw); 

$searchIdPw = data_search( "auth_identity", "pw", "id", $loginId); 


// echo bin2hex($loginPw). "-입력 비번값변환 "; 
// echo hex2bin($searchPw). "-입력 비번값변환 ";

if($searchId === $loginId && $searchPw === $md5Pw ) {
	$_SESSION['userName'] = $loginId;
	echo ("<script>location.replace('../web/board/boardlist.php?page=1');</script>");
} elseif(!($searchId === $loginId)) {
	echo( "<script>alert('아이디가 존재하지 않습니다!');</script>");
	echo("<script>location.replace('../web/login.php');</script>");
} elseif(!($searchIdPw === $loginId)) {
	echo( "<script>alert('비밀번호가 일치하지 않습니다!');</script>");
	echo("<script>location.replace('../web/login.php');</script>");
}
?>