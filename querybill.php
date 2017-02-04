<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php
  include('strings.php');
	require('libraries.php');
?>

<title><?= $SYSTEMNAME ?></title>
<style type="text/css">
  #apostas-menu a {
    display: none;
  }
  #nav-apostas {
    margin-right: 0;
  }
  hr {
  	margin: 5px 0 5px 0;
  	padding: 0;
  }
</style>
</head>
<body>
<?php
	require('navbar_main.php');
	require('querybill_view.php');
?>
<script type="text/javascript">
<?php
	require('querybill_ctrl.js');
  if(isset($_GET['hash'])){
    $hash = $_GET['hash'];
?>
$(function(){
  $('#in-query').val('<?= $hash ?>');
  $("#bt-query").click();
});
<?php
  }
?>
</script>
</body>
</html>