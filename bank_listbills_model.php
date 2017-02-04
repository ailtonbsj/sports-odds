<?php
session_start();
if(!isset($_SESSION['user'])) exit();
$user = $_SESSION['user'];

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

////////////
$res = [];
//Refreshing status bills
$stm = $conn->prepare("SELECT * FROM bills WHERE user = :user");
$stm->execute(array('user' => $user));
while($row = $stm->fetchObject()){
	if($row->estado > 1) continue;

	$part_apos = json_decode($row->matchjson);
	$toClose = false;
	$toFinish = true;
	foreach ($part_apos as $k => $partidas) {
		$dataM = DateTime::createFromFormat('d/m/Y H:i:s', $partidas[2]);
		$dataN = DateTime::createFromFormat('d/m/Y H:i:s', date("d/m/Y H:i:s"));
		$dataM->sub(new DateInterval('PT1H30M'));
		if($dataN >= $dataM) $toClose = true;
		else $toFinish = false;
	}
	
	if($toFinish){
		//processing gain or lose
		$isNull = false;
		$isInvalid = false;
		$isAllGain = true;
		foreach ($part_apos as $k => $partidas) {
			$stmResMat = $conn->prepare("SELECT * FROM matchs WHERE id_mat = :id");
			$stmResMat->execute(array('id' => $partidas[0]));
			$resMat = $stmResMat->fetchObject();
			if( is_null(@$resMat->house1) ||
				is_null(@$resMat->visit1) ||
				is_null(@$resMat->house2) ||
				is_null(@$resMat->visit2)){
				$isNull = true;
				continue;
			}
			$hs1 = $resMat->house1;
			$vs1 = $resMat->visit1;
			$hs2 = $resMat->house2;
			$vs2 = $resMat->visit2;
			$hs = $hs1 + $hs2;
			$vs = $vs1 + $vs2;
			//Final
			$isCasa = ($hs > $vs) ? true : false;
			$isEmpate = ($hs == $vs) ? true : false;
			$isFora = ($hs < $vs) ? true : false;
			//1o tempo
			$isFirstCasa = ($hs1 > $vs1) ? true : false;
			$isFirstEmpate = ($hs1 == $vs1) ? true : false;
			$isFirstFora = ($hs1 < $vs1) ? true : false;
			//2o tempo
			//1o tempo
			$isSecCasa = ($hs2 > $vs2) ? true : false;
			$isSecEmpate = ($hs2 == $vs2) ? true : false;
			$isSecFora = ($hs2 < $vs2) ? true : false;

			$jogo = $partidas[3];
			$tkTraco = explode(' - ', $jogo);
			$tkParen = explode(' (', $jogo);
			$gain = false;
			if($jogo == 'Casa'){
				if($isCasa) $gain = true;
			}elseif($jogo == 'Empate'){
				if($isEmpate) $gain = true;
			}elseif($jogo == 'Fora'){
				if($isFora) $gain = true;
			}elseif($jogo == 'Casa ou Fora'){
				if($isCasa || $isFora) $gain = true;
			}elseif($jogo == 'Casa ou Empate'){
				if($isCasa || $isEmpate) $gain = true;
			}elseif($jogo == 'Fora ou Empate'){
				if($isFora || $isEmpate) $gain = true;
			}elseif($jogo == 'Ambas Marcam'){
				if($hs > 0 && $vs > 0) $gain = true;
			}elseif($jogo == 'Apenas 1 marca'){
				if(($hs > 0 && $vs == 0) || ($hs == 0 && $vs > 0)) $gain = true;
			}elseif($jogo == 'Total de Gols Par'){
				if( ($hs+$vs) % 2 == 0 ) $gain = true;
			}elseif($jogo == 'Total de Gols Ímpar'){
				if( ($hs+$vs) % 2 != 0 ) $gain = true;
			}elseif($tkTraco[0] == 'Jogo'){
				$tk = explode(' ', $tkTraco[1]);
				if($tk[0] == 'Acima'){
					if( ($hs+$vs) > $tk[1] ) $gain = true;
				}elseif($tk[0] == 'Abaixo'){
					if( ($hs+$vs) < $tk[1] ) $gain = true;
				}
			}elseif($tkParen[0] == 'Resultado Exato'){
				$tk = explode(' : ', $tkParen[1]);
				if( ($tk[0] == $hs) && ($tk[1] == $vs) ) $gain = true;
			}elseif($tkParen[0] == 'Intervalo | Final'){
				$tk = explode(' | ', $tkParen[1]);
				$int = $tk[0];
				$fin = explode(')', $tk[1])[0];
				$intRes = '';
				$finRes = '';
				if($isFirstCasa) $intRes = 'Casa';
				elseif($isFirstEmpate) $intRes = 'Empate';
				elseif($isFirstFora) $intRes = 'Fora';
				if($isCasa) $finRes = 'Casa';
				elseif($isEmpate) $finRes = 'Empate';
				elseif($isFora) $finRes = 'Fora';
				if( ($int == $intRes) && ($fin == $finRes) ) $gain = true; 
			}elseif($tkTraco[0] == '1º Tempo'){
				if($tkTraco[1] == 'Casa'){
					if($isFirstCasa) $gain = true;
				}elseif($tkTraco[1] == 'Empate'){
					if($isFirstEmpate) $gain = true;
				}elseif($tkTraco[1] == 'Fora'){
					if($isFirstFora) $gain = true;
				}elseif($tkTraco[1] == 'Casa ou Fora'){
					if($isFirstCasa || $isFirstFora) $gain = true;
				}elseif($tkTraco[1] == 'Casa ou Empate'){
					if($isFirstCasa || $isFirstEmpate) $gain = true;
				}elseif($tkTraco[1] == 'Fora ou Empate'){
					if($isFirstFora || $isFirstEmpate) $gain = true;
				}
			}elseif($tkTraco[0] == '2º Tempo'){
				if($tkTraco[1] == 'Casa'){
					if($isSecCasa) $gain = true;
				}elseif($tkTraco[1] == 'Empate'){
					if($isSecEmpate) $gain = true;
				}elseif($tkTraco[1] == 'Fora'){
					if($isSecFora) $gain = true;
				}elseif($tkTraco[1] == 'Casa ou Fora'){
					if($isSecCasa || $isSecFora) $gain = true;
				}elseif($tkTraco[1] == 'Casa ou Empate'){
					if($isSecCasa || $isSecEmpate) $gain = true;
				}elseif($tkTraco[1] == 'Fora ou Empate'){
					if($isSecFora || $isSecEmpate) $gain = true;
				}
			}

			else {
				$isInvalid = true;
				continue;
			}
			if(!$gain) $isAllGain = false;
		}
		if(!$isAllGain) $codeSta = 2;
		elseif($isInvalid) $codeSta = 6;
		elseif($isNull) $codeSta = 1;
		else $codeSta = 3;

		$sql = "UPDATE bills SET estado = '$codeSta' WHERE hash = :hash";
		$stm2 = $conn->prepare($sql);
		$stm2->execute(array('hash' => $row->hash));

	} elseif($toClose){
		//QUERY TO CLOSE BILL
		$sql = "UPDATE bills SET estado = '1' WHERE hash = :hash";
		$stm2 = $conn->prepare($sql);
		$stm2->execute(array('hash' => $row->hash));
	}
}
///////////
$res = [];
$sql = "SELECT * FROM bills WHERE user = :user";
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