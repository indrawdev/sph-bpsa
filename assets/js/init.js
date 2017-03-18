		function simpan_sph() {
			$.ajax({
				url: "<?php echo site_url('sph/simpan') ?>",
				type: 'POST',
				dataType: 'json',
				data: $('#sph').serialize(),
				encode:true,
				success:function(data) {
					if(!data.success){
						if(data.errors){
							$('#message').html(data.errors).addClass('alert alert-danger');
						}
					}else {
						alert(data.message);
						setTimeout(function() {
							window.location.reload()
						}, 400);
					}
				}
			})
		}
		function ubah_mhs() {
			$.ajax({
				url: "<?php echo site_url('sph/ubah_sph') ?>",
				type: 'POST',
				dataType: 'json',
				data: $('#sph').serialize(),
				encode:true,
				success:function (data) {
					if(!data.success){
						$('#message').html(data.errors).addClass('alert alert-danger');
					}else {
						alert(data.message);
						setTimeout(function () {
							window.location.reload();
						}, 400);
					}
				}
			})
		}
		function ubah(id) {
			$.ajax({
				url: "<?php echo site_url('sph/tampil_ubah/') ?>",
				type: 'POST',
				dataType: 'json',
				data: 'id='+id,
				encode:true,
				success:function (data) {
					$('.save').attr('disabled', true);
					$('.update').removeAttr('disabled');
					$('input[name="nim"]').val(data.nim);
					$('input[name="nama"]').val(data.nama);
					$('select[name="kelamin"]').val(data.kelamin);
					$('input[name="telp"]').val(data.telp);
					$('textarea[name="alamat"]').val(data.alamat);
				}
			})
		}
		function hapus(id) {
			if(confirm('Anda yakin mau menghapus ??')){
				$.ajax({
					url: "<?php echo site_url('sph/hapus_data/') ?>",
					type: 'POST',
					dataType: 'json',
					data: 'id='+id,
					encode:true,
					success:function(data) {
						if(!data.success){
							if(data.errors){
								$('#message').html(data.errors).addClass('alert alert-danger');
							}
						}else {
							$('#message').html(data.message).addClass('alert alert-success').removeClass('alert alert-danger');
							setTimeout(function() {
								window.location.reload();
							}, 400);
						}
					}
				});
			}
		}
		/*$('#data_sph').DataTable({
			"ajax":{
				"url":"<?php echo site_url('sph/tampil_data') ?>",
				"type":"POST"
			}
		})*/
		   	$(function () {
                $('#datetimepicker1').datetimepicker();
            });