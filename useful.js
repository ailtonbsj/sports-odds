

/* Remove Acentos de string */
function removeAcentos(s){
	var map={"â":"a","Â":"A","à":"a","À":"A","á":"a","Á":"A","ã":"a","Ã":"A","ê":"e","Ê":"E","è":"e","È":"E","é":"e","É":"E","î":"i","Î":"I","ì":"i","Ì":"I","í":"i","Í":"I","õ":"o","Õ":"O","ô":"o","Ô":"O","ò":"o","Ò":"O","ó":"o","Ó":"O","ü":"u","Ü":"U","û":"u","Û":"U","ú":"u","Ú":"U","ù":"u","Ù":"U","ç":"c","Ç":"C"};
	return s.replace(/[\W\[\] ]/g,function(a){return map[a]||a});
}

/* Number to RealCash R$ string */
function numberToRealcash(num){
	return 'R$ '+(parseFloat(num).toFixed(2)).replace('.',',');
}

/* DateTime MySQL to Human */
function datetimeSqlToHuman(dt){
	var tk = dt.split(' ');
	var tkd = tk[0].split('-');
	return tkd[2]+'/'+tkd[1]+'/'+tkd[0]+' '+tk[1];
}

/////////////////////////////////////////
/* getting Estado using code number */
function getEstadoByCod(codigo){
	switch(codigo){
	case '0':
		state = "Aberto";
		break;
	case '1':
		state = "Fechado";
		break;
	case '2':
		state = "Perdeu";
		break;
	case '3':
		state = "Ganhou";
		break;
	default:
		state = "Erro";
	}
	return state;
}

/* Hash readable for humans */
function hashToHuman(hash){
	var hh = "";
	for (i=0 ; i<40 ; i+=5) {
		hh +=hash.substring(i,i+5)+' ';	
	}
	return hh;
}

