<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="../../jQuery/jquery-3.6.3.min.js"></script>
        <link href="../../bootstrap-5.3.1-dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="../../bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>
        <style type="text/css">
            .contentbox{
                border-top: 1px dashed lightgray;
                border-bottom: 1px dashed lightgray;
            }
        </style>
        <title>조회 페이지</title>
    </head>
    <body>
        <div class="container border border-secondary" style="height: 900px;">
            <div class="header-include"></div>
            <div style="margin: 15px;">
                <div class=" text-start" style="margin-bottom: 15px;">
                    <span class="fs-5" style="color: #595959; font-weight:bold">씨엠에스코리아 게시판</span>
                    <span class="text-primary text-opacity-75" style="font-size: small; font-weight:bold">- 조회 -</span>
                </div>
                <div class="border rounded  border-dark-subtle align-self-center" style="height: 65px; padding: 8px; margin-bottom: 30px; line-height: 48px;">
                    <p>게시판 글을 조회합니다.</p>
                </div>
                <div>
                    <div>
                        <div class="row">
                            <div class="col-8 fs-3" id="boardViewTitle"></div>
                            <span  class="col-1  align-self-center" id="boardViewWriter"></span>
                            <span  class="col-2  align-self-center" id="boardViewTime"></span>
                        </div>
                        <div class="contentbox p-3" id="boardViewContent">
                        </div>
                    </div>
                    <div class="mx-5 mt-4 row">
                        <button class="btn btn-primary bg-warning border-warning col rounded-0 mx-1" id="postEdit">수 정</button>
                        <button class="col mx-1" style="border: solid 1px lightgray;" id="backList">리스트</button>
                    </div>
                </div>
            </div>
        </div>
    <script>
        $(document).ready(function () {
            //게시판 헤더 불러오기
            $('.header-include').load('boardheader.php');
            const viewPk = location.href.split('?')[1];
            //게시글 조회
            function setViewData(){
                $.ajax({
                    url : '../../php/board.php',
                    type : 'POST',
                    data : {call_name:'view_post', viewPk:viewPk},
                    error : function(){
                        console.log("실패");
                    }, success : function(result){
                        var list = JSON.parse(result);
                        $("#boardViewTitle").html(list['title']);
                        $("#boardViewWriter").html(list['writer']);
                        $("#boardViewTime").html(list['updateTime']);
                        $("#boardViewContent").html(list['content']);
                    }
                });
            }
            setViewData();
            //$("#container").html('Hi there!');
            
            //수정하기
            $(document).on('click', '#postEdit',function(){
               location.href = "boardedit.php?"+viewPk;
            });
            
            //취소하기
            $(document).on('click', '#backList',function(){
               location.href = 'boardlist.php'; 
            });
        });
    </script>
    </body>
</html>