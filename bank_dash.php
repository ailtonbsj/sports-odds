<?php
include('strings.php');
require('authentication.php');
if($_SESSION['tipo'] != 'bank') header('Location: logoff.php');

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php
  require('libraries.php');
?>

<title><?= $SYSTEMNAME ?> - Banca</title>
</head>

<body>

<?php
  require('navbar_main.php');
  require('genbill_platform_public_view.php');
  require('genbill_platform_private_view.php');
?>

<div id="confirmSaveBill"></div>
<script type="text/javascript">
<?php
  require('genbill_platform_public_crtl.js');
  require('genbill_platform_private_crtl.js');
?>
</script>

</body>

</html> 