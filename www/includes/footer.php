<script type="text/javascript" src="/library/javascript/jquery.js"></script>
<script type="text/javascript" src="/library/javascript/jquery-ui-1.10.3.js"></script>
<script type="text/javascript" src="/library/javascript/bootstrap.js"></script>
<script type="text/javascript" src="/library/javascript/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="Javascript">
function link(url) {
    window.location.href = url;
}

function deleteitem() {
    
    var id 		= $('#itemcode').val();
    var page 	= $('#itempage').val();
    var code 	= $('#maincode').val();
    
    $.ajax({
        type: "GET",
        url: page+".php",
        data: "delete_id="+id+(code != '' ? '&id='+code : ''),
        dataType: "json",
        success: function(data){
            if(data.result == 1) {
				if(typeof oTable != 'undefined') {
					$('#deleteModal').modal('hide');						
					oTable.fnDraw();
				} else {
					window.location.href = window.location.href;
				}
            } else {
                $('#deleteModal').modal('hide');
                if(typeof oTable != 'undefined') {
                    oTable.fnDraw();
                }							
            }
        }
    });
    
    return false;
}

function deleteModal(id, code, page) {
    $('#itemcode').val(id);
    $('#maincode').val(code);
    $('#itempage').val(page);
    $('#deleteModal').modal('show');
    return false;
}

</script>
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Delete Item</h4>
			</div>
			<div class="modal-body">Are you sure you want to delete this item?</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:deleteitem();">Delete Item</button>
				<input type="hidden" id="itemcode" name="itemcode" value=""/>
				<input type="hidden" id="itempage" name="itempage" value=""/>
				<input type="hidden" id="maincode" name="maincode" value=""/>
			</div>
		</div>
	</div>
</div>
<!-- modal -->
