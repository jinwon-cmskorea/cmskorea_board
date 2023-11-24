<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="../../jQuery/jquery-3.6.3.min.js"></script>
        <link href="../../bootstrap-5.3.1-dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="../../bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../../css/main.css" type="text/css">
        <title>리스트 페이지</title>
    </head>
    <body>
    <?php 
    if(!session_id()) {
    	session_start();
    }
    
    if(!isset($_SESSION['userName'])){
    	echo( "<script>alert('로그인 실패 후 접속했습니다!');</script>");
    	echo("<script>location.replace('../login.php');</script>");
    }
    ?>
        <div class="container border border-secondary listcontainer">
            <div class="header-include"></div>
            <?php
			include 'boardheader.php';
			?>
            <div style="margin: 15px;">
                <div class=" text-start" style="margin-bottom: 15px;">
                    <span class="fs-5 pagetitle">씨엠에스코리아 게시판</span>
                    <span class="text-primary text-opacity-75 pagedescription">- 리스트 -</span>
                </div>
                <div class="border rounded  border-dark-subtle align-self-center descriptionbox">
                    <p>등록 된 게시글을 조회하는 페이지입니다.<br>
                    등록 된 글은 조회, 수정 및 삭제 할 수 있습니다.</p>
                </div>
                <div>
                    <div>
                        <div class="row justify-content-between" style="height: 30px; margin-bottom: 10px;">
                            <div class="col-6">
                                <select class="text-white text-center" name="searchSelectBox" id="searchSelectBox">
                                    <option value="writer">작성자</option>
                                    <option value="title">제목</option>
                                    <option value="insertTime">작성일자</option>
                                </select>
                                <input  type="text" style="border: 1px solid lightgray;" id="searchBar" placeholder="검색어를 입력해주세요.">
                                <button class="btn btn-primary" id="searchButton">검색</button>
                            </div>
                            <div id="alertBox" class="col-3"></div>
                            <button class="btn btn-primary col-1" id="boardWrite">작성</button>
                        </div>
                        <div>
                            <table class="table" style="border-top: 1px solid lightgray;" id="boardTable" >
                                <thead>
	                                <tr>
	                                    <th class="col-1" id="boardPk" value="pk" >번호</th>
	                                    <th class="col-6 text-center" id="boardTitle" value="title">제목</th>
	                                    <th class="col-1" id="boardWriter" value="writer">작성자</th>
	                                    <th class="col-1" id="boardInsertTime" value="insertTime">작성일자</th>
	                                    <th class="col-2" id="nosort" value="nosort">작업</th>
	                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                            <nav aria-label="Page navigation example" id="pagingnav">
                              <ul class="pagination justify-content-center" id="pagination">
                              </ul>
                            </nav>
                    </div>
                </div>
            </div>
           <!-- <div ><a id="test">테스트</a></div> -->
        </div>
    <script>
        $(document).ready(function () {
        //삭제 경고창
        const appendDelete = (message, id) => {
        	const DeletePlaceholder = document.getElementById(id);
        	const Deletewrapper = document.createElement('div')
            Deletewrapper.innerHTML = [
            	`<div class="border border-danger border-2 rounded bg-danger-subtle text-dark p-2 alertDelete" style="position: absolute" id="alertDelete">`,
                `   <div id="deletewrapperpk">${message}</div>`,
                '   <button type="button" id="DeleteCompleteClose" class="btn btn-danger DeleteCompleteClose">삭제</button>',
                '   <button type="button" id="DeleteClose" class="btn btn-secondary DeleteClose">취소</button>',
                '</div>'
                ].join('')
            DeletePlaceholder.append(Deletewrapper)
        }
        //get parameter 가져오기
        const urlParams = window.location.search;
		function getParams(){
		    var url = window.location.search.replace('?','');
		    var params = {};
		    var urlArray = url.split('&');
		
		    for(var i in urlArray)
		    {
		      var param = urlArray[i].split('=');
		      params[param[0]] = param[1]; 
		    }
		    return params;
		}
		const params = getParams();
		//console.log(params);
        var page = params['page'];
        var searchTag = params['searchTag'];
        var searchInput = params['searchInput'];
        var orderName = params['orderName'];
        var sort = params['sort'];
        
        var pagecheck = false;
        if(page == undefined){
        	page = 1;
        }
        	//페이지 새로고침 함수
        	function reloadpage(){
        		location.href = "boardlist.php?page=" + page +"&searchTag="+ searchTag +"&searchInput=" + searchInput + "&orderName="+ orderName + "&sort=" + sort;
        	}
        	//ajax setTable 실행 함수
         	function ajaxData(callName){
                $.ajax({
	                url : '../../php/boardpage.php',
	                type : 'GET',
	                data : {call_name:callName, page: page, searchTag:searchTag ,searchInput: searchInput, order_name:orderName, order_sort:sort},
                    error : function(){
                        console.log("실패");
                    }, success : function(result){
                        setTable(result);
                    }
                });
        	}
        	 
			//가져온 JSON 변환 및 테이블 리스트 추가 함수
			function setTable (result){
                $("#boardTable").children('tbody').empty();
                //console.log(result);
				try{
					if(searchTag !== undefined && searchInput !== undefined && result.length === 2){
						$("#pagination").children("li").empty();
						var innerHTML = "";
						innerHTML += "<td class='align-middle text-center fs-3 fw-bold py-4' colspan='4'>검색결과가 존재하지 않습니다!</td>";
						innerHTML += "<td class='align-middle text-center fs-5 fw-bold py-4'><a class='link-info' href='boardlist.php'>돌아가기</a></td>";
						$("#boardTable").children('tbody').append(innerHTML);
					}else{
		                var list = JSON.parse(result);
		                $.each(list, function(index,value){
		                    var setview = "<button type='button' class='btn btn-warning text-white viewButton'>조회</button>";
		                    var setDelete = "<button type='button' class='btn btn-danger deleteButton ms-2'>삭제</button>";
		                    var innerHTML = "";
		                    innerHTML += "<tr class='align-middle' >";
		                    innerHTML += "<th scope='row'>" + value['pk'] + "</th>";
		                    innerHTML += "<td>" + value['title'] + "</td>";
		                    innerHTML += "<td>" + value['writer'] + "</td>";
		                    innerHTML += "<td>" + value['insertTime'].substr(0,10) + "</td>";
		                    innerHTML += "<td>" + setview + setDelete + "</td>";
		                    innerHTML += "</tr>";
		                   
		                    $("#boardTable").children('tbody').append(innerHTML);
		                });
	                }
				}catch(e){
					$("#pagination").children("li").empty();
					var innerHTML = "";
					innerHTML += "<tr><td class='align-middle text-center fs-3 fw-bold py-4' colspan='5'>게시글 리스트를 불러오기 실패했습니다!</td></tr>";
					innerHTML += "<tr><td class='align-middle text-center py-2' colspan='5'>오류내용 : " + e + "</td>/tr>";
					$("#boardTable").children('tbody').append(innerHTML);
					
				}
			}
      		//page nav 출력 함수
      		function navstring (pageStartNum, pageEndNum, getTag){
				innerHTML = "<li class='page-item'><a class='page-link' href='boardlist.php?page=1"+ getTag + "'>First</a></li>";
	            $("#pagination").append(innerHTML);
	            for($print_page = pageStartNum; $print_page <= pageEndNum; $print_page++){
	                innerHTML = "";
	                innerHTML += "<li class='page-item'><a class='page-link' href='boardlist.php?page=" + $print_page +  getTag + "'>" + $print_page +"</a></li>";
	                //console.log(innerHTML);
	                $("#pagination").append(innerHTML);
	            }
	        	innerHTML = "<li class='page-item'><a class='page-link' href='boardlist.php?page=" + pageEndNum + getTag  +"'>Last</a></li>";
	            $("#pagination").append(innerHTML);
      		}
      		
        	//page 메인 함수 호출(게시글 출력)
        	setPageNav();
        	
	
            //게시글 정렬
            $(document).on('click', 'body div.container #boardTable>thead th', function() {
				var thisRow = $(this).closest('th');
				orderName = (thisRow).attr('value');
				if(!(orderName == "nosort")){
					if(sort ==='desc' || sort === undefined){
					        sort = 'asc';
						}else{
					        sort = 'desc';
						}
		        		setPageNav();
				}
            });
            
            //게시글 리로드때 정렬
            function sortReTable(){
				$('table > thead').find('th').each(function(inx, th) {
			        th.innerHTML = th.innerHTML.replace(/[▼▲]/g, '') ;
			    });
			    if(sort ==='asc'){
			    	sort ='desc';
			    }else{sort ='asc';}
			    
			    if (sort === 'asc') {
			        $("th[value=" + orderName + "]").append('▲');
			        ajaxData('page_data_list');
			        sort = 'desc';
			    } else{
			        $("th[value=" + orderName + "]").append('▼');
			        ajaxData('page_data_list');
                    sort = 'asc';
			    }
            }
            //게시글 검색
            $("#searchButton").on('click', function(){
            	if(page !==1){
            		pagecheck = true;
            	}
            	$("#alertBox").empty();
                searchTag = $("#searchSelectBox").val();
                searchInput = $("#searchBar").val();
                setPageNav();
            });
            

            //게시판 목록 페이징
            function setPageNav(){
            	if($('#searchBar').val()){
            		searchTag = $("#searchSelectBox").val();
                	searchInput = $("#searchBar").val();
            	}
            	 if(pagecheck){
					page = 1;
					pagecheck = false;
					
				} 
                $.ajax({
                    url : '../../php/boardpage.php',
                    type : 'GET',
                    data : {call_name:'pagination' ,page:page, searchTag:searchTag ,searchInput: searchInput},
                    error : function(){
                        console.log("실패");
                    }, success : function(result){
                        $("#boardTable").children('tbody').empty();
                        var list = JSON.parse(result);
                        var innerHTML = "";
                        var tag = "";
                        $("#pagingnav").children('ul').empty();
                        if(orderName !== undefined && sort !== undefined){
                        	tag = "&searchTag="+ searchTag +"&searchInput=" + searchInput + "&orderName="+ orderName + "&sort=" + sort;
                        	navstring(list[0]['s_pageNum'], list[0]['e_pageNum'], tag);
	                        sortReTable();
			        	}else if(orderName == undefined && sort == undefined){
			        		tag = "&searchTag="+ searchTag +"&searchInput=" + searchInput;
			        		navstring(list[0]['s_pageNum'], list[0]['e_pageNum'], tag);
	                        //게시판 검색 목록 set(목록 크기에 맞게 가져오기)
                			ajaxData('page_data_list');
                        }
                    }
                });
            }
            //게시글 조회
            $(document).on('click', 'body div.container .viewButton', function() {
                var thisRow = $(this).closest('tr'); 
                var viewPk = parseInt(thisRow.find('th').text());
                
                location.href = "boardview.php?"+viewPk; 
            });
            //게시글 삭제
            $(document).on('click', 'body div.container .deleteButton', function() {
            	$("#alertBox").empty();
            	var thisRow = "";
                thisRow = $(this).closest('tr'); 
                var deletePk = parseInt(thisRow.find('th').text());
                appendDelete("&#10071;정말로 " + deletePk  + "번째 제품정보를 삭제하시겠습니까?", 'alertBox');
                $("#deletewrapperpk").attr("value",deletePk);
            });
            $(document).on('click', 'body div.container .DeleteCompleteClose', function() {
	            deletePk = $("#deletewrapperpk").attr("value");
	            $.ajax({
	            url : '../../php/board.php',
	            type : 'POST',
	            data : {call_name:'delete_post', deletePk:deletePk},
	            error : function(){
	            console.log("실패");
	            }, success : function(result){
	                setPageNav();
	                }
	            });
	            $("#alertBox").empty();
	            reloadpage();
            });
            $(document).on('click', 'body div.container .DeleteClose', function() {
            	$("#alertBox").empty();
            	reloadpage();
            });
            //게시글 작성
            $(document).on('click', '#boardWrite',function(){
               location.href = 'boardwrite.php'; 
            });
        
        });
    </script>
    </body>
</html>