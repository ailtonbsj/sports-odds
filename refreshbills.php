<?php

require('database_conect.php');

$stm = $conn->prepare("SELECT * FROM bills");
$stm->execute();

while($row = $stm->fetchObject()){
	$part_apos = json_decode($row->matchjson);
	foreach ($part_apos as $k => $partidas) {
		$dataM = DateTime::createFromFormat('d/m/Y H:i:s', $partidas[2]);
		$dataN = DateTime::createFromFormat('d/m/Y H:i:s', date("d/m/Y H:i:s"));
		$dataM->add(new DateInterval('PT1H30M'));
		if($dataN > $dataM){
			try {
				$stm2 = $conn->prepare("INSERT INTO matchs (id_mat, name, data) VALUES (:id, :name, :data)");
				$stm2->bindParam(':id', $partidas[0]);
				$stm2->bindParam(':name', $partidas[1]);
				$dataM = DateTime::createFromFormat('d/m/Y H:i:s', $partidas[2]);
				$stm2->bindParam(':data', $dataM->format('Y-m-d'));
				$stm2->execute();	
			} catch (Exception $e) {
			}	
		}
	}
}

?>