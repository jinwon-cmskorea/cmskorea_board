<?php
    /**
     * @brief 로그인 기능 
     * 
     */
    session_start();
    
    include dirname(__DIR__) . '/dbCon.php';
    include dirname(__DIR__) . '/var/errMessage.php';
    
    $userID = $_POST['userID'];
    $userPW = $_POST['userPW'];

    if (!$userID) {
        errMessage("아이디를 입력해주세요.");
    } else if (!$userPW) {
        errMessage("비밀번호를 입력해주세요.");
    }
    
    $sql = $con->prepare("
        SELECT * FROM member where id = :userID
    ");
    $sql->bindParam(':userID', $userID);
    $sql->execute();
    $res = $sql->fetch();

    if (!isset($res['id'])) {
        errMessage("존재하지 않는 아이디입니다.");
    } else if (md5($userPW) != $res['pw']) {
        errMessage("비밀번호가 일치하지 않습니다.");
    } else if (!isset($res)) {
        errMessage("로그인 중 에러가 발생했습니다. 관리자에게 문의하십시오.");
    } else {
        $_SESSION['userId'] = $res['id'];
        $_SESSION['userName'] = $res['name'];
    }