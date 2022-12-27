<?php 
    header("Content-Type: application/json");//json 을 사용하기 위해 필요한 구문

    require dirname(__DIR__) . '/dbCon.php';
    require dirname(__DIR__) . '/var/errMessage.php';

    
    if (isset($_POST['no']) && $_POST['no'])
        $no = $_POST['no'];
    
    $sql = "DELETE FROM board WHERE no={$no}";

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
