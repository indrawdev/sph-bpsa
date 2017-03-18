<div class="row-fluid">
	<div class="col-md-12">
	<button class="btn btn-success" onclick="add()"><i class="glyphicon glyphicon-plus"></i> Add Data</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <br />
        <br />
		<div id="dataSph">
			 <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Tujuan</th>
                    <th>Lokasi</th>
                    <th>Perihal</th>
					<?php

					?>
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
				"url" : "<?php echo base_url('sph/ajax_list'); ?>",
				"type" : "POST"
			},
			"columnDefs" : [{
				"targets" : [-1],
				"orderable" : false,
			},],
		});

		$('.datepicker').datepicker({
			autoclose: true,
			format: "yyyy-mm-dd",
			todayHighlight: true,
			orientation: "top",
			todayBtn: true,
			todayHighlight: true,
		});
	});

	function add() {
		save_method = 'add';
		var no_sph = '<?php echo $getNo; ?>';
		$('#form')[0].reset();
		$('.form-group').removeClass('has-error');
		$('.help-block').empty();
		$('#modal_form').modal('show');
		$('.modal-title').text('Tambah SPH');
		$('[name="nomor_sph"]').val(no_sph);
	}

	function edit(id) {
		save_method = 'update';
		$('#form')[0].reset();
		$('.form-group').removeClass('has-error');
		$('.help-block').empty();
		$.ajax({
			url : "<?php echo base_url('sph/ajax_edit/'); ?>" + id,
			type : "GET",
			dataType : "JSON",
			success: function(data) {
				$('[name="sph_id"]').val(data.sph_id);
	            $('[name="nomor_sph"]').val(data.nomor_sph);
	            $('[name="tanggal_sph"]').val(data.tanggal_sph);
	            $('[name="tujuan_sph"]').val(data.tujuan_sph);
	            $('[name="lokasi_sph"]').val(data.lokasi_sph);
	            $('[name="perihal_sph"]').val(data.perihal_sph);
	            $('[name="jumlah"]').val(data.jumlah);
	            //$('[name="file_sph"]').val(data.file_sph);
	            //$('[name="file_supplier"]').val(data.file_supplier);

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

	function reload_page() {
		location.reload();
	}

	function save() {
		$('#btnSave').text('Saving...');
		$('#btnSave').attr('disabled', true);
		
		var url;

		if(save_method == 'add') {
        	url = "<?php echo base_url('sph/ajax_add'); ?>";
	    } else {
	        url = "<?php echo base_url('sph/ajax_update'); ?>";
	    }

	    $.ajax({
	    	url : url,
	    	type : "POST",
	    	data: $('#form').serialize(),
	    	dataType: "JSON",
			mimeType: 'multipart/form-data',
	    	success: function(data) {
	    		if(data.response == 'failed') {
	                msg = '<div class="alert alert-warning alert-dismissible" role="alert">' +
	                      '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
	                      '<strong>Warning! </strong>' + data.message + '</div>'
	                $('#response').html(msg);  
	    		} else {
	    			$('#modal_form').modal('hide');
	    			reload_page();			
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
				url : "<?php echo base_url('sph/ajax_delete/'); ?>" + id,
				type : "POST",
				dataType : "JSON",
				success : function(data) {
					$('#modal_form').modal('hide');
					reload_page();
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
                <h3 class="modal-title">SPH</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="" enctype="multipart/form-data">
                  <div id="response"></div>
	 			  <div class="form-group">
				    <label for="" class="control-label">Nomor SPH</label>
				    <input name="nomor_sph" type="text" class="form-control" value="<?php echo $getNo; ?>">
				  </div>
				  <div class="form-group">
				    <label for="" class="control-label">Tanggal</label>
	                <div class='input-group date'>
	                    <input name="tanggal_sph" type="text" class="form-control datepicker" />
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="" class="control-label">Tujuan</label>
				    <input name="tujuan_sph" type="text" class="form-control" id="" placeholder="">
				  </div>
				  <div class="form-group">
				    <label for="" class="control-label">Lokasi</label>
				    <input name="lokasi_sph" type="text" class="form-control" id="" placeholder="">
				  </div>
				  <div class="form-group">
				    <label for="" class="control-label">Perihal</label>
				    <input name="perihal_sph" type="text" class="form-control" id="" placeholder="">
				  </div>
				  <div class="form-group">
				    <label for="" class="control-label">Jumlah Harga</label>
				    <input name="jumlah" type="text" class="form-control" id="" placeholder="">
				  </div>
				  <div class="form-group">
				    <label for="" class="control-label">Lampiran SPN</label>
				    <input name="file_sph" type="file">
					<p class="">Maks 2MB</p>
				  </div>
				  <div class="form-group">
				    <label for="" class="control-label">Lampiran Supplier</label>
				    <input name="file_supplier" type="file">
					<p class="">Maks 2MB</p>
				  </div>
				  <div class="form-group">
				  	<label for="" class="control-label">Status</label>
					<div class="radio">
					  <label>
					    <input type="radio" name="active" value="Y" checked> AKTIF
					  </label>
					</div>
					<div class="radio">
					  <label>
					    <input type="radio" name="active" value="N"> TIDAK AKTIF
					  </label>
					</div>
					<input type="hidden" name="sph_id">
				  </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary btn-lg btn-block">Save</button>
                <button type="button" class="btn btn-danger btn-lg btn-block" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->