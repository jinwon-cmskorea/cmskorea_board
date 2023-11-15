<?php
include 'dbsql/dbconn.php';

function set_board($sql){
	//echo "board 확인용";
	
	$data = array();
	foreach(data_list($sql, "board") as $jb_row ) {
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


function write_post($sql){
	$writeTitle = $_POST['writeTitle'];
	$writeContent = $_POST['writeContent'];
	$writer = $_POST['writer'];
	
	$find = "SELECT pk from member where name='" . $writer . "';";
	$memberPk = mysqli_num_rows(mysqli_query($sql, $find));

	if($memberPk){
		$query = "INSERT INTO board ( memberPk, title, writer, content, insertTime, updateTime) VALUE( ". $memberPk." ,'". $writeTitle."' ,'". $writer ."', '" . $writeContent . "' , now(), now());";
		$rs = mysqli_query($sql, $query);
		if (!$rs) {
			echo "등록실패 : " . mysqli_error($sql);
		}
	}else{
		alert("게시글 등록에 실패했습니다.");
	}
}
function view_post($sql){
	$viewPk = $_POST['viewPk'];
	$query = "SELECT * FROM board WHERE pk =". $viewPk .";";
	//echo $query;
	$rs = mysqli_query($sql, $query);
	$row = mysqli_fetch_assoc($rs);
	
	if (!$rs) {
		echo "등록실패 : " . mysqli_error($sql);
	}
	echo json_encode($row);
}
function update_post($sql){
	$viewPk = $_POST['viewPk'];
	$updateTitle = $_POST['updateTitle'];
	$updateContent = $_POST['updateContent'];
	$updateWriter = $_POST['updateWriter'];
	
	$query = "UPDATE board SET title='" . $updateTitle . "', content='"  . $updateContent . "', writer='" . $updateWriter . "', updateTime= now() WHERE pk =". $viewPk .";";
	//echo $query;
	$rs = mysqli_query($sql, $query);
	
	if (!$rs) {
		echo "등록실패 : " . mysqli_error($sql);
	}
}


function delete_post($sql){
	$deletePk = $_POST['deletePk'];
	$query = "DELETE FROM board WHERE pk =". $deletePk .";";
	$rs = mysqli_query($sql, $query);
	
	if (!$rs) {
		echo "등록실패 : " . mysqli_error($sql);
	}
}
$call_name = $_POST['call_name'];
switch ($call_name){
	case  "set_board":
		set_board(connetDB());
		break;
	case  "write_post":
		write_post(connetDB());
		break;
	case  "view_post":
		view_post(connetDB());
		 break;
	case  "update_post":
		update_post(connetDB());
		 	break;
	case  "delete_post":
		delete_post(connetDB());
		break; 
}
?>