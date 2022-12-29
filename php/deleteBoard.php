<?php 
    header("Content-Type: application/json");//json 을 사용하기 위해 필요한 구문

    require dirname(__DIR__) . '/dbCon.php';
    require dirname(__DIR__) . '/var/errMessage.php';
    
    if (!isset($_SESSION['userId'])) {
        echo "<script type=\"text/javascript\">alert('로그인을 먼저 해주세요.');</script>";
        echo "<script type=\"text/javascript\">document.location.href='./login.php';</script>";
    }
    
    if (isset($_POST['no']) && $_POST['no']) {
        $fNo = mysqli_real_escape_string($con, $_POST['no']);
    }
    $sql = "DELETE FROM board WHERE no='{$fNo}'";

    $result = mysqli_query($con, $sql);
    if ($result) {
        $status = 1;
    } else {
        $status = 0;
    }
    $receive = array("status" => $status);
    /*
     * 결과를 json으로 반환
     */
    echo json_encode($receive, JSON_UNESCAPED_UNICODE);
