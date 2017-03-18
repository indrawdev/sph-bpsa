<div class="row-fluid">
	<div class="col-md-12">
	<button class="btn btn-success" onclick="add()"><i class="glyphicon glyphicon-plus"></i> Add Data</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <br />
        <br />
		<div id="dataUser">
			 <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Level</th>
					<th>Status</th>
                    <th style="width:125px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
		</div>
	</div>
</div>
<script type="text/javascript">
var table;
var save_method;
	$(document).ready(function() {
		table = $('#table').DataTable({
			"processing" : true,
			"serverSide" : true,
			"order" : [],
			"ajax": {
				"url" : "<?php echo base_url('user/ajax_list'); ?>",
				"type" : "POST"
			},
			"columnDefs" : [{
				"targets" : [-1],
				"orderable" : false,
			},],
		});
	});

	function add() {
		save_method = 'add';
		$('#form')[0].reset();
		$('.form-group').removeClass('has-error');
		$('.help-block').empty();
		$('#modal_form').modal('show');
		$('.modal-title').text('Add Data');
	}

	function edit(id) {
		save_method = 'update';
		$('#form')[0].reset();
		$('.form-group').removeClass('has-error');
		$('.help-block').empty();
		$.ajax({
			url : "<?php echo base_url('user/ajax_edit/'); ?>" + id,
			type : "GET",
			dataType : "JSON",
			success: function(data) {
				$('[name="user_id"]').val(data.user_id);
	            $('[name="email"]').val(data.email);
	            $('[name="level_id"]').val(data.level_id);
	            $('[name="active"]').val(data.active);

				$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            	$('.modal-title').text('Edit Data'); // Set title to Bootstrap modal title

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}	
		});
	}

	function reload_table() {
		table.ajax.reload(null,false);
	}

	function save() {
		$('#btnSave').text('saving...');
		$('#btnSave').attr('disabled', true);
		
		var url;

		if(save_method == 'add') {
        	url = "<?php echo base_url('user/ajax_add'); ?>";
	    } else {
	        url = "<?php echo base_url('user/ajax_update'); ?>";
	    }

	    $.ajax({
	    	url: url,
	    	type: "POST",
	    	data: $('#form').serialize(),
	    	dataType: "JSON",
	    	success: function(data) {
	    		if(data.response == 'failed') {
	                msg = '<div class="alert alert-warning alert-dismissible" role="alert">' +
	                      '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
	                      '<strong>Warning! </strong>' + data.message + '</div>'
	                $('#response').html(msg);  
	    		} else {
	    			$('#modal_form').modal('hide');
	    			reload_table();	    			
	    		}
	    		$('#btnSave').text('Save');
	    		$('#btnSave').attr('disabled', false);
	    	},
	    	error: function (jqXHR, textStatus, errorThrown) {
	    		alert('Error adding / update data');
            	$('#btnSave').text('Save'); //change button text
            	$('#btnSave').attr('disabled', false); //set button enable 
	    	}
	    });

	}

	function del(id) {
		if (confirm('Yakin dihapus?')) {
			
			$.ajax({
				url : "<?php echo base_url('user/ajax_delete/'); ?>" + id,
				type : "POST",
				dataType : "JSON",
				success : function(data) {
					$('#modal_form').modal('hide');
					reload_table();
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert('Error deleting data');
				}
			});
		}
	}

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Pengguna</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="">
                  <div id="response"></div>
	 			  <div class="form-group">
				    <label for="" class="control-label">Level User</label>
				    <select name="level_id" class="form-control">
				    	<option value="">Pilih</option>
						<option value="1">Admin</option>
						<option value="2">Marketing</option>
				    </select>
				  </div>
	 			  <div class="form-group">
				    <label for="" class="control-label">Email</label>
				    <input name="email" type="email" class="form-control" id="" placeholder="">
				  </div>
				  <div class="form-group">
				    <label for="" class="control-label">Password</label>
				    <input name="password" type="password" class="form-control" id="" placeholder="">
				  </div>
				  <div class="form-group">
				    <label for="" class="control-label">Confirm Password</label>
				    <input name="confirm_pass" type="password" class="form-control" id="" placeholder="">
				  </div>
				  <div class="form-group">
				    <label for="" class="control-label">Status</label>
				    <select name="active" class="form-control">
				    	<option value="">Pilih</option>
						<option value="Y">YA</option>
						<option value="T">TIDAK</option>
				    </select>
				  </div>
				  <input type="hidden" value="" name="user_id"/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary btn-lg btn-block">Save</button>
                <button type="button" class="btn btn-danger btn-lg btn-block" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->