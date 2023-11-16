<?php
include 'dbsql/dbconn.php';
/*---------페이징 코드 -> 코드 이해하고 board에 적용할 방법 생각하기-----------------------*/

/* paging : 한 페이지 당 데이터 개수 */
$list_num = 10;

/* paging : 한 블럭 당 페이지 수 */
$page_num = 5;

/* 전체 데이터 개수 구하기*/
function table_row_count(){
	$query= "SELECT COUNT(*) FROM board;";
	$numsql = mysqli_query(connetDB(), $query);
	$num = mysqli_fetch_array($numsql);
	return $num[0];
}
/* paging : 현재 페이지 */
$page = isset($_GET['page'])? $_GET['page'] : 1;

/* paging : 시작 번호 = (현재 페이지 번호 - 1) * 페이지 당 보여질 데이터 수 */
$start = ($page - 1) * $list_num;


//$rows = mysqli_fetch_all($result);

/* echo "<pre>";
var_dump($rows);
echo "</pre>";
 */
function page_list($start_list, $last_list){
	$sql = "select * from board limit ". $start_list .",". $last_list. ";";
	$result = mysqli_query(connetDB(), $sql);
	$rows = array();
	while(!!($row = mysqli_fetch_assoc($result))) {
		$rows[] = $row;
	}
	$data = array();
	foreach($rows as $jb_row ) {
		$data[] = array(
				'pk'		=> $jb_row['pk'],
				'memberPk' 	=> $jb_row['memberPk'],
				'title'		=> $jb_row['title'],
				'writer'	 => $jb_row['writer'],
				'content'	 => $jb_row['content'],
				'views'		=> $jb_row['views'],
				'insertTime'=> $jb_row['insertTime'],
				'updateTime'=> $jb_row['updateTime'],
		);
		
	}
	echo json_encode($data);
}

function pagination($list, $page, $count){
	/* paging : 전체 페이지 수 = 전체 데이터 / 페이지당 데이터 개수, ceil : 올림값, floor : 내림값, round : 반올림 */
	$total_page = ceil($count / $list);
	// echo "전체 페이지 수 : ".$total_page;
	
	/* paging : 전체 블럭 수 = 전체 페이지 수 / 블럭 당 페이지 수 */
	$total_block = ceil($total_page / $page);
	
	
	/* paging : 현재 블럭 번호 = 현재 페이지 번호 / 블럭 당 페이지 수 */
	$now_block = ceil($page /  $page);
	
	/* paging : 블럭 당 시작 페이지 번호 = (해당 글의 블럭번호 - 1) * 블럭당 페이지 수 + 1 */
	$s_pageNum = ($now_block - 1) * $page + 1;
	// 데이터가 0개인 경우
	if($s_pageNum <= 0){
		$s_pageNum = 1;
	};
	
	/* paging : 블럭 당 마지막 페이지 번호 = 현재 블럭 번호 * 블럭 당 페이지 수 */
	$e_pageNum = $now_block *  $page;
	// 마지막 번호가 전체 페이지 수를 넘지 않도록
	if($e_pageNum > $total_page){
		$e_pageNum = $total_page;
	};
	
	$data[] = array(
		'total_page' => $total_page,
		'total_block' => $total_block,
		'now_block' => $now_block,
		's_pageNum' => $s_pageNum,
		'e_pageNum' => $e_pageNum,
	);
		
	echo json_encode($data);
}


function data_list_search($sql, $row, $var, $start_list, $last_list) {
	$query = "SELECT * FROM board where " . $row . " LIKE '%" . $var . "%'limit ". $start_list .",". $last_list. ";";
	$rs = mysqli_query($sql, $query);
	
	$data = array();
	foreach($rs as $jb_row ) {
		$data[] = array(
				'pk'		=> $jb_row['pk'],
				'memberPk' 	=> $jb_row['memberPk'],
				'title'		=> $jb_row['title'],
				'writer'	 => $jb_row['writer'],
				'content'	 => $jb_row['content'],
				'views'		=> $jb_row['views'],
				'insertTime'=> $jb_row['insertTime'],
				'updateTime'=> $jb_row['updateTime'],
		);
	}
	echo json_encode($data);
};


$call_name = $_GET['call_name'];
switch ($call_name){
	case  "page_list":
		page_list($start, $list_num);
		break;
	case  "pagination":
		pagination($list_num ,$page_num ,table_row_count());
		break;
	case  "data_list_search":
		data_list_search(connetDB() ,$_GET['searchTag'],$_GET['searchInput'], $start, $list_num);
		break;
}
?>
