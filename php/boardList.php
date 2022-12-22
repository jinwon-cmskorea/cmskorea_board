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
    <?php include_once dirname(__DIR__) . '/html/commonHeader.html';?>
    <div class="col-sm-12">
        <div class="list-title">
            <strong>씨엠에스코리아 게시판</strong>
            <small>- 리스트 -</small>
        </div>
        <div class="col-sm-12 list-descript">
            등록 된 게시글을 조회하는 페이지입니다.<br>
            등록 된 글은 조회, 수정, 삭제할 수 있습니다.
        </div>
    </div>
    <!-- 상단 끝 -->
    <!-- 검색, 작성, 게시글 리스트, 페이징 등  -->
    <div class="col-sm-12 list-body">
        <!-- 검색 부분, 작성버튼 -->
        <div class=" board-upper">
            <form class="col-sm-6" action="" method="get">
                <select class="selectbox" id="category" name="category">
                    <option value="writer">작성자</option>
                    <option value="title">제목</option>
                    <option value="date">작성일자</option>
                </select>
                <input class="s-input" type="text" autocomplete="off" required>
                <input class="btn s-button" type="submit" value="검색">
            </form>
            <div>
                <input class="btn bg-primary write-btn" type="button" value="작    성">
            </div>
        </div>
        <!-- 검색 부분, 작성버튼 끝-->
        <!-- 게시글 리스트 테이블  -->
        <table class="table table-hover">
            <thead class="add-top-line">
                <tr>
                    <th class="col-sm-1">번호</th>
                    <th class="col-sm-7" style="text-align: center;">제목</th>
                    <th class="col-sm-1">작성자</th>
                    <th class="col-sm-1">작성일자</th>
                    <th class="col-sm-2" style="text-align: center;">작업</th>
                </tr>
            </thead>
            <tbody class="add-bottom-line">
                <tr>
                    <td>10000</td>
                    <td>테스트용 항목입니다.</td>
                    <td>홍길동</td>
                    <td>22.12.22</td>
                    <td>
                        <div style="text-align: center;">
                            <input class="btn view-btn" type="button" value="조회">
                            <input class="btn del-btn" type="button" value="삭제">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>20000</td>
                    <td>테스트용 항목입니다2.</td>
                    <td>으아악</td>
                    <td>22.12.22</td>
                    <td>
                        <div style="text-align: center;">
                            <input class="btn view-btn" type="button" value="조회">
                            <input class="btn del-btn" type="button" value="삭제">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- 게시글 리스트 테이블 끝 -->
        <!-- 페이징 버튼 -->
        <div class="text-center">
            <ul class="pagination page-center">
                <li><a>first</a></li>
                <li class="active"><a>1</a></li>
                <li><a>2</a></li>
                <li><a>3</a></li>
                <li><a>last</a></li>
            </ul>
        </div>
        <!-- 페이징 버튼 끝 -->
    </div>
    <!-- 검색, 작성, 게시글 리스트, 페이징 등 끝 -->
</body>
</html>