<?php 
    require dirname(__DIR__) . '/dbCon.php';
    require dirname(__DIR__) . '/var/errMessage.php';
    session_start();
    
    /* 로그인하지 않았다면 로그인 페이지로 이동 */
    if (!isset($_SESSION['userId'])) {
        errMessage("로그인을 먼저 해주세요.");
        echo "<script type=\"text/javascript\">document.location.href='../html/login.html';</script>";
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
    <title>게시글 리스트</title>
</head>
<body>
<!--     <div class="menubar"> -->
<!--         <div class="menutitle">CMSKOREA Board</div> -->
<!--         <div class="info-group"> -->
<!--            <div class="user-info"><?= $_SESSION['userName']?></div> -->
<!--            <input class="btn logout-btn" type="button" value="로그아웃" onclick="location.href='./logout.php'">  -->
<!--         </div> -->
<!--     </div> -->
    <?= include_once dirname(__DIR__) . '/html/commonHeader.html';?>
</body>
</html>