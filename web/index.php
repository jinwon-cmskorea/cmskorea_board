<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="../jQuery/jquery-3.6.3.min.js"></script>
        <link href="../bootstrap-5.3.1-dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="../bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>

        <style type="text/css">
            .page-link {
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
        <title>테스트 페이지</title>
    </head>
    <body>
    <h2>테스트 페이지 입니다!</h2>
                            <nav aria-label="Page navigation example">
                              <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                  <a class="page-link">First</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                  <a class="page-link" href="#">Last</a>
                                </li>
                              </ul>
                            </nav>
                          <form class="row g-3">
  <div class="col-md-4">
    <label for="validationDefault01" class="form-label">First name</label>
    <input type="text" class="form-control" id="validationDefault01" value="Mark" required>
  </div>
  <div class="col-md-4">
    <label for="validationDefault02" class="form-label">Last name</label>
    <input type="text" class="form-control" id="validationDefault02" value="Otto" required>
  </div>
  <div class="col-md-4">
    <label for="validationDefaultUsername" class="form-label">Username</label>
    <div class="input-group">
      <span class="input-group-text" id="inputGroupPrepend2">@</span>
      <input type="text" class="form-control" id="validationDefaultUsername" aria-describedby="inputGroupPrepend2" required>
    </div>
  </div>
  <div class="col-md-6">
    <label for="validationDefault03" class="form-label">City</label>
    <input type="text" class="form-control" id="validationDefault03" required>
  </div>
  <div class="col-md-3">
    <label for="validationDefault04" class="form-label">State</label>
    <select class="form-select" id="validationDefault04" required>
      <option selected disabled value="">Choose...</option>
      <option>...</option>
    </select>
  </div>
  <div class="col-md-3">
    <label for="validationDefault05" class="form-label">Zip</label>
    <input type="text" class="form-control" id="validationDefault05" required>
  </div>
  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
      <label class="form-check-label" for="invalidCheck2">
        Agree to terms and conditions
      </label>
    </div>
  </div>
  <div class="col-12">
    <button class="btn btn-primary" type="submit">Submit form</button>
  </div>
</form>
<script>
/*
 css and sorting field mark(▼▲).
 */
var data = [
            ['name', 'Java', 'Node', 'Perl'],
            ['Gu', 80, 70, 30],
            ['Kim', 90, 60, 80],
            ['Lee', 70, 70, 70],
            ['Brad', 50, 90, 90]
           ];

$(function() {
    var table = $('<table>').css({'border': '1px solid', 'width': '300px'});
    $('#targetPn').append( table );
    
    $.each(data, function(inx, row ) {
        var tr = $('<tr>');
        table.append(tr);
        $.each(row, function(inx, col ) {
            var td = $('<td>');
            tr.append(td.html(col));
        });
    });
    
    table.find('tr:nth-child(1)').find('td').click(function() {
        sortTable(this);
    });
    table.find('td').css({'border': '1px solid', 'width': '25%'});
});

function sortTable(cell){
    $('table > tr:nth-child(1)').find('td').each(function(inx, td) {
        td.innerHTML = td.innerHTML.replace(/[▼▲]/g, '') ;
    });

    var sortType = jQuery.data( cell, 'sortType');
    if (sortType === 'asc') {
        sortType = 'desc';
        cell.innerHTML += '▼';
    } else{
        sortType = 'asc';
        cell.innerHTML += '▲';
    }
    jQuery.data( cell, 'sortType', sortType);

    var cellIndex = cell.cellIndex;
    var chkSort = true;
    while (chkSort){
        chkSort = false;
        $('table > tr').each(function(inx, row) {
            if (inx===0 || !row.nextSibling) return;
            var fCell = row.cells[cellIndex].innerHTML.toLowerCase();
            var sCell = row.nextSibling.cells[cellIndex].innerHTML.toLowerCase();
            if ( (sortType === 'asc'  && fCell > sCell) 
              || (sortType === 'desc' && fCell < sCell) ) {
                $( row.nextSibling ).insertBefore( $(row) );
                chkSort = true;
            }
        });
    }
}

</script>
    <div id='targetPn' style='width:130px'>
    </div>
    </body>
</html>