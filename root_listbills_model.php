<?php
session_start();
if(!isset($_SESSION['user'])) exit();

if(isset($_POST['q'])){
	$q = @mysql_real_escape_string(substr($_POST['q'], 0, 40));
}
if(isset($_POST['s'])){
	$s = $_POST['s'];
}
if(isset($_POST['cb_dtini'])){
	$isDtIni = $_POST['cb_dtini'] == 'true' ? true : false;
	$dtIni = $_POST['dtini'];
}
if(isset($_POST['cb_dtend'])){
	$isDtEnd = $_POST['cb_dtend'] == 'true' ? true : false;
	$dtEnd = $_POST['dtend'];
}

require('database_conect.php');
$res = [];
$user = $_POST['bk'];
if($user == ""){
	$user = 'root';
	$sql = "SELECT * FROM bills WHERE user != :user";
} else $sql = "SELECT * FROM bills WHERE user = :user";

$sqlB = array('user' => $user);
try {
	if($q != ""){
		$sql.=" AND ((hash LIKE :q) OR (matchjson LIKE :q) OR (apostador LIKE :q))";
		$sqlB = array_merge($sqlB, array('q' => "%$q%"));	
	}
	if($s != ""){
		$sql.=" AND estado = :s";
		$sqlB = array_merge($sqlB, array('s' => $s));
	}
	if($isDtIni){
		$sql.=" AND data_criado > :dtini";
		$sqlB = array_merge($sqlB, array('dtini' => $dtIni));
	}
	if($isDtEnd){
		$sql.=" AND data_criado < :dtend";
		$sqlB = array_merge($sqlB, array('dtend' => $dtEnd));
	}
	$sql .= " ORDER BY data_criado  DESC";
	$stm = $conn->prepare($sql);
	$stm->execute($sqlB);
	while($row = $stm->fetchObject()){
		$row->valor = number_format((float)$row->valor, 2, ',', '');
		$row->premio = number_format((float)$row->premio, 2, ',', '');;
		array_push($res,$row);
	}
} catch(PDOException $e){
	exit();
}
echo json_encode($res);
?>