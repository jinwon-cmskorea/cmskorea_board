<?php 
    require dirname(__DIR__) . '/dbCon.php';
    require dirname(__DIR__) . '/var/errMessage.php';
    session_start();
    
    /* 로그인하지 않았다면 로그인 페이지로 이동 */
    if (!isset($_SESSION['userId'])) {
        errMessage("로그인을 먼저 해주세요.");
        echo "<script type=\"text/javascript\">document.location.href='../html/login.html';</script>";
    }
    
    /*
     * 검색 관련 코드(검색 눌렀을 경우 작동)
     * 검색값이 존재하면 변수 저장
     */
    if (isset($_GET['category']) && $_GET['category'] && isset($_GET['search']) && $_GET['search']) {
        $category = $_GET['category'];
        $search = $_GET['search'];
    }
    
    /*
     * 페이징 관련 코드
     * 1. 레코드 갯수 확인
     */
    if (isset($_GET['page']) && $_GET['page']) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }
    
    if (isset($category) && isset($search) && $category && $search) {
        $pageSql = "SELECT * FROM board WHERE {$category} LIKE '%{$search}%'";
    } else {
        $pageSql = "SELECT * FROM board";
    }
    $pageRes = mysqli_query($con, $pageSql);
    $totalRow = mysqli_num_rows($pageRes);
    
    /* 2. 페이징 계산 */
    $per = 10;
    $start = ($page - 1) * $per + 1;
    $start -= 1;
    
    /* default 필드 네임 지정 */
    $fieldName = "no";
    
    /* 
     * 어떤 정렬을 할것인지, 어떤 헤더필드에 적용할 것인지
     * get으로 받아온 내용을 변수에 저장
     */
    if (isset($_GET['order']) && $_GET['order']) {
        $order = $_GET['order'];
        if ($order == "DESC") {
            $temp = "▼";
        } else {
            $temp = "▲";
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
    
    /* 
     * 게시글을 불러오기 위한 select 문
     * 검색 유무에 따라 다른 sql 실행
     */
    if (isset($category) && isset($search)) {
        $sql = "SELECT * FROM board WHERE {$category} LIKE '%{$search}%' ORDER BY {$fieldName} {$order} LIMIT {$start}, {$per}";
    } else {
        $sql = "SELECT * FROM board ORDER BY {$fieldName} {$order} LIMIT {$start}, {$per}";
    }
    
    $result = mysqli_query($con, $sql);
    
    /*
     * 어떤 정렬을 할것인지, 어떤 헤더필드에 적용할 것인지
     * 테이블 헤더 눌렀을 경우, 해당 요소의 내용 변경
     */
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
    <script src="../jQuery/jquery-3.6.3.min.js" type="text/javascript"></script>
    <script src="../bootstrap-3.3.2-dist/js/bootstrap.js" type="javascript"></script>
    <title>게시글 리스트</title>
    <script type="text/javascript">
        /*
            게시글 생성 후 alert 띄우기
            이후 get 파라미터들 지우기(계속 alert 뜨는 것을 방지하기 위해서)
        */
        window.onload = function(){
            const urlStr = window.location.href;//현재 페이지 url 얻기
            const url = new URL(urlStr);
            
            const urlParams = url.searchParams;//얻어온 url의 파라미터들 획득
            const tag = urlParams.get('message');//파라미터의 특정 값 획득. 여기선 succes 획득
            
            if (tag == "success") {
                alert("게시글이 생성되었습니다.");
                history.replaceState({}, null, location.pathname); //정규 주소 빼고 파라미터들 삭제
            }
        }
        
        $(document).ready(function() {
            $(document).on('click', '.btn-delete', function(){
                var no = $(this).data('no');//data-no 의 값을 저장
                
                if (confirm("게시글을 삭제하시겠습니까?")) {
                    $.ajax ({
                        url: "./deleteBoard.php",
                        method: "POST",
                        data: {"no":no},//자바 스크립트 객체 형태로 전달
                        dataType: "json",
                        success: function(receive) {
                            if (receive.status == 1) {//php로부터 json을 받아오고, 조건문에 따라 비교
                                alert("게시글이 삭제되었습니다.");
                                window.location.reload();
                            } else {
                                alert("삭제 중 문제가 발생했습니다.");
                           	}
                        },
                        error: function() {
                            alert("삭제 중 문제가 발생했습니다.");
                        }
                    });
                }
            });
        });
        
        function sortTable(fieldName) {
            var fieldName = fieldName;
            var order = "<?php echo $order == "DESC" ? "ASC" : "DESC";?>";
            <?php if (isset($category) && isset($search)) { ?>
                window.location.href = "<?php echo $urlArr[0]."&".$urlArr[1]."&".$urlArr[2]; ?>" + "&orderField=" + fieldName + "&order=" + order;
            <?php } else { ?>
                window.location.href = "http://localhost/cmskorea_board/php/boardList.php?page=<?php echo $page;?>&orderField=" + fieldName + "&order=" + order;
            <?php }?>
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
            <form class="col-sm-6" action="./boardList.php" method="get">
                <input type="hidden" name="page" value="1" />
                <select class="selectbox" id="category" name="category">
                    <option value="writer" <?php echo (isset($category) && $category == 'writer') ? 'selected' : ''; ?>>작성자</option>
                    <option value="title" <?php echo (isset($category) && $category == 'title') ? 'selected' : ''; ?>>제목</option>
                    <option value="insertTime" <?php echo (isset($category) && $category == 'insertTime') ? 'selected' : ''; ?>>작성일자</option>
                </select>
                <input class="s-input" type="text" name="search" autocomplete="off" value="<?php echo (isset($search) && $search) ? $search : ''; ?>">
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
                            <input class="btn del-btn btn-delete" name="delete-btn" type="button" value="삭제" data-no="<?php echo $row['no']; ?>">
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
                <?php 
                    /* 가장 최근에 작성된 페이지로 이동하기 */
                    if ($page > 1) {
                        if (isset($category) && isset($search)) {
                            echo "
                                <li>
                                    <a href=\"boardList.php?page=1&category={$category}&search={$search}&orderField={$fieldName}&order={$order}\" aria-label=\"Previous\">
                                        <span aria-hidden=\"true\">&laquo;</span>
                                    </a>
                                </li>
                            ";
                        } else {
                            echo "
                                <li>
                                    <a href=\"boardList.php?page=1&orderField={$fieldName}&order={$order}\" aria-label=\"Previous\">
                                        <span aria-hidden=\"true\">&laquo;</span>
                                    </a>
                                </li>
                            ";
                        }
                    } else {
                        echo "
                            <li class=\"disabled\">
                                <a href=\"#\" aria-label=\"Previous\">
                                    <span aria-hidden=\"true\">&laquo;</span>
                                </a>
                            </li>
                        ";
                    }
                    
                    $totalPage = ceil($totalRow / $per);
                    $pageNum = 1;
                    
                    while ($pageNum <= $totalPage) {
                            if (isset($category) && isset($search)) {
                                $urlStr = basename($_SERVER[ "PHP_SELF" ])."?page={$pageNum}&category={$category}&search={$search}";
                            } else {
                                $urlStr = basename($_SERVER[ "PHP_SELF" ])."?page={$pageNum}";
                            }
                            
                            if ($page == $pageNum) {
                                echo "<li class=\"active\"><a href=\"{$urlStr}&orderField={$fieldName}&order={$order}\">$pageNum</a></li>";
                            } else {
                                echo "<li><a href=\"{$urlStr}&orderField={$fieldName}&order={$order}\">$pageNum</a></li>";
                            }
                        $pageNum++;
                    }
                    
                    /* 가장 처음 작성된 페이지로 이동 */
                    if($page < $totalPage) {
                        if (isset($category) && isset($search)) {
                            echo "
                                <li>
                                    <a href=\"boardList.php?page={$totalPage}&category={$category}&search={$search}&orderField={$fieldName}&order={$order}\" aria-label=\"Previous\">
                                        <span aria-hidden=\"true\">&raquo;</span>
                                    </a>
                                </li>
                            ";
                        } else {
                            echo "
                                <li>
                                    <a href=\"boardList.php?page={$totalPage}&orderField={$fieldName}&order={$order}\" aria-label=\"next\">
                                        <span aria-hidden=\"true\">&raquo;</span>
                                    </a>
                                </li>
                            ";
                        }
                    } else {
                        echo "
                            <li class=\"disabled\">
                                <a href=\"#\" aria-label=\"next\">
                                    <span aria-hidden=\"true\">&raquo;</span>
                                </a>
                            </li>
                        ";
                    }
                ?>
            </ul>
        </div>
        <!-- 페이징 버튼 끝 -->
    </div>
    <!-- 검색, 작성, 게시글 리스트, 페이징 등 끝 -->
</body>
</html>