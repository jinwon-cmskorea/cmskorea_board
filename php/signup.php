<?php
    /***
     * @brief 회원가입 페이지 동작 코드
     */
    require dirname(__DIR__) . '/dbCon.php';
    require dirname(__DIR__) . '/var/errMessage.php';
    
    $userId = $_POST['userId'];
    $userPw = $_POST['userPw'];
    $userName = $_POST['userName'];
    $userPhone = $_POST['userPhone'];
    
    /* 요구 입력값을 미입력 했을 시, 또는 형식을 지키지 않았으면 에러 출력후 이전 페이지 복귀 */
    if (!$userId) {
        errMessage("아이디를 입력해주세요.");
    } else if (!$userPw) {
        errMessage("비밀번호를 입력해주세요.");
    } else if (!$userName) {
        errMessage("이름를 입력해주세요.");
    } else if (!$userPhone) {
        errMessage("휴대전화 번호를 입력해주세요.");
    } else if (!ctype_alnum($userId) | !ctype_alnum($userPw)) {
        errMessage("아이디 또는 비밀번호 형식을 지켜주세요.");
    }
    
    /* mysqli_real_escape_string 함수를 이용해 필터링 작업 */
    $filtered = array(
        'fUserId' => mysqli_real_escape_string($con, $userId),
        'fUserPw' => mysqli_real_escape_string($con, $userPw),
        'fUserName' => mysqli_real_escape_string($con, $userName),
        'fUserPhone' => mysqli_real_escape_string($con, $userPhone)
    );
    
    /*
     * 입력된 비밀번호 암호화 및 현재시각 저장
     * insert 문 실행 후, 에러가 발생하면 경고창 출력
     * 정상적으로 처리되었으면 완료 알림 출력 후 로그인 페이지로 이동
     */
    $md5Pw = md5($filtered['fUserPw']);
    $time = date("Y-m-d H:i:s");
    $sql = "INSERT INTO member VALUES('{$filtered['fUserId']}', '{$md5Pw}', '{$filtered['fUserName']}', '{$filtered['fUserPhone']}', '{$time}')";
    $resultSet = mysqli_query($con, $sql);
    if (!$resultSet) {
        errMessage("회원가입 중 에러가 발생했습니다. 관리자에게 문의하십시오.");
    } else {
        echo "<script type=\"text/javascript\">alert('회원가입이 완료되었습니다!');</script>";
        echo "<script type=\"text/javascript\">document.location.href='../html/login.html';</script>";
    }
    
    