<?php
include('strings.php');
session_start();
if(!isset($_SESSION['user'])) exit();
$user = $_SESSION['user'];
if(!isset($_GET['id'])) exit();
$hash = $_GET['id'];
require('database_conect.php');

$stm = $conn->prepare("SELECT * FROM bills WHERE hash = :hash");
$stm->execute(array('hash' => $hash));
$bill = $stm->fetchObject();
$apost = $bill->apostador;
$dtr = $bill->data_criado;
$dt = explode(' ',$dtr);
$d = explode('-',$dt[0]);
$dt = $d[2].'/'.$d[1].'/'.$d[0].' '.$dt[1]; 
echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx\r\n\r\n";
echo "       $SYSTEMNAME\r\n";
echo " $HUMANDOMAIN\r\n";
echo " BANCA: $user\r\n";
echo " APOSTADOR: $apost\r\n";
echo " DATA: $dt\r\n\r\n";
$th = explode(' ',chunk_split($hash,10,' '));

echo "     ".$th[0].' '.$th[1]."\r\n     ".$th[2].' '.$th[3]."\r\n";

echo "--------------------------------\r\n";
echo "        SUAS APOSTAS            \r\n";
echo "--------------------------------\r\n";

$palps = json_decode($bill->matchjson);
$premio = 1;
foreach ($palps as $palp) {
	echo $palp[1] . "\r\n";
	echo $palp[2] . "\r\n";
	echo "PALPITE: " . $palp[3] . " - " . $palp[4];
	echo "\r\n--------------------------------\r\n";
	$premio *= $palp[4];
}
echo "TOTAL DE JOGOS: " . count($palps);
$pagado = number_format($bill->valor,2);
echo "\r\nVALOR APOSTADO: R$ " . $pagado;
echo "\r\nPREMIACAO: R$ " . number_format(($premio*$bill->valor),2);
echo "\r\n\r\nxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";

header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"$apost$pagado.txt\"")
?>