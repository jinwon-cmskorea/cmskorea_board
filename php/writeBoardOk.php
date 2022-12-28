<?php
    /**
     * @brief 게시글 작성 기능
     */
    session_start();
    
    require dirname(__DIR__) . '/dbCon.php';
    require dirname(__DIR__) . '/var/errMessage.php';
    
    if (!isset($_SESSION['userId'])) {
        errMessage("로그인을 먼저 해주세요.");
        echo "<script type=\"text/javascript\">document.location.href='../html/login.html';</script>";
    } else if (!$_POST['title'] || !$_POST['content'] || !$_POST['writer']) {
        errMessage("제목, 내용, 작성자 모두 입력해주세요.");
    } else {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $writer = $_POST['writer'];
        
        $sql = "INSERT INTO board(title, writer, content, insertTime) VALUES ('{$title}', '{$writer}', '{$content}', now())";
        $result = mysqli_query($con, $sql);
        if ($result) {
            echo "<script type=\"text/javascript\">document.location.href='./boardList.php?message=success';</script>";
        } else {
//             errMessage("게시글 작성 중 문제가 발생했습니다.");
            echo mysqli_error($con);
        }
    }