<?php
require('authentication.php');
if($_SESSION['tipo'] != 'root') header('Location: logoff.php');

require('database_conect.php');

$sql = "SELECT user,name,cpf,tipo,saldo FROM usrs";
$res=[];
try {
	$stm = $conn->prepare($sql);
	$stm->execute();
	while($row = $stm->fetchObject()){
		array_push($res,$row);
	}
} catch(PDOException $e){
	exit();
}
echo json_encode($res);
?>