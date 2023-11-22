<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="../jQuery/jquery-3.6.3.min.js"></script>
        <link href="../bootstrap-5.3.1-dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="../bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>
        <style type="text/css">
            .centerbox{
                width: 500px;
                height: 600px;
                margin:auto;
                padding: 30px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
            .inputbox{
                width: 23%;
                height: 50px;
                margin-right: 40px;
                text-align: center;
                align-items: center;
                line-height: 50px;
            }
        </style>
        <title>회원가입 페이지</title>
    </head>
    <body>
        <div class="container">
            <div  class="text-center centerbox border border-2 border-dark">
                <div class=" text-start" >
                    <span class="fs-5" style="color: #595959; font-weight:bold ">씨엠에스코리아 게시판</span>
                    <span class="text-primary text-opacity-75" style="font-size: small; font-weight:bold">- 회원가입 -</span>
                </div>
                <br/>
                <form class="text-start grid gap-3 " action="../php/member.php" onsubmit="return checkForm();" method="post" id="signupForm"><!-- needs-validation" novalidate -->
                    <div class="row p-2 g-col-6 input-group" id="memberIdBox">
                        <span class="col-3 align-self-center bg-success text-white inputbox">아이디</span>
                        <input  type="text" class="col-8 form-control form-control-lg rounded-0" name="memberId" id="memberId" placeholder="영문 및 숫자 포함" >
                    </div>
                    <div class="row p-2 g-col-6 input-group" id="memberPwBox">
                        <span class="col-3 align-self-center bg-success text-white inputbox">비밀번호</span>
                        <input  type="password" class="col-8 form-control form-control-lg rounded-0"  name="memberPw" id="memberPw" placeholder="영문 숫자 필수" >
                    </div>
                    <div class="row p-2 g-col-6 input-group" id="memberNameBox">
                        <span class="col-3 align-self-center bg-success text-white inputbox">이름</span>
                        <input  type="text" class="col-8 form-control form-control-lg rounded-0" style="ime-mode:auto;" name="memberName" id="memberName" placeholder="한글만 가능" >

                    </div>
                    <div class="row p-2 g-col-6 input-group" id="memberTelBox">
                        <span class="col-3 align-self-center bg-success text-white inputbox">휴대전화</span>
                        <input  type="text" class="col-8 form-control form-control-lg rounded-0" name="memberTel" id="memberTel" placeholder="010-0000-0000" >
                    </div>
                    
	                 <div class="row justify-content-end " style="margin-top: 50px;">
	                    <div class="col-5 "></div>
	                    <button type="submit" class="btn btn-warning text-light col-2 rounded-0" style="margin-right: 20px;" id="signupButton">가입</button>
	                    <button type="button" class="btn btn-secondary col-2 rounded-0 border border-2 border-dark" style="margin-right: 40px;" id="backHTML">취소</button>
	                </div>
                </form>
                <div class="text-start" id="alertBox"></div>
            </div>
        </div>
        <script>
            //경고문(정보 체크)  
			function checkForm() {
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
                //유효성 검사
				var check = false;
				var num = /[0-9]/g;
				var eng = /[a-z]/ig;
				var regexpName = /[a-z0-9]|[ \[\]{}()<>?|`~!@#$%^&*-_+=,.;:\"'\\]/g;
				var regexpTel = /^(?:(010-\d{4})|(01[1|6|7|8|9]-\d{3,4}))-(\d{4})$/;
				
				inputIdVal = $("#memberId").val();
				inputPwVal = $("#memberPw").val();
				inputNameVal = $("#memberName").val();
				inputTelVal = $("#memberTel").val();
				
 				if(inputIdVal.trim() == '' || inputPwVal.trim() == '' || inputNameVal.trim() == '' || inputTelVal.trim() == ''){
						$(".alertmainbox").remove();
						appendAlert('빈칸을 채워주세요!', 'danger','alertBox');
						return check;
				} 
 				else if(inputIdVal.search(num) < 0 && inputIdVal.search(eng) < 0){
 					$(".alertmainbox").remove();
	                appendAlert('영문 또는 숫자가 입력되어야합니다!', 'danger','memberIdBox');
	                return check;
				} 
 				else if(inputPwVal.search(num) < 0 || inputPwVal.search(eng) < 0){
 					$(".alertmainbox").remove();
	                appendAlert('영문 및 숫자가 필수입니다!', 'danger','memberPwBox');
	                return check;
				} 
 				else if(regexpName.test(inputNameVal)){
 					$(".alertmainbox").remove();
	                appendAlert('한글만 입력 가능합니다!', 'danger','memberNameBox');
	                return check;
				} 
 				else if(!(regexpTel.test(inputTelVal))){
 					$(".alertmainbox").remove();
	                appendAlert('휴대전화 형식으로 입력해야 합니다!', 'danger','memberTelBox');
	                return check;
				} 
				check = true;
				return check;
			}
            $(document).ready(function(){
                    
                    $(document).on('click', 'body div.container #alertclose', function(){
                        $("#alertmain").remove();
                    });
                    
				
                $(document).on('click', '#backHTML',function(){
                   location.href = 'login.php'; 
                });
                
            });
        </script>
    </body>
</html>