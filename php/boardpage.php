<?php
include 'dbsql/dbconn.php';
/*---------페이징 코드 -> 코드 이해하고 board에 적용할 방법 생각하기-----------------------*/

/* paging : 한 페이지 당 데이터 개수 */
$list_num = 10;

/* paging : 한 블럭 당 페이지 수 */
$page_num = 5;
$num = 23;
/* paging : 현재 페이지 */
$page = isset($_GET["page"])? $_GET["page"] : 1;

/* paging : 전체 페이지 수 = 전체 데이터 / 페이지당 데이터 개수, ceil : 올림값, floor : 내림값, round : 반올림 */
$total_page = ceil($num / $list_num);
// echo "전체 페이지 수 : ".$total_page;

/* paging : 전체 블럭 수 = 전체 페이지 수 / 블럭 당 페이지 수 */
$total_block = ceil($total_page / $page_num);

/* paging : 현재 블럭 번호 = 현재 페이지 번호 / 블럭 당 페이지 수 */
$now_block = ceil($page / $page_num);

/* paging : 블럭 당 시작 페이지 번호 = (해당 글의 블럭번호 - 1) * 블럭당 페이지 수 + 1 */
$s_pageNum = ($now_block - 1) * $page_num + 1;
// 데이터가 0개인 경우
if($s_pageNum <= 0){
	$s_pageNum = 1;
};

/* paging : 블럭 당 마지막 페이지 번호 = 현재 블럭 번호 * 블럭 당 페이지 수 */
$e_pageNum = $now_block * $page_num;
// 마지막 번호가 전체 페이지 수를 넘지 않도록
if($e_pageNum > $total_page){
	$e_pageNum = $total_page;
};

/* paging : 시작 번호 = (현재 페이지 번호 - 1) * 페이지 당 보여질 데이터 수 */
$start = ($page - 1) * $list_num;

/* paging : 쿼리 작성 - limit 몇번부터, 몇개 */
$sql = "select * from members limit $start, $list_num;";

/* paging : 쿼리 전송 */
$result = mysqli_query(connetDB(), $sql);

/* paging : 글번호 */
$cnt = $start + 1;

while($array = mysqli_fetch_array($result)){
	?>
        <tr class="brd">
            <!-- <td><?php echo $i; ?></td> -->
            <td><?php echo $cnt; ?></td>
            <td><?php echo $array["u_name"]; ?></td>
            <td><?php echo $array["u_id"]; ?></td>
            <td><?php echo $array["birth"]; ?></td>
            <td><?php echo $array["postalCode"]." ".$array["add1"]." ".$array["add2"]; ?></td>
            <td><?php echo $array["email"]; ?></td>
            <td><?php echo $array["mobile"]; ?></td>
            <td><?php echo $array["reg_date"]; ?></td>
            <td><a href="edit.php?u_idx=<?php echo $array["idx"]; ?>">수정</a></td>
            <td><a href="#" onclick="del_check(<?php echo $array["idx"]; ?>)">삭제</a></td>
        </tr>
        <?php  
            /* $i++; */
            /* paging */
            $cnt++;
        }; 
?>

<p class="pager">

    <?php
    /* paging : 이전 페이지 */
    if($page <= 1){
    ?>
    <a href="boardpage.php?page=1">이전</a>
    <?php } else{ ?>
    <a href="boardpage.php?page=<?php echo ($page-1); ?>">이전</a>
    <?php };?>

    <?php
    /* pager : 페이지 번호 출력 */
    for($print_page = $s_pageNum; $print_page <= $e_pageNum; $print_page++){
    ?>
    <a href="boardpage.php?page=<?php echo $print_page; ?>"><?php echo $print_page; ?></a>
    <?php };?>

    <?php
    /* paging : 다음 페이지 */
    if($page >= $total_page){
    ?>
    <a href="list.php?page=<?php echo $total_page; ?>">다음</a>
    <?php } else{ ?>
    <a href="list.php?page=<?php echo ($page+1); ?>">다음</a>
    <?php };?>

</p>