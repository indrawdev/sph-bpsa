<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand pull-left" href="<?php echo base_url(); ?>"><?php echo $title; ?></a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <?php
        if ($this->session->userdata('login') == TRUE) {
      ?>
      <ul class="nav navbar-nav">
          <li><a href="sph">SPH</a></li>
          <li><a href="user">User</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo base_url('user/logout'); ?>">Logout</a></li>
      </ul>
      <?php 
        }
      ?>
    </div>
  </div>
</nav>

