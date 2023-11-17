        <?php 
include '../php/dbsql/dbconn.php';
if(!session_id()) {
	session_start();
}

$loginId = $_POST['name'];
$loginPw = $_POST['password'];

$searchId =data_search(connetDB(), "auth_identity", "id","id", $loginId);
$searchPw = data_search(connetDB(), "auth_identity", "pw", "id",  $loginId); 

/* echo data_search(connetDB(), "member", "id","id", $loginId) . "-가져온아이디값  "; 
echo data_search(connetDB(), "auth_identity", "pw", "id",  $loginId ) . "-가져온비번값 "; 
echo $log;*/

/* 
echo bin2hex($loginPw). "-입력 비번값변환 "; 
echo hex2bin($searchPw). "-입력 비번값변환 "; 

echo strcmp($searchPw, bin2hex($loginPw)) . "확인";

if (strcasecmp($searchPw, bin2hex($loginPw)) == 0) {
	echo "(대소문자 무시하고) 같은 문자열입니다.<br />\n";
} else {
	echo "(대소문자 무시하고) 일치하지 않음.<br />\n";
} */
// 출력 결과: (대소문자 무시하고) 같은 문자열입니다.

if($searchId === $loginId) {
	$_SESSION['userName'] = $loginId;
	echo ("<script>location.replace('../web/board/boardlist.php?page=1');</script>");
} elseif(!($searchId === $loginId)) {
	echo( "<script>alert('아이디가 존재하지 않습니다!');</script>");
	echo("<script>location.replace('../web/login.php');</script>");
} 
/* if($searchId  == $loginId && (string)$searchPw == $loginPw ){
	$_SESSION['userName'] = $loginId;
	echo ("<script>location.replace('../web/board/boardlist.php?page=1');</script>");
	
}elseif(!($searchId === $loginId)) {
	echo( "<script>alert('아이디가 존재하지 않습니다!');</script>");
	echo("<script>location.replace('../web/login.php');</script>");
} 
else if(!((string)$searchPw  === $bin)) {
	echo( "<script>alert('비밀번호가 일치하지 않습니다!');</script>");
	echo("<script>location.replace('../web/login.php');</script>");
} */
?>