<!doctype html>
<html>
<head>
    <title><?php echo $this->template->title->default("Default title"); ?></title>
    <meta charset="utf-8">
    <meta name="description" content="<?php echo $this->template->description; ?>">
    <?php echo $this->template->meta; ?>
    <?php echo $this->template->stylesheet; ?>
    <style type="text/css">
        .copyright {
            text-align: center;
        }
    </style>
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.ico'); ?>" type="image/x-icon">
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
</head>
<body>

<?php 
    // This is an example to show that you can load stuff from inside the template file
    echo $this->template->widget("navigation", array('title' => 'PT. BSPA'));
?>

<div class="container-fluid" style="margin-top: 80px;">

  <?php
    echo $this->template->content;
  ?>


</div>
<br />
<footer class="main-footer">
    <div class="container-fluid">
        <p class="copyright">
            <?php echo $this->template->footer->prepend("Copyright &copy; PT. BSPA - " . date('Y')); ?>
        </p>
    </div>
</footer>

<?php echo $this->template->javascript; ?>

</body>
</html>