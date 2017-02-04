<?php

/* Remove Acentos e aspas simples, menos Aspas duplas */
function removeAcentos($string){
	//preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $string ) );
	return preg_replace( '/[`^~\']/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $string ) );
}


////////////////////////////////

/* get Status of Palpite */
function getStatusPalpite($idMat, $typePal){
	require('database_conect.php');
	$jogo = $typePal;
	$out = 'INVALID';
	$stmResMat = $conn->prepare("SELECT * FROM matchs WHERE id_mat = :id");
	$stmResMat->execute(array('id' => $idMat));
	$resMat = $stmResMat->fetchObject();
	if( is_null(@$resMat->house1) ||
		is_null(@$resMat->visit1) ||
		is_null(@$resMat->house2) ||
		is_null(@$resMat->visit2)){
		$isNull = true;
		return array('s' => 'OPEN', 'p' => NULL);
	}
	$hs1 = $resMat->house1;
	$vs1 = $resMat->visit1;
	$hs2 = $resMat->house2;
	$vs2 = $resMat->visit2;
	$mtt = array('1' => array('h' => $hs1, 'v' => $vs1),
				 '2' => array('h' => $hs2, 'v' => $vs2));
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
		return array('s' => 'INVALID', 'p' => $mtt);
	}
	if($gain){return array('s' => 'GAIN', 'p' => $mtt);}
	else{return array('s' => 'LOSE', 'p' => $mtt);}
}

?>