<?php 
    /***
     * @brief 게시글 수정 코드
     */
    
    session_start();
    
    require dirname(__DIR__) . '/dbCon.php';
    require dirname(__DIR__) . '/var/errMessage.php';
    
    if (!isset($_SESSION['userId'])) {
        errMessage("로그인을 먼저 해주세요.");
    } else if (!$_POST['title'] || !$_POST['content'] || !$_POST['writer']) { 
        errMessage("제목, 내용, 작성자 모두 입력해주세요.");
    } else {
        $fTitle = mysqli_real_escape_string($con, $_POST['title']);
        $fContent = mysqli_real_escape_string($con, $_POST['content']);
        $fWriter = mysqli_real_escape_string($con, $_POST['writer']);
        $fNo = mysqli_real_escape_string($con, $_POST['no']);
        
        $sql = "UPDATE board SET title='{$fTitle}', content='{$fContent}', writer='{$fWriter}' WHERE no='{$fNo}'";
        $result = mysqli_query($con, $sql);
        if ($result) {
            echo "<script type=\"text/javascript\">location.href='./viewBoard.php?no={$fNo}&message=edit'</script>";
        } else {
            echo "수정 중에 문제가 발생했습니다. : " . mysqli_error($con);
        }
    }