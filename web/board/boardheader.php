<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="../../jQuery/jquery-3.6.3.min.js"></script>
        <link href="../../bootstrap-5.3.1-dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="../../bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../../css/main.css" type="text/css">
        <title>게시판 헤더 페이지</title>
    </head>
    <body>
    <?php 
    if(!session_id()) {
    	session_start();
    }
	
    if(isset($_SESSION['alert'])){
    	$alertSession = $_SESSION['alert'];
    	//echo $alertSession;
    	switch ($alertSession){
    		case  "write":
    			echo("<script>alert('새 글이 등록되었습니다');</script>");
    			unset($_SESSION['alert']);
    			break;
    		case  "edit":
    			echo("<script>alert('글이 수정되었습니다');</script>");
    			unset($_SESSION['alert']);
    			break;
    	}
    }
    ?>
        <div class="header row bg-secondary">
            <h3 class="col-9  align-self-center fw-bold"><a class="text-white text-decoration-none" href="boardlist.php">CMSKOREA Board</a></h3>
            <span class="col-1 text-center align-self-center text-white"><?php print_r($_SESSION['userName']); ?></span>
            <button class="col-1 border-white rounded-0 btn btn-sm bg-white logoutbutton" id="logout" >로그아웃</button>
        </div>
        <script>
            $(document).ready(function(){
                $(document).on('click', '#logout',function(){
                   location.href = '../logout.php'; 
                });
            });
        </script>
    </body>
</html>