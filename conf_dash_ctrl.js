id_mat = 0;
send = {};
function loadMatchConf(h1,v1, h2, v2){
	send = {};
	if(h1 >= 0){
		send = {
			'id_mat': id_mat,
			'house1': h1,
			'visit1': v1,
			'house2': h2,
			'visit2': v2
		};
	}
	var frame = $("<iframe id='iquadro'></iframe>");
	$('#quadro1').html(frame);
	$.post('conf_dash_model.php', send, function(data){
		console.log(data);
		var res = JSON.parse(data);
		if(res.status == "empt"){
			$('#formres').html('Sem Partidas. Atualize a página.');
			$('#restotal').html('Resultado ( Restam: 0 )');
		} else {
			$('#restotal').html('Resultado ( Restam: ' + res.total + ' )');
			$('#houselab').html(res.house);
			$('#visitlab').html(res.visit);
			$('#datalab').val(res.data);
			$('#housein1, #housein2, #visitin1, #visitin2, #houseinfn, #visitinfn').val('');
			$('#iquadro').attr('src',res.url);
			id_mat = res.id_mat;
		}
	});
}

function confirmSaveMatch(){
	var hs1 = parseInt(eval($('#housein1').val()));
	var vs1 = parseInt(eval($('#visitin1').val()));
	var hs2 = parseInt(eval($('#housein2').val()));
	var vs2 = parseInt(eval($('#visitin2').val()));
	if(
		hs1 == NaN || vs1 == NaN ||
		hs2 == NaN || vs2 == NaN ||
		!Number.isInteger(hs1) || !Number.isInteger(vs1) ||
		!Number.isInteger(hs2) || !Number.isInteger(vs2) ||
		hs1 < 0 || vs1 < 0 ||
		hs2 < 0 || vs2 < 0 ){
		alert('Preencha os valores da partida!');
		return;
	}
	if(!confirm('Os dados estão corretos???')) return;
	loadMatchConf(hs1, vs1, hs2, vs2);
}

function calcTotalPont(){
	var hs1 = parseInt(eval($('#housein1').val()));
	var vs1 = parseInt(eval($('#visitin1').val()));
	var hs2 = parseInt(eval($('#housein2').val()));
	var vs2 = parseInt(eval($('#visitin2').val()));
	if(!(hs1 == NaN || vs1 == NaN ||
		 hs2 == NaN || vs2 == NaN ||
		 !Number.isInteger(hs1) || !Number.isInteger(vs1) ||
		 !Number.isInteger(hs2) || !Number.isInteger(vs2) ||
		 hs1 < 0 || vs1 < 0 ||
		 hs2 < 0 || vs2 < 0 )){
		$('#houseinfn').val(hs1+hs2);
		$('#visitinfn').val(vs1+vs2);
	}
}

$(function(){
	$("#nav-item-inicio").addClass('active');
	$("#resbtn").click(confirmSaveMatch);
	loadMatchConf(-1,-1, -1, -1);
	$('#housein1, #housein2, #visitin1, #visitin2').change(calcTotalPont);
});