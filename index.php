<?php 
if(!session_id()) {
	session_start();
}
if(isset($_SESSION['userName'])){
	header("location:./web/board/boardlist.php");
}else{
	header("location:./web/login.php");
}
?>