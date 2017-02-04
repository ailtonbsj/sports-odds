<?php
include('strings.php');
require('authentication.php');
if($_SESSION['tipo'] != 'root') header('Location: logoff.php');

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php
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
	require('root_listbills_view.php');
?>
<script type="text/javascript">
<?php
	require('root_listbills_ctrl.js');
?>
</script>
</body>
</html>