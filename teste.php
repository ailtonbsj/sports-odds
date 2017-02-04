<?php

function atualizaCampPremio(){
	require('database_conect.php');
	$stm = $conn->prepare("SELECT * FROM bills");
	$stm->execute();
	while($row = $stm->fetchObject()){
		$part_apos = json_decode($row->matchjson);
		$produto = 1.0;
		foreach ($part_apos as $v) {
			$produto *= $v[4];
		}
		$premio = $produto * ((float)$row->valor);
		$stmUp = $conn->prepare("UPDATE bills SET premio = '$premio' WHERE hash = '".$row->hash."'");
		$stmUp->execute();
	}
}

//atualizaCampPremio();

require('database_conect.php');
$datanow = date("Y-m-d H:i:s");
echo $datanow;

?>