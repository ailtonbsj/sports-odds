<?php

require('authentication.php');
require('database_conect.php');

function getUrlTeam($teamName){
	//REMOVING TEXT WITH PROBLEM TO QUERY
	$namecls = str_replace("sp.", "", strtolower($teamName));

	$team = urlencode($namecls);
	$urlq = "http://s.flashscore.com/search/?q=" . $team . "&l=31&s=0&f=1;1&pid=401&sid=1";

	$ch = curl_init();
	//Debug with proxy
	//curl_setopt($ch, CURLOPT_PROXY, "http://20.20.0.1:8080");
	//curl_setopt($ch, CURLOPT_PROXYPORT, 8080);
	//curl_setopt ($ch, CURLOPT_PROXYUSERPWD, "aluno:aluno");
	//END Debug with proxy
	curl_setopt($ch, CURLOPT_URL, $urlq);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$html = curl_exec($ch);
	$html = str_replace("cjs.search.jsonpCallback(", "", $html);
	$html = str_replace(");", "", $html);
	$arrurl = json_decode($html);
	if(isset($arrurl->results[0])){
		$linkid = $arrurl->results[0]->id;
		$linkurl = $arrurl->results[0]->url;
		$urlq = "http://www.resultados.com/equipe/$linkurl/$linkid/resultados/";
		return $urlq;
	} else return 'none';
}

$status = 'null';
if(isset($_POST['id_mat'])){
	$id = $_POST['id_mat'];
	$house1 = $_POST['house1'];
	$visit1 = $_POST['visit1'];
	$house2 = $_POST['house2'];
	$visit2 = $_POST['visit2'];
	try {
		$stm = $conn->prepare("UPDATE matchs SET house1 = :house1, visit1 = :visit1, house2 = :house2, visit2 = :visit2 WHERE id_mat = :id");
		$stm->bindParam(':house1', $house1);
		$stm->bindParam(':visit1', $visit1);
		$stm->bindParam(':house2', $house2);
		$stm->bindParam(':visit2', $visit2);
		$stm->bindParam(':id', $id);
		$stm->execute();
		$status = 'nice';	
	} catch (Exception $e) {
		$status = 'erro';
	}	
}

$res = [];
$stm = $conn->prepare("SELECT count(*) FROM matchs WHERE house1 IS NULL");
$stm->execute();
$total = $stm->fetchColumn();

if($total > 0){
	$stm = $conn->prepare("SELECT * FROM matchs WHERE house1 IS NULL");
	$stm->execute();
	$row = $stm->fetchObject();
	$res['total'] = $total;
	$res['id_mat'] = $row->id_mat;
	$name = explode(' X ', $row->name);
	$res['house'] = $name[0];
	$res['visit'] = $name[1];
	$dmy = explode('-', $row->data);
	$res['data'] = $dmy[2].'/'.$dmy[1].'/'.$dmy[0];
	$res['status'] = $status;
	$res['url'] = '404.php';

	$timeUrl = getUrlTeam($name[0]);
	if($timeUrl == 'none') $timeUrl = getUrlTeam($name[1]);

	if($timeUrl != 'none'){
		$res['url'] = $timeUrl;
	}
} else $res['status'] = 'empt';


echo json_encode($res);
?>