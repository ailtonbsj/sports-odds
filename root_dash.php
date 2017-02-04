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

<title><?= $SYSTEMNAME ?> - Admin</title>
</head>

<body>

<?php
  require('navbar_main.php');
  require('root_dash_view.php');
  require('root_dash_view.php');
?>

<div id="confirmSaveBill"></div>
<script type="text/javascript">
<?php
  require('root_dash_ctrl.js');
?>
</script>

</body>

</html> 