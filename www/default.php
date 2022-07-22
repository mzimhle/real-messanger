<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

if(isset($_GET['delete_id'])) {
	// Get the class file
	require_once 'request.php';
	// Get the object
	$requestObject = new Request('member');
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$id						= (int)trim($_GET['delete_id']);
	$success				= $requestObject->delete($id);	

	if($success) {
		$errorArray['error']	= '';
		$errorArray['result']	= 1;			
	} else {
		$errorArray['error']	= 'Could not update, please try again.';
		$errorArray['result']	= 0;				
	}

	echo json_encode($errorArray);
	exit;
}

/* Setup Pagination. */
if(isset($_GET['action']) && trim($_GET['action']) == 'search') {
	// Get the class file
	require_once 'request.php';
	// Get the object
	$requestObject = new Request('member');

	$csv	= 0;
	$start 	= isset($_REQUEST['iDisplayStart']) ? $_REQUEST['iDisplayStart'] : 0;
	$length	= isset($_REQUEST['iDisplayLength']) ? $_REQUEST['iDisplayLength'] : 100;

	$filter = array('filter_search' => (isset($_REQUEST['filter_search']) ? trim($_REQUEST['filter_search']) : ''));

	$requestData = $requestObject->search($start, $length, $filter);

	$request = array();

	if($requestData['code'] == 200) {
		for($i = 0; $i < count($requestData['record']); $i++) {
			$item = $requestData['record'][$i];
			$request[$i] = array(
				'<a href="/member/details.php?id='.trim($item['id']).'">'.trim($item['name']).'</a>',				
				trim($item['cellphone']),
				trim($item['email']),
				"<button onclick=\"deleteModal('".$item['id']."', '', 'default'); return false;\" class='btn'>Delete</button>"
			);
		}
	}

	if($requestData) {
		$response['sEcho']					= $_REQUEST['sEcho'];
		$response['iTotalRecords']			= $requestData['display'];		
		$response['iTotalDisplayRecords']	= $requestData['count'];
		$response['aaData']					= $request;
	} else {
		$response['result']		= false;
		$response['message']	= 'There are no items to show.';			
	}
	echo json_encode($response);
	die();
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php require_once 'includes/meta.php'; ?>    
  </head>
  <body>
	<?php require_once 'includes/header.php'; ?>	
    <div class="slim-mainpanel">
      <div class="container">
        <div class="slim-pageheader">
          <ol class="breadcrumb slim-breadcrumb">
			<li class="breadcrumb-item active" aria-current="page">Member</li>
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
          </ol>
          <h6 class="slim-pagetitle">Member</h6>
        </div><!-- slim-pageheader -->
        <div class="section-wrapper">
		  <label class="section-title">Member List</label>
            <p class="mg-b-20 mg-sm-b-20">Below is a list of Member you have added.</p>
            <div class="row">
                <div class="col-md-12">					
				<div class="row">						
					<div class="col-sm-12">				
						<div class="form-group">
							<label for="filter_search">Search by name</label>
							<input type="text" id="filter_search" name="filter_search" class="form-control" value="" />
						</div>
					</div>
				</div>					
                    <div class="form-group">
                        <button type="button" onclick="getRecords(); return false;" class="btn btn-primary">Search</button>
                        <button class="btn btn-secondary fr" type="button" onclick="link('/member/details.php'); return false;">Add Member</button>
                    </div>
                    <p>There are <span id="result_count" name="result_count" class="success">0</span> records showing. We are displaying <span id="result_display" name="result_display" class="success">0</span> records per page.</p>
                    <div id="tableContent" class="table-responsive" align="center"></div>
                </div>
            </div>
		  <!-- table-wrapper -->
        </div><!-- section-wrapper -->
      </div><!-- container -->
    </div><!-- slim-mainpanel -->
	<?php require_once 'includes/footer.php'; ?>	
    <script type="text/javascript">
    $(document).ready(function() {
        getRecords();
    });

    function getRecords() {
        var html			= '';
        var filter_search	= $('#filter_search').val() != 'undefined' ? $('#filter_search').val() : '';
        /* Clear table contants first. */
        $('#tableContent').html('');
        $('#tableContent').html('<table cellpadding="0" cellspacing="0" width="100%" border="0" class="display" id="dataTable"><thead><tr><th>Name</th><th>Cellphone</th><th>Email</th><th></th></tr></thead><tbody id="contentbody"><tr><td colspan="4" align="center"></td></tr></tbody></table>');	

        oTable = $('#dataTable').dataTable({
            "bJQueryUI": true,
            "aoColumns" : [
                {sWidth: "30%"},
                {sWidth: "30%"},
                {sWidth: "30%"},
				{sWidth: "10%"}
            ],
            "sPaginationType": "full_numbers",							
            "bSort": false,
            "bFilter": false,
            "bInfo": false,
            "iDisplayStart": 0,
            "iDisplayLength": 100,				
            "bLengthChange": false,									
            "bProcessing": true,
            "bServerSide": true,		
            "sAjaxSource": "?action=search&filter_search="+filter_search,
            "fnServerData": function ( sSource, aoData, fnCallback ) {
                $.getJSON( sSource, aoData, function (json) {
                    if (json.result === false) {
                        $('#productbody').html('<tr><td colspan="4" align="center">No results</td></tr>');
                    } else {
                        $('#result_count').html(json.iTotalDisplayRecords);
                        $('#result_display').html(json.iTotalRecords);
                    }
                    fnCallback(json);
                });
            },
            "fnDrawCallback": function(){
            }
        });
        return false;
    }
    </script>
  </body>
</html>
