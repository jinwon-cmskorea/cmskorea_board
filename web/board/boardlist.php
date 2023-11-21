<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="../../jQuery/jquery-3.6.3.min.js"></script>
        <link href="../../bootstrap-5.3.1-dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="../../bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>
        <style type="text/css">
            .page-link{
              color: #000; 
              background-color: #fff;
              border: 1px solid #ccc; 
            }
            
            .page-item.active .page-link {
             z-index: 1;
             color: #555;
             font-weight:bold;
             background-color: #f1f1f1;
             border-color: #ccc;
             
            }
            
            .page-link:focus, .page-link:hover {
              color: #000;
              background-color: #fafafa; 
              border-color: #ccc;
            }
        </style>
        <title>리스트 페이지</title>
    </head>
    <body>
    <?php 
    if(!session_id()) {
    	session_start();
    }
    ?>
        <div class="container border border-secondary" style="height: 920px;">
            <div class="header-include"></div>
            <div style="margin: 15px;">
                <div class=" text-start" style="margin-bottom: 15px;">
                    <span class="fs-5" style="color: #595959; font-weight:bold">씨엠에스코리아 게시판</span>
                    <span class="text-primary text-opacity-75" style="font-size: small; font-weight:bold">- 리스트 -</span>
                </div>
                <div class="border rounded  border-dark-subtle align-self-center" style="height: 65px; padding: 8px; margin-bottom: 30px;">
                    <p>등록 된 게시글을 조회하는 페이지입니다.<br>
                    등록 된 글은 조회, 수정 및 삭제 할 수 있습니다.</p>
                </div>
                <div>
                    <div>
                        <div class="row justify-content-between" style="height: 30px; margin-bottom: 10px;">
                            <div class="col-8">
                                <select class="text-white text-center" name="searchSelectBox" id="searchSelectBox" style="background-color: lightgray; border: none; width: 120px; height: 30px;">
                                    <option value="writer">작성자</option>
                                    <option value="title">제목</option>
                                    <option value="insertTime">작성일자</option>
                                </select>
                                <input  type="text" style="border: 1px solid lightgray;" id="searchBar" >
                                <button class="btn btn-primary" id="searchButton">검색</button>
                            </div>
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
	                                    <th class="col-2">작업</th>
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
        if(page == undefined){
        	page = 1;
        }
			/* console.log(page);
        	console.log(searchTag);
        	console.log(searchInput);
        	console.log(orderName);
        	console.log(sort);  */
        	
			//가져온 JSON 변환 및 테이블 리스트 추가
			function setTable (result){
                $("#boardTable").children('tbody').empty();
                var list = JSON.parse(result);
                //console.log("함수 작동 확인용");
                $.each(list, function(index,value){
                    var setview = "<button type='button' class='btn btn-warning text-white viewButton'>조회</button>";
                    var setDelete = "<button type='button' class='btn btn-danger deleteButton'>삭제</button>";
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
			
			
            //게시판 헤더 불러오기
        	$('.header-include').load('boardheader.php');
        	
        	//페이지 구별(검색, 정렬 여부 체크)
        	if(searchTag !== undefined && searchInput !== undefined && orderName !== undefined && sort !== undefined){
        		setSearchPageNav();
        		//console.log("1-체크");
        	}else if(searchTag !== undefined && searchInput !== undefined ){
        		setSearchPageNav();
        		//console.log("2-체크");
        	}else if(orderName !== undefined && sort !== undefined){
        		setPageNav();
        		//console.log("3-체크");
        	}
        	else{
        		setPageNav();
        		//console.log("4-체크");
        	}
            //게시글 정렬
            $(document).on('click', 'body div.container #boardTable>thead th', function() {
				var thisRow = $(this).closest('th');
				orderName = (thisRow).attr('value');
				//console.log(thisRow);
				//console.log(orderName); 
                /*location.href = "boardview.php?"+viewPk;  */

                if(searchTag !== undefined && searchInput !== undefined){
        			sortSearchTable(this);
        			setSearchPageNav();
        			
        		}else{
	                sortTable(this,orderName);
	                setPageNav()
        		}
        	
            });
            
            function sortTable(cell, name){
				$('table > thead').find('th').each(function(inx, th) {
			        th.innerHTML = th.innerHTML.replace(/[▼▲]/g, '') ;
			    });
				if(sort ==='asc' || sort ===undefined){
			        sort = 'desc';
			        cell.innerHTML += '▼';
			        $.ajax({
	                    url : '../../php/boardpage.php',
	                    type : 'GET',
	                    data : {call_name:'page_list_sort', page: page, order_name:name, order_sort:sort},
	                    error : function(){
	                        console.log("실패");
	                    }, success : function(result){
                        	setTable (result);
	                    }
                    });
				}else{
			        sort = 'asc';
			        cell.innerHTML += '▲';
			        $.ajax({
	                    url : '../../php/boardpage.php',
	                    type : 'GET',
	                    data : {call_name:'page_list_sort', page: page, order_name:name, order_sort:sort},
	                    error : function(){
	                        console.log("실패");
	                    }, success : function(result){
                        	setTable (result);
	                    }
                    });
				}
				/*  st = "boardlist.php?page=2&orderName="+ orderName + "&sort=" + sort;
                    console.log(st);
                    $("#test").attr("href",st);  */
			
            }
            //게시글 리로드때 정렬
            function sortReTable(name, set){
				$('table > thead').find('th').each(function(inx, th) {
			        th.innerHTML = th.innerHTML.replace(/[▼▲]/g, '') ;
			    });
			    if(set ==='asc'){
			    	set ='desc';
			    }else{set ='asc';}
			    
			    if (set === 'asc') {
			        $("th[value=" + name + "]").append('▲');
			        $.ajax({
	                    url : '../../php/boardpage.php',
	                    type : 'GET',
	                    data : {call_name:'page_list_sort', page: page, order_name:name, order_sort:sort},
	                    error : function(){
	                        console.log("실패");
	                    }, success : function(result){
                        	setTable (result);
	                    }
                    });
			        sort = 'desc';
			    } else{
			        $("th[value=" + name + "]").append('▼');
			        $.ajax({
	                    url : '../../php/boardpage.php',
	                    type : 'GET',
	                    data : {call_name:'page_list_sort', page: page, order_name:name, order_sort:sort},
	                    error : function(){
	                        console.log("실패");
	                    }, success : function(result){
                        	setTable (result);
	                    }
                    });
                    sort = 'asc';
			    }
            }
            
            //게시글 검색 정렬
            function sortSearchTable(cell){
				$('table > thead').find('th').each(function(inx, th) {
			        th.innerHTML = th.innerHTML.replace(/[▼▲]/g, '') ;
			    });
				if(sort ==='asc' || sort ===undefined){
			        sort = 'desc';
			        cell.innerHTML += '▼';
			        $.ajax({
	                    url : '../../php/boardpage.php',
	                    type : 'GET',
	                    data : {call_name:'page_list_search_sort', page: page, searchTag:searchTag ,searchInput: searchInput, order_name:orderName, order_sort:sort},
	                    error : function(){
	                        console.log("실패");
	                    }, success : function(result){
                        	setTable (result);
	                    }
                    });
				}else{
			        sort = 'asc';
			        cell.innerHTML += '▲';
			        $.ajax({
	                    url : '../../php/boardpage.php',
	                    type : 'GET',
	                    data : {call_name:'page_list_search_sort', page: page, searchTag:searchTag ,searchInput: searchInput, order_name:orderName, order_sort:sort},
	                    error : function(){
	                        console.log("실패");
	                    }, success : function(result){
                        	setTable (result);
	                    }
                    });
				}
				/*  st = "boardlist.php?page=2&orderName="+ orderName + "&sort=" + sort;
                    console.log(st);
                    $("#test").attr("href",st);  */
			
            }
            //게시글 검색 리로드때 정렬
            function sortSearchReTable(){
            //console.log("게시글 검색 리로드 확인");
				$('table > thead').find('th').each(function(inx, th) {
			        th.innerHTML = th.innerHTML.replace(/[▼▲]/g, '') ;
			    });
			    if(sort ==='asc'){
			    	sort ='desc';
			    }else{sort ='asc';}
			    
			    if (sort === 'asc') {
			        $("th[value=" + orderName + "]").append('▲');
			        $.ajax({
	                    url : '../../php/boardpage.php',
	                    type : 'GET',
	                    data : {call_name:'page_list_search_sort', page: page, searchTag:searchTag ,searchInput: searchInput, order_name:orderName, order_sort:sort},
	                    error : function(){
	                        console.log("실패");
	                    }, success : function(result){
                        	setTable (result);
	                    }
                    });
			        sort = 'desc';
			    } else{
			        $("th[value=" + orderName + "]").append('▼');
			        $.ajax({
	                    url : '../../php/boardpage.php',
	                    type : 'GET',
	                    data : {call_name:'page_list_search_sort', page: page, searchTag:searchTag ,searchInput: searchInput, order_name:orderName, order_sort:sort},
	                    error : function(){
	                        console.log("실패");
	                    }, success : function(result){
                        	setTable (result);
	                    }
                    });
                    sort = 'asc';
			    }
            }
            
            //게시글 검색
            $("#searchButton").on('click', function(){
                searchTag = $("#searchSelectBox").val();
                searchInput = $("#searchBar").val();
                setSearchPageNav();
            });
            //게시판 목록 set(목록 크기에 맞게 가져오기)
            function setPageData(){
                $.ajax({
                    url : '../../php/boardpage.php',
                    type : 'GET',
                    data : {call_name:'page_list' ,page: page},
                    error : function(){
                        console.log("실패");
                    }, success : function(result){
                        setTable (result);
                    }
                });
            }
            //게시판 검색 목록 set(목록 크기에 맞게 가져오기)
            function setSearchPageData(){
                $.ajax({
                    url : '../../php/boardpage.php',
                    type : 'GET',
                    data : {call_name:'data_list_search' ,page: page, searchTag:searchTag ,searchInput: searchInput},
                    error : function(){
                        console.log("실패");
                    }, success : function(result){
                        setTable (result);
                    }
                });
            }
            //게시판 목록 페이징
            function setPageNav(){
                $.ajax({
                    url : '../../php/boardpage.php',
                    type : 'GET',
                    data : {call_name:'pagination' ,page: page},
                    error : function(){
                        console.log("실패");
                    }, success : function(result){
                        $("#boardTable").children('tbody').empty();
                       //$("#test").append(result);
                        var list = JSON.parse(result);
                        var innerHTML = "";
                        //console.log(list);
                        //console.log(list[0]['s_pageNum']);
                        $("#pagingnav").children('ul').empty();
                        if(orderName !== undefined && sort !== undefined){
			        		sortReTable(orderName, sort);
			        		//console.log(orderName + "-체크");
	                        innerHTML = "<li class='page-item'><a class='page-link' href='boardlist.php?page=1&orderName="+ orderName + "&sort=" + sort + "'>First</a></li>";
	                        $("#pagination").append(innerHTML);
	                        for($print_page = list[0]['s_pageNum']; $print_page <= list[0]['e_pageNum']; $print_page++){
	                            innerHTML = "";
	                            innerHTML += "<li class='page-item'><a class='page-link' href='boardlist.php?page=" + $print_page + "&orderName="+ orderName + "&sort=" + sort +"'>" + $print_page +"</a></li>";
	                            //console.log(innerHTML);
	                            $("#pagination").append(innerHTML);
	                        }
	                        
	                        innerHTML = "<li class='page-item'><a class='page-link' href='boardlist.php?page=" + list[0]['e_pageNum'] + "&orderName="+ orderName + "&sort=" + sort   +"'>Last</a></li>";
	                        $("#pagination").append(innerHTML);
			        	}else if(orderName == undefined && sort == undefined){
	                        innerHTML = "<li class='page-item'><a class='page-link' href='boardlist.php?page=1'>First</a></li>";
	                        $("#pagination").append(innerHTML);
	                        for($print_page = list[0]['s_pageNum']; $print_page <= list[0]['e_pageNum']; $print_page++){
	                            innerHTML = "";
	                            innerHTML += "<li class='page-item'><a class='page-link' href='boardlist.php?page=" + $print_page +"'>" + $print_page +"</a></li>";
	                            //console.log(innerHTML);
	                            $("#pagination").append(innerHTML);
	                        }
	                        
	                        innerHTML = "<li class='page-item'><a class='page-link' href='boardlist.php?page=" + list[0]['e_pageNum'] +"'>Last</a></li>";
	                        $("#pagination").append(innerHTML);
	                        setPageData();
                        }
                    }
                });
            }
            //검색 게시판 목록 페이징
            function setSearchPageNav(){
            	
            	if($('#searchBar').val()){
            		searchTag = $("#searchSelectBox").val();
                	searchInput = $("#searchBar").val();
            	}
            	/*  console.log(page);
	        	console.log(searchTag);
	        	console.log(searchInput);
	        	console.log(orderName);
	        	console.log(sort); */
                $.ajax({
                    url : '../../php/boardpage.php',
                    type : 'GET',
                    data : {call_name:'searchpagination' ,page: page, searchTag:searchTag ,searchInput: searchInput},
                    error : function(){
                        console.log("실패");
                    }, success : function(result){
                        $("#boardTable").children('tbody').empty();
                       //$("#test").append(result);
                        var list = JSON.parse(result);
                        var innerHTML = "";
                        //console.log(list);
                        //console.log(list[0]['s_pageNum']);
                        $("#pagingnav").children('ul').empty();
                        if(orderName !== undefined && sort !== undefined){
                        	sortSearchReTable();
			        		//setSearchPageData();
			        		//console.log("검색 페이징체크");
			        		//console.log(searchInput+"확인");
	                        innerHTML = "<li class='page-item'><a class='page-link' href='boardlist.php?page=1&searchTag="+ searchTag +"&searchInput=" + searchInput + "&orderName="+ orderName + "&sort=" + sort + "'>First</a></li>";
	                        $("#pagination").append(innerHTML);
	                        for($print_page = list[0]['s_pageNum']; $print_page <= list[0]['e_pageNum']; $print_page++){
	                            innerHTML = "";
	                            innerHTML += "<li class='page-item'><a class='page-link' href='boardlist.php?page=" + $print_page + "&searchTag="+ searchTag +"&searchInput=" + searchInput +"&orderName="+ orderName + "&sort=" + sort +"'>" + $print_page +"</a></li>";
	                            //console.log(innerHTML);
	                            $("#pagination").append(innerHTML);
	                        }
	                        innerHTML = "<li class='page-item'><a class='page-link' href='boardlist.php?page=" + list[0]['e_pageNum'] + "&searchTag="+ searchTag +"&searchInput=" + searchInput + "&orderName="+ orderName + "&sort=" + sort   +"'>Last</a></li>";
	                        $("#pagination").append(innerHTML);
			        	}else if(orderName == undefined && sort == undefined){
	                        //console.log("검색 페이징-체크");
	                        innerHTML = "<li class='page-item'><a class='page-link' href='boardlist.php?page=1&searchTag="+ searchTag +"&searchInput=" + searchInput + "'>First</a></li>";
	                        $("#pagination").append(innerHTML);
	                        for($print_page = list[0]['s_pageNum']; $print_page <= list[0]['e_pageNum']; $print_page++){
	                            innerHTML = "";
	                            innerHTML += "<li class='page-item'><a class='page-link' href='boardlist.php?page=" + $print_page + "&searchTag="+ searchTag +"&searchInput=" + searchInput + "'>" + $print_page +"</a></li>";
	                            //console.log(innerHTML);
	                            $("#pagination").append(innerHTML);
	                        }
	                        innerHTML = "<li class='page-item'><a class='page-link' href='boardlist.php?page=" + list[0]['e_pageNum'] +"&searchTag="+ searchTag +"&searchInput=" + searchInput +"'>Last</a></li>";
	                        $("#pagination").append(innerHTML);
	                        setSearchPageData();
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
                var thisRow = $(this).closest('tr'); 
                var deletePk = parseInt(thisRow.find('th').text());
                
                $.ajax({
                url : '../../php/board.php',
                type : 'POST',
                data : {call_name:'delete_post', deletePk:deletePk},
                error : function(){
                console.log("실패");
                }, success : function(result){
                    //$("#test").append(result);
                    location.reload();
                    }
                });
            });
            //게시글 작성
            $(document).on('click', '#boardWrite',function(){
               location.href = 'boardwrite.php'; 
            });
        
        });
    </script>
    </body>
</html>