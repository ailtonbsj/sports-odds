<?php
require('database_conect.php');
include('useful.php');
$hash = $_GET['hash'];
try {
	$stm = $conn->prepare("SELECT * FROM bills WHERE hash = :hash");
	$stm->execute(array(':hash' => $hash));
	$row = $stm->fetchObject();
	$palps = json_decode($row->matchjson);
	$newp = [];
	foreach ($palps as $palp) {
		$staMt = getStatusPalpite($palp[0], $palp[3]);
		$palp = array_merge($palp, $staMt);
		array_push($newp, $palp);
	}
	$row->matchjson = $newp;
	echo json_encode($row);
} catch (Exception $e) {
}
?>