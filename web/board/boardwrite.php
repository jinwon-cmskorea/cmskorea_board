<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="../../jQuery/jquery-3.6.3.min.js"></script>
        <link href="../../bootstrap-5.3.1-dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="../../bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>
        <style type="text/css">
            .labelbox{
                background-color: lightgray; 
                border: none; 
                width: 100px; 
                height: 30px;
                line-height: 30px;
            }
            .inputwritebox{
                border: solid 1px lightgray;  
                height: 30px;
                line-height: 30px;
            }
        </style>
        <title>작성 페이지</title>
    </head>
    <body>
    <?php 
    if(!session_id()) {
    	session_start();
    }
    
    ?>
        <div class="container border border-secondary" style="height: 900px;">
            <div class="header-include"></div>
            <div style="margin: 15px;">
                <div class=" text-start" style="margin-bottom: 15px;">
                    <span class="fs-5" style="color: #595959; font-weight:bold">씨엠에스코리아 게시판</span>
                    <span class="text-primary text-opacity-75" style="font-size: small; font-weight:bold">- 작성 -</span>
                </div>
                <div class="border rounded  border-dark-subtle align-self-center" style="height: 65px; padding: 8px; margin-bottom: 30px; line-height: 48px;">
                    <p>게시판 글을 작성합니다.</p>
                </div>
                <div class="p-4">
                    <div class="mb-4">
                        <div class="row">
                            <div class="labelbox  text-center col-1 mx-5 my-2">
                                <span class="text-white">제 목</span>
                            </div>
                            <input type="text" class="col-9 inputwritebox align-self-center" id="writeTitle">
                        </div>
                        <div class="row">
                            <div class="labelbox  text-center col-1 mx-5 mb-5 my-2">
                                <span class="text-white">내 용</span>
                            </div>
                            <textarea  class="col-9 inputwritebox my-2" style="height: 400px; resize: none;" id="writeContent"></textarea>
                        </div>
                        <div class="row">
                            <div class="labelbox  text-center col-1 mx-5 my-2">
                                <span class="text-white">작성자</span>
                            </div>
                            <input type="text" class="col-2 inputwritebox align-self-center" id="writer" value="<?php echo $_SESSION['userName'] ?>" >
                        </div>
                    </div>
                    <div class="mx-5 row">
                        <button class="btn btn-primary col rounded-0 mx-1" id="boardWrite">등 록</button>
                        <button class="col mx-1" style="border: solid 1px lightgray;" id="writeCancel">취소</button>
                    </div>
                </div>
                <div class="text-start" id="alertBox"></div>
            </div>
        </div>
    <script>
        $(document).ready(function () {
        	//경고문(입력 체크)  
              	const appendAlert = (message, type, id) => {
                 const alertPlaceholder = document.getElementById(id);
                 const wrapper = document.createElement('div');
                    wrapper.innerHTML = [
                      `<div class="alert alert-${type} alert-dismissible alertmainbox" id="alertmain" >`,
                      `   <div>${message}</div>`,
                      '   <button type="button" id="alertclose" class="btn-close close" data-bs-dismiss="alert"></button>',
                      '</div>'
                    ].join('')
                        
                    alertPlaceholder.append(wrapper);
                  }
            //게시판 헤더 불러오기
            $('.header-include').load('boardheader.php');
			//작성 버튼
            $("#boardWrite").on('click', function(){
                var writeTitle = $("#writeTitle").val();
                var writeContent = $("#writeContent").val();
                var writer = $("#writer").val();

                if(!writeTitle){
	 				$(".alertmainbox").remove();
		            appendAlert('제목을 입력해 주세요!', 'danger','alertBox');
                }else if(!writeContent){
                	$(".alertmainbox").remove();
                	appendAlert('내용을 입력해 주세요!', 'danger','alertBox');
                }else if(!writer){
                	$(".alertmainbox").remove();
                	appendAlert('작성자를 입력해 주세요!', 'danger','alertBox');
                }else{
	                $.ajax({
	                    url : '../../php/board.php',
	                    type : 'POST',
	                    data : {call_name:'write_post', writeTitle:writeTitle, writeContent:writeContent, writer:writer},
	                    error : function(){
	                    console.log("실패");
	                    }, success : function(result){
	                    	$("#alertBox").append(result);
	                        location.href = 'boardlist.php'; 
	                        }
	                    });
                }
            });
            //취소하기
            $(document).on('click', '#writeCancel',function(){
               location.href = 'boardlist.php'; 
            });
        });
    </script>
    </body>
</html>