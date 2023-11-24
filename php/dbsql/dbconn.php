<?php 

function connetDB(){
	$mysql = mysqli_connect('localhost', 'root', 'cmskorea', 'dbboard');
	
	if ($mysql) {
		//echo "DB연결 성공";
		return $mysql;
	} else {
		//echo "DB연결 실패 : " . mysqli_error($mysql);
		return false;
	};
}
//테이블 유무 체크
/* function tableCheck($tableName){
	$result = mysqli_query(connetDB(), " SHOW tables LIKE '" . $tableName ."' ");
	switch ($tableName){
		case "member":
			if(!mysqli_num_rows($result) > 0){
				$sql = "CREATE TABLE `member` (
					  `pk` int(10) NOT NULL,
					  `id` varchar(32) NOT NULL,
					  `name` varchar(32) NOT NULL COMMENT '작성자',
					  `telNumber` varchar(32) NOT NULL COMMENT '휴대전화번호',
					  `email` varchar(255) DEFAULT NULL,
					  `position` tinyint(1) NOT NULL DEFAULT '0',
					  `insertTime` datetime NOT NULL COMMENT '등록시간',
					  `updateTime` datetime NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='회원';
						ALTER TABLE `member`
						  ADD PRIMARY KEY (`pk`),
						  ADD UNIQUE KEY `id` (`id`) USING BTREE;
						ALTER TABLE `member`
  						MODIFY `pk` int(10) NOT NULL AUTO_INCREMENT;";
				if (!mysqli_query(connetDB(), $sql)) {
					echo "Error create record: " . mysqli_error(connetDB());
				}
			}
			
			break;
		case "board":
			if(!mysqli_num_rows($result) > 0){
				$sql = "CREATE TABLE `board` (
					  `pk` int(11) NOT NULL COMMENT '인덱스',
					  `memberPk` int(10) NOT NULL COMMENT '회원고유키',
					  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '제목',
					  `writer` varchar(32) NOT NULL DEFAULT '' COMMENT '작성자',
					  `content` text NOT NULL COMMENT '내용',
					  `views` int(10) DEFAULT NULL,
					  `insertTime` datetime NOT NULL COMMENT '등록시간',
					  `updateTime` datetime NOT NULL COMMENT '변경시간'
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='게시판';
						ALTER TABLE `board`
  						ADD PRIMARY KEY (`pk`);
						ALTER TABLE `board`
 						 MODIFY `pk` int(11) NOT NULL AUTO_INCREMENT;";
				if (!mysqli_query(connetDB(), $sql)) {
					echo "Error create record: " . mysqli_error(connetDB());
				}
			}
			break;
	}
} */
//데이터 가져오기
function data_list($table) {
	$query = "SELECT * FROM " . $table;
	$rs = mysqli_query(connetDB(), $query);
	// 	$rows = mysqli_fetch_all($rs);
	
	// 	echo "<pre>";
	// 	var_dump($rows);
	// 	echo "</pre>";
	// 	return $rows;
	
	$rows = array();
	while(!!($row = mysqli_fetch_assoc($rs))) {
		$rows[] = $row;
	}
	
	return $rows;
};
//데이터 검색
function data_search($table, $searchrow, $row, $var) {
	$query = "SELECT " . $searchrow . " FROM " . $table . " where " . $row . "='" . $var . "';";
	$rs = mysqli_query(connetDB(), $query);
	
	$rows = mysqli_fetch_all($rs);

	if (empty($rows))
		return false;
	else
		return $rows[0][0];
};
?>