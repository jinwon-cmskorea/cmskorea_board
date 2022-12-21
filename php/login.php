<?php
    /**
     * @brief 로그인 기능 
     * 
     */
    session_start();
    
    include dirname(__DIR__) . '/dbCon.php';
    include dirname(__DIR__) . '/var/errMessage.php';
    
    $userId = $_POST['userId'];
    $userPw = $_POST['userPw'];

    if (!$userId) {
        errMessage("아이디를 입력해주세요.");
    } else if (!$userPw) {
        errMessage("비밀번호를 입력해주세요.");
    }
    
    $filtered = array(
        'fUserId' => mysqli_real_escape_string($con, $userId),
        'fUserPw' => mysqli_real_escape_string($con, $userPw)
    );
    $sql = "SELECT * FROM member where id = '{$filtered['fUserId']}'";
    $resultSet = mysqli_query($con, $sql);
    if (!$resultSet) {
        errMessage("로그인 중 에러가 발생했습니다. 관리자에게 문의하십시오.");
    }
    $row = mysqli_fetch_array($resultSet);

    if (!isset($row['id'])) {
        errMessage("아이디가 일치하지 않습니다.");
    } else if (md5($filtered['fUserPw']) != $row['pw']) {
        errMessage("비밀번호가 일치하지 않습니다.");
    } else if (!isset($row)) {
        errMessage("로그인 중 에러가 발생했습니다. 관리자에게 문의하십시오.");
    } else {
        $_SESSION['userId'] = $row['id'];
        $_SESSION['userName'] = $row['name'];
        mysqli_close($con);
        
        header("Location: ../php/boardList.php");
    }