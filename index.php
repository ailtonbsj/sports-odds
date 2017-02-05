<?php
include('strings.php');

// LOG IN

if(isset($_POST['user'])){
   //from from
  $usr = substr($_POST['user'], 0, 16);
  $key = substr($_POST['pass'], 0, 16);
  //from db
  require('database_conect.php');
  $stmt = $conn->prepare('SELECT user,pass,tipo FROM usrs WHERE user = :usr AND pass = :key');
  $stmt->execute(array(':usr' => $usr, ':key' => $key));
  $rowUsr = $stmt->fetch(PDO::FETCH_OBJ);
  //comparing
  if(@$rowUsr->user == $usr){
    session_destroy();
    session_start();
    $_SESSION['user'] = $rowUsr->user;
    $_SESSION['tipo'] = $rowUsr->tipo;
    switch ($_SESSION['tipo']) {
      case 'bank':
        header('Location: bank_dash.php');
        break;
      case 'conf':
        header('Location: conf_dash.php');
        break;
      case 'root':
        header('Location: root_dash.php');
    }
  } else $erro_login = true;
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php
  require('libraries.php');
?>

<title><?= $SYSTEMNAME ?> - Inicio</title>
</head>

<body>

<?php
  require('navbar_main.php');
  require('genbill_platform_public_view.php');
?>

<div id="confirmSaveBill"></div>
<script type="text/javascript">
$(function(){
  $("#menu-home").addClass('active');
});
<?php
  require('genbill_platform_public_crtl.js');
?>
</script>

</body>

</html> 