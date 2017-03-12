<?php

include('useful.php');
include('strings.php');

session_start();
if(!isset($_SESSION['user'])) exit();
$user = $_SESSION['user'];
if(!(isset($_POST['value']) && isset($_POST['bill']))) exit();
$val = $_POST['value'];
$name = removeAcentos($_POST['name']);
$billraw = $_POST['bill'];
$bill = json_decode($billraw);

$valf = floatval(str_replace(',', '.', $val));
if(!is_numeric($valf)) exit();
if($valf < 2) exit();

$ch = curl_init();
//Debug with proxy
//curl_setopt($ch, CURLOPT_PROXY, "http://20.20.0.1:8080");
//curl_setopt($ch, CURLOPT_PROXYPORT, 8080);
//curl_setopt ($ch, CURLOPT_PROXYUSERPWD, "aluno:aluno");
//END Debug with proxy
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$produto = 1.0;
foreach ($bill as $index => $aposta) {
	$bill[$index][1] = removeAcentos($bill[$index][1]);
	curl_setopt($ch, CURLOPT_URL, "{$SITEAPI}/futebolapi/api/VJogoOdds/" . $aposta[5]);
	$jsonstr = curl_exec($ch);
	$seg = json_decode($jsonstr);
	if($seg->taxa != $aposta[4]){
		exit();
	}
	$produto *= floatval($aposta[4]);
}
$premio = $produto*$valf;
if($premio >= 500*$valf){
	exit();
} else if($premio >= 5000){
	exit();
}
$billraw = json_encode($bill);
curl_close($ch);
require('database_conect.php');
$datanow = date("YmdHis") . rand();
$has = sha1($datanow);
$dateSQL = date("Y-m-d H:i:s");
try {
	$stm = $conn->prepare("INSERT INTO bills (user,matchjson,valor,apostador,hash, premio, data_criado) VALUES (:user, :json, :val, :name, :hash, :premio, :data)");
	$stm->bindParam(':user', $user);
	$stm->bindParam(':json', $billraw);
	$stm->bindParam(':val', $valf);
	$stm->bindParam(':name', $name);
	$stm->bindParam(':hash', $has);
	$stm->bindParam(':premio', $premio);
	$stm->bindParam(':data', $dateSQL);
	$stm->execute();
} catch(PDOException $e){
	exit();
}
$result = array('state' => 'SUCCESS', 'hash' => $has, 'date' => date("d/n/Y H:i:s"));
echo json_encode($result);
?>