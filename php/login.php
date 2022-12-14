<?php 
    session_start();
    
    if (isset($_SESSION['userId'])) {
        echo "<script type=\"text/javascript\">alert('이미 로그인하셨습니다.');</script>";
        echo "<script type=\"text/javascript\">document.location.href='./boardList.php';</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-3.3.2-dist/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="../css/style.css" type="text/css">
    <script src="../bootstrap-3.3.2-dist/js/bootstrap.js" type="javascript"></script>
    <title>로그인</title>
</head>
<body>
    <div class="container center">
        <div class="col-sm-6" style="background-color: rgb(231, 230, 230);">
	        <div class="text-center">
	            <div class="sep-line">
	               <strong>CMSKOREA Board</strong>
	            </div>
	            <div class="des-padding">아이디 / 비밀번호를 입력해 주세요.</div>
	        </div>
	        <form class="form-horizontal" action="./loginOk.php" method="post">
	            <div class="form-group">
	                <label for="inputId" class="col-sm-2 control-label-left">아이디</label>
	                <div class="col-sm-10">
	                    <input type="text" class="form-control" pattern="[A-Za-z0-9]+" id="inputId" name="userId">
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="inputPw" class="col-sm-2 control-label-left">비밀번호</label>
	                <div class="col-sm-10">
	                    <input type="password" class="form-control" id="inputPw" name="userPw">
	                </div>
	            </div>
	            <input type="submit" class="btn bg-primary btn-block" value="로그인">
	            <input type="button" class="btn col-sm-4 col-sm-offset-8 signup-btn" onclick="location.href='../html/signup.html';" value="회원가입">
	        </form>
        </div>
    </div>
</body>
</html>