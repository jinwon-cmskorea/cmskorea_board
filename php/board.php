<?php
include 'dbsql/dbconn.php';
if(!session_id()) {
	session_start();
}

function set_board(){
	//echo "board 확인용";
	$data = array();
	foreach(data_list("board") as $jb_row ) {
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


function write_post(){
	$writeTitle = $_POST['writeTitle'];
	$writeContent = $_POST['writeContent'];
	$writer = $_POST['writer'];
	
	$find = "SELECT pk from member where id='" . $writer . "';";
	$memberPk = mysqli_num_rows(mysqli_query(connetDB(), $find));
	if($memberPk){
		$query = "INSERT INTO board ( memberPk, title, writer, content, insertTime, updateTime) VALUE( ". $memberPk." ,'". $writeTitle."' ,'". $writer ."', '" . $writeContent . "' , now(), now());";
		$_SESSION['alert'] = 'write';
		mysqli_query(connetDB(), $query);
	}else{
		return false;
	}
}
function view_post(){
	$viewPk = $_POST['viewPk'];
	$query = "SELECT * FROM board WHERE pk =". $viewPk .";";
	//echo $query;
	$rs = mysqli_query(connetDB(), $query);
	$row = mysqli_fetch_assoc($rs);
	
	if (!$rs) {
		echo "등록실패 : " . mysqli_error(connetDB());
	}
	echo json_encode($row);
}
function update_post(){
	$viewPk = $_POST['viewPk'];
	$updateTitle = $_POST['updateTitle'];
	$updateContent = $_POST['updateContent'];
	$updateWriter = $_POST['updateWriter'];
	
	$query = "UPDATE board SET title='" . $updateTitle . "', content='"  . $updateContent . "', writer='" . $updateWriter . "', updateTime= now() WHERE pk =". $viewPk .";";
	$rs = mysqli_query(connetDB(), $query);
	
	if(!$rs) {
		echo "등록실패 : " . mysqli_error(connetDB());
	}else {
		$_SESSION['alert'] = 'edit';
	}
}


function delete_post(){
	$deletePk = $_POST['deletePk'];
	$query = "DELETE FROM board WHERE pk =". $deletePk .";";
	$rs = mysqli_query(connetDB(), $query);
	
	if (!$rs) {
		echo "등록실패 : " . mysqli_error(connetDB());
	}
}
if(isset($_POST['call_name'])){
$call_name = $_POST['call_name'];
	switch ($call_name){
		case  "set_board":
			set_board();
			break;
		case  "write_post":
			write_post();
			break;
		case  "view_post":
			view_post();
			 break;
		case  "update_post":
			update_post();
			 break;
		case  "delete_post":
			delete_post();
			break; 
	}
}else{echo "전달 받은 값이 없습니다!";}
?>