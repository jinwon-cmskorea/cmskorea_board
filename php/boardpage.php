<?php
include 'dbsql/dbconn.php';
/*---------페이징 코드 -> 코드 이해하고 board에 적용할 방법 생각하기-----------------------*/

/* paging : 한 페이지 당 데이터 개수 */
$list_num = 10;

/* paging : 한 블럭 당 페이지 수 */
$page_num = 5;

/* 전체 데이터 개수 구하기*/
function table_row_count($row, $var ){
	$query= "SELECT COUNT(*) FROM board";
	if(isset($row) && isset($var)){
		$query .= " where " . $row . " LIKE '%" . $var . "%';";
	}
	$numsql = mysqli_query(connetDB(), $query);
	$num = mysqli_fetch_array($numsql);
	return $num[0];
}
/* paging : 현재 페이지 */
$page = isset($_GET['page'])? $_GET['page'] : 1;

/* paging : 시작 번호 = (현재 페이지 번호 - 1) * 페이지 당 보여질 데이터 수 */
$start = ($page - 1) * $list_num;

/* echo "<pre>";
var_dump($rows);
echo "</pre>";
 */

//페이징 기능
function pagination($list, $pagen, $count){
	$page = isset($_GET['page'])? $_GET['page'] : 1;
	/* paging : 전체 페이지 수 = 전체 데이터 / 페이지당 데이터 개수, ceil : 올림값, floor : 내림값, round : 반올림 */
	$total_page = ceil($count / $list);
	// echo "전체 페이지 수 : ".$total_page;
	
	/* paging : 전체 블럭 수 = 전체 페이지 수 / 블럭 당 페이지 수 */
	$total_block = ceil($total_page / $pagen);
	
	
	/* paging : 현재 블럭 번호 = 현재 페이지 번호 / 블럭 당 페이지 수 */
	$now_block = ceil($page /  $pagen);
	
	/* paging : 블럭 당 시작 페이지 번호 = (해당 글의 블럭번호 - 1) * 블럭당 페이지 수 + 1 */
	$s_pageNum = ($now_block - 1) * $pagen + 1;
	// 데이터가 0개인 경우
	if($s_pageNum <= 0){
		$s_pageNum = 1;
	};
	
	/* paging : 블럭 당 마지막 페이지 번호 = 현재 블럭 번호 * 블럭 당 페이지 수 */
	$e_pageNum = $now_block *  $pagen;
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

//데이터 정보에 맞게 출력하기
function page_data_list($row, $var, $order_name, $order_sort ,$start_list, $last_list){
	$query = "select * from board";
	if(isset($row) && isset($var) && isset($order_name) && isset($order_sort)){
		$query .= " where " . $row . " LIKE '%" . $var . "%'  order by ". $order_name . " " . $order_sort ." limit ". $start_list .",". $last_list. ";";
	}elseif (isset($order_name) && isset($order_sort)){
		$query .= " order by ". $order_name . " " . $order_sort ." limit ". $start_list .",". $last_list. ";";
	}elseif (isset($row) && isset($var)){
		$query .= " where " . $row . " LIKE '%" . $var . "%'limit ". $start_list .",". $last_list. ";";
	}else{
		$query .= " limit ". $start_list .",". $last_list. ";";
	}
	$result = mysqli_query(connetDB(), $query);
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

if(isset($_GET['call_name'])){
	$call_name = $_GET['call_name'];
	//데이터 검사
	$searchTag = isset($_GET['searchTag'])? $_GET['searchTag'] : null;
	$searchInput = isset($_GET['searchInput'])? $_GET['searchInput'] : null;
	$order_name = isset($_GET['order_name'])? $_GET['order_name'] : null;
	$order_sort = isset($_GET['order_sort'])? $_GET['order_sort'] : null;
	//-----데이터 분별-----
	if(!($searchTag ==="writer"|| $searchTag ==="title"|| $searchTag ==="insertTime")){
		$searchTag = null;
	}
	if(!($order_name ==="pk"|| $order_name ==="writer"|| $order_name ==="title"|| $order_name ==="insertTime")){
		$order_name = null;
	}
	if(!($order_sort ==="desc"|| $order_sort ==="asc")){
		$order_sort = null;
	}
	if ($searchTag === "undefined" || $searchInput === "undefined"){
		$searchTag = null;
		$searchInput = null;
	}
	if ($order_name === "undefined" || $order_sort === "undefined"){
		$order_name = null;
		$order_sort = null;
	}
	//---------------------
	
	switch ($call_name){
		case "pagination":
			pagination($list_num ,$page_num ,table_row_count($searchTag,urldecode($searchInput)));
			break;
		case "page_data_list":
			page_data_list($searchTag, urldecode($searchInput), $order_name ,$order_sort ,$start, $list_num);
			break;
	}
}else{echo "전달 받은 값이 없습니다!";}
?>
