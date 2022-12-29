<?php 
    /***
     * @brief 게시글 수정 php
     */
    require dirname(__DIR__) . '/dbCon.php';
    require dirname(__DIR__) . '/var/errMessage.php';
    session_start();
    
    /* 로그인하지 않았다면 로그인 페이지로 이동 */
    if (!isset($_SESSION['userId'])) {
        echo "<script type=\"text/javascript\">alert('로그인을 먼저 해주세요.');</script>";
        echo "<script type=\"text/javascript\">document.location.href='./login.php';</script>";
    }
    
    if (isset($_GET['no']) && $_GET['no']) {
        $no = $_GET['no'];
    }
    
    $sql = "SELECT * FROM board WHERE no={$no}";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $row = mysqli_fetch_array($result);
        
        $escapedTitle = htmlspecialchars($row['title']);
        $escapedContent = htmlspecialchars($row['content']);
        $escapedWriter = htmlspecialchars($row['writer']);
    } else {
        echo "수정 중 문제가 발생했습니다." . mysqli_error($con);
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
        <title>게시글 수정</title>
    </head>
    <body>
        <?php include_once dirname(__DIR__) . '/html/commonHeader.html';?>
        <!-- 상단 설명 -->
        <div class="col-sm-12">
            <div class="list-title">
                <strong>씨엠에스코리아 게시판</strong>
                <small class="small-ele">- 수정 -</small>
            </div>
            <div class="col-sm-12 list-descript">
                게시판 글을 수정합니다.
            </div>
        </div>
        <!-- 상단 설명 끝 -->
        <!-- 게시글 내용 작성 -->
        <div class="col-sm-10 col-sm-offset-1 list-body">
            <form class="form-horizontal" action="./editBoardOk.php" method="post">
                <div class="form-group">
                    <label for="inputTitle" class="col-sm-1 control-label-center">제   목</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control space-form" id="inputTitle" name="title" value="<?php echo $escapedTitle; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputContent" class="col-sm-1 control-label-center">내   용</label>
                    <div class="col-sm-11">
                        <textarea class="form-control space-form" rows="10" id="inputContent" name="content" required><?php echo $escapedContent; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputWriter" class="col-sm-1 control-label-center">작성자</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control space-form" id="inputWriter" name="writer" pattern="[가-힣]+" title="한글 이름만 가능합니다." value="<?php echo $escapedWriter; ?>" required>
                    </div>
                </div>
                <input type="hidden" name="no" value="<?php echo $row['no']; ?>">
                <div class="form-group">
                    <input type="submit" class="btn btn-warning col-sm-6 write-btn-style" value="수   정">
                    <input type="button" class="btn col-sm-6 cancle-btn write-btn-style" onclick="history.back(-1)" value="취소">
                </div>
            <form>
        </div>
        <!-- 게시글 내용 작성 끝 -->
    </body>
</html>