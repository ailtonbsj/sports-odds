<?php

/*
FUTEBOL API

http://futebolbets.com.br/
http://bets69.com/
http://esportenet.net/
http://betsbola.com/
http://betcariri.com.br/
http://www.betgol.com.br/
http://www.betpremio.com.br/
http://betcampeao.com.br/
http://www.bets77.bet/
http://www.3bets.com.br/

NEWS

http://betsnordeste.com/
http://www.betnordeste.com/
http://bets160.com/
http://betsbrasil.net/

*/

function formatUri($queryString)
{
    return str_replace(
        ['$', ' '],
        ['%24', '%20'],
        $queryString
    );
}

require('strings.php');

$q = $_GET['q'];

header('Content-type: application/json');
$ch = curl_init();

$url='';
switch ($q) {
	case '1':
		$url = $SITEAPI . "/futebolapi/api/Campeonatos?esporte=1";
		break;
	case '2':
		$id = $_GET['id'];
		$url = $SITEAPI . "/futebolapi/api/CampJogos" . formatUri("?\$filter=status eq 0 and ativo eq 1 and cancelado ne 1 and camp_ativo eq 1 and esporte_ativo eq 1 and placar_c eq null and placar_f eq null and qtd_odds gt 0 and qtd_main_odds gt 0 and (taxa_c gt 0 or taxa_f gt 0) and esporte_id eq 1 and camp_id eq " . $id . "&\$orderby=camp_nome,dt_hr_ini,camp_jog_id");
		break;
	case '3':
		$id = $_GET['id'];
		$url = $SITEAPI . "/futebolapi/api/VJogoOdds" . formatUri("?\$filter=camp_jog_id eq " . $id . " and taxa gt 0 and ativo eq 1 and j_ativo eq 1 and del eq 0 and taxa ge vl_min&\$orderby=escopo,categoria_id,odd_escopo,odd_type,odd_subtype,dparam");

	break;
}

//Debug with proxy
//curl_setopt($ch, CURLOPT_PROXY, "http://20.20.0.1:8080");
//curl_setopt($ch, CURLOPT_PROXYPORT, 8080);
//curl_setopt ($ch, CURLOPT_PROXYUSERPWD, "aluno:aluno");
//END Debug with proxy
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_HEADER, 0);

$res =  curl_exec($ch);
curl_close($ch);

echo $res;

?>