<div class="row-fluid">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
		  <div class="panel-heading">LOGIN ADMIN</div>
		  <div class="panel-body">
		    <form id="login" class="form-horizontal" role="form">
		    <div id="response"></div>
			  <div class="form-group">
			    <label class="col-sm-2 control-label">Email</label>
			    <div class="col-sm-10">
			      <input name="email" type="email" class="form-control" id="" placeholder="Email">
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="col-sm-2 control-label">Password</label>
			    <div class="col-sm-10">
			      <input name="password" type="password" class="form-control" id="" placeholder="Password">
			    </div>
			  </div>
			  <div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      <div class="checkbox">
			        <label>
			          <input type="checkbox"> Remember me
			        </label>
			      </div>
			    </div>
			  </div>
			  <div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      <button type="submit" class="btn btn-default">Sign in</button>
			    </div>
			  </div>
			</form>
		  </div>
		</div>
	</div>
</div>

<script type="text/javascript">
   $(function(){
       $("#login").submit(function(event){
          event.preventDefault();
          dataString = $("#login").serialize();
          $.ajax({
           type: "POST",
           url: "<?php echo base_url('login/isLogin'); ?>",
           dataType: "json",
           data: dataString,
           success: function(data){
            if (data.response == 'failed') {
                msg = '<div class="alert alert-warning alert-dismissible" role="alert">' +
                      '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                      '<strong>Warning! </strong>' + data.message + '</div>'
                $('#response').html(msg);
            } else {
                msg = '<div class="alert alert-success alert-dismissible" role="alert">' +
                      '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                      '<strong>Success! </strong>' + data.message + '</div>'
                $('#response').html(msg);
                $('#btnlogin').addClass("disabled");
                setInterval(function() {
                  uri = data.redirect;
                  self.location = uri;
                }, 1000);
            }
           }
         });
         return false;
      });
   });
</script>