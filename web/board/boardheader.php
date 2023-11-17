<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="../../jQuery/jquery-3.6.3.min.js"></script>
        <link href="../../bootstrap-5.3.1-dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="../../bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>
        <style type="text/css">
            .header{
                height: 60px;
                padding: 10px;
            }
            #logout{
            	height : 40px;
            	padding: 10px;
            }
        </style>
        <title>게시판 헤더 페이지</title>
    </head>
    <body>
    <?php 
    if(!session_id()) {
    	session_start();
    }
    
    ?>
        <div class="header row bg-secondary">
            <h3 class="col-9 text-white align-self-center fw-bold">CMSKOREA Board</h3>
            <span class="col-1 text-center align-self-center text-white"><?php print_r($_SESSION['userName']); ?></span>
            <button class="col-1 border-white rounded-0 btn btn-sm bg-white" id="logout" >로그아웃</button>
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