<?php 
    /***
     * @brief 게시글 조회 php
     */
    require dirname(__DIR__) . '/dbCon.php';
    require dirname(__DIR__) . '/var/errMessage.php';
    session_start();
    
    /* 로그인하지 않았다면 로그인 페이지로 이동 */
    if (!isset($_SESSION['userId'])) {
        errMessage("로그인을 먼저 해주세요.");
        echo "<script type=\"text/javascript\">document.location.href='../html/login.html';</script>";
    }
    
    if (isset($_GET['no']) && $_GET['no']) {
        $no = $_GET['no'];
    }
    
    $sql = "SELECT * FROM board WHERE no={$no}";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    
    $escapedTitle = htmlspecialchars($row['title']);
    $escapedContent = htmlspecialchars($row['content']);
    $escapedWriter = htmlspecialchars($row['writer']);
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
        <title>게시글 조회</title>
        <script type="text/javascript">
            /*
                게시글 수정 후 alert 띄우기
                이후 message 파라미터 지우기(계속 alert 뜨는 것을 방지하기 위해서)
            */
            window.onload = function(){
                const urlStr = window.location.href;//현재 페이지 url 얻기
                const url = new URL(urlStr);
                
                const urlParams = url.searchParams;//얻어온 url의 파라미터들 획득
                const tag = urlParams.get('message');//파라미터의 특정 값 획득. 여기선 edit 획득
                
                if (tag == "edit") {
                    alert("게시글이 수정되었습니다.");
                    var no = <?php echo $row['no']; ?>;//게시글 no 저장
                    history.replaceState({}, "", location.pathname + "?no=" + no); //정규 주소 및 no 파라미터를 제외하고 get 파라미터 제거
                }
            }
        </script>
    </head>
    <body>
        <?php include_once dirname(__DIR__) . '/html/commonHeader.html';?>
        <!-- 상단 설명 -->
        <div class="col-sm-12">
            <div class="list-title">
                <strong>씨엠에스코리아 게시판</strong>
                <small class="small-ele">- 조회 -</small>
            </div>
            <div class="col-sm-12 list-descript">
                게시판 글을 조회합니다.
            </div>
        </div>
        <!-- 상단 설명 끝 -->
        <!-- 게시글 조회 작성 -->
        <div class="view-box">
            <div class="page-header-custom">
                    <?php echo $escapedTitle; ?>
                    <div class="info">
                        <small class="space writer-info"><?php echo $escapedWriter; ?></small>
                        <small class="space"><?php echo $row['insertTime']; ?></small>
                    </div>
            </div>
            <div class="col-sm-12 text-box">
                <?php echo nl2br($escapedContent); ?>
            </div>
            <div class="col-sm-12">
                <input type="submit" class="btn btn-warning col-sm-6 write-btn-style" onclick="location.href='./editBoard.php?no=<?php echo $row['no']; ?>';" value="수   정">
                <input type="button" class="btn list-btn col-sm-6 write-btn-style" onclick="location.href='./boardList.php';" value="리스트">
            </div>
        </div>
        <!-- 게시글 내용 조회 끝 -->
    </body>
</html>