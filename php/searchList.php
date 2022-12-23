<?php 
    require dirname(__DIR__) . '/dbCon.php';
    require dirname(__DIR__) . '/var/errMessage.php';
    session_start();
    
    /* 검색 기능을 위한 작업 */
    $category = $_GET['category'];
    $search = $_GET['search'];
    
    /* 로그인하지 않았다면 로그인 페이지로 이동 */
    if (!isset($_SESSION['userId'])) {
        errMessage("로그인을 먼저 해주세요.");
        echo "<script type=\"text/javascript\">document.location.href='../html/login.html';</script>";
    }
    
    /* default 필드 네임 지정 */
    $fieldName = "no";
    
    /* 
     * 어떤 정렬을 할것인지, 어떤 헤더필드에 적용할 것인지
     * get으로 받아온 내용을 변수에 저장
     */
    if (isset($_GET['order']) && $_GET['order']) {
        $order = $_GET['order'];
        if ($order == "DESC") {
            $order = "ASC";
            $temp = "▲";
        } else {
            $order = "DESC";
            $temp = "▼";
        }
    } else {
        $order = "DESC";
        $temp = "▼";
    }
    
    if (isset($_GET['orderField']) && $_GET['orderField']) {
        $fieldName = $_GET['orderField'];
    }
    
    /* 현재 url 저장 */
    $present = basename( $_SERVER["PHP_SELF"])."?".$_SERVER["QUERY_STRING"];
    $urlArr = explode("&", $present);
    
    /* 게시글을 불러오기 위한 select 문 */
    $sql = "SELECT * FROM board WHERE {$category} LIKE '%{$search}%' ORDER BY {$fieldName} {$order}";
    
    $result = mysqli_query($con, $sql);
    
    echo "
        <script type=\"text/javascript\">
            document.addEventListener(\"DOMContentLoaded\", function(){
                var element = document.getElementById(\"{$fieldName}\");
                var fieldText = element.innerText + ' '  + \"{$temp}\";
                element.innerText = fieldText;
            });
        </script>
    ";
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
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(){
        });
        function sortTable(fieldName) {
            var fieldName = fieldName;
            var order = "<?php echo $order;?>";
            //window.location.href = "http://localhost/cmskorea_board/php/boardList.php?orderField=" + fieldName + "&order=" + order;
            window.location.href = "<?php echo $urlArr[0]."&".$urlArr[1] ?>" + "&orderField=" + fieldName + "&order=" + order;
        }
    </script>
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
                    <option value="insertTime">작성일자</option>
                </select>
                <input class="s-input" type="text" name="search" autocomplete="off" required><?php $search; ?></input>
                <input class="btn s-button" type="submit" value="검색">
            </form>
            <div>
                <input class="btn bg-primary write-btn" type="button" onclick="location.href='./writeBoard.php';" value="작    성">
            </div>
        </div>
        <!-- 검색 부분, 작성버튼 끝-->
        <!-- 게시글 리스트 테이블  -->
        <table class="table table-hover">
            <thead class="add-top-line">
                <tr>
                    <th class="col-sm-1" id="no" onclick="sortTable('no')" style="cursor: pointer;">번호</th>
                    <th class="col-sm-7" id="title" onclick="sortTable('title')" style="text-align: center; cursor: pointer;">제목</th>
                    <th class="col-sm-1" id="writer" onclick="sortTable('writer')" style="cursor: pointer;">작성자</th>
                    <th class="col-sm-1" id="insertTime" onclick="sortTable('insertTime')" style="cursor: pointer;">작성일자</th>
                    <th class="col-sm-2" style="text-align: center;">작업</th>
                </tr>
            </thead>
            <tbody class="add-bottom-line">
                <?php
                    /*  */
                    while ($row = mysqli_fetch_array($result)) {
                        $ymd = substr($row['insertTime'], 0, 10);
                ?>
                <tr>
                    <td><?php echo $row['no']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['writer']; ?></td>
                    <td><?php echo $ymd; ?></td>
                    <td>
                        <div style="text-align: center;">
                            <input class="btn view-btn" type="button" value="조회">
                            <input class="btn del-btn" type="button" value="삭제">
                        </div>
                    </td>
                </tr>
                <?php
                    }
                ?>
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