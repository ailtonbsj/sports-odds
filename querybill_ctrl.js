
function insertRow(label, value){
	var tdL = document.createElement('td');
	var tdV = document.createElement('td');
	var tr = document.createElement('tr');
	$(tdL).html('<b>'+label+'</b>');
	$(tdV).html(value);
	$(tr).append(tdL, tdV);
	return tr;
}
function insertRowSpan(value, classColor){
	var tdV = document.createElement('td');
	var tr = document.createElement('tr');
	$(tdV).html(value).attr('colspan',2).addClass(classColor);
	$(tr).append(tdV);
	return tr;
}

function getBillByHash(){
	var query = $('#in-query').val().replace(/ /g,'');
	var tbil = $("#tbill");
	$.get('querybill_model.php', {'hash':query},function(data){
		var bil = JSON.parse(data);
		$(tbil).empty()
		.append(insertRow('Hash', hashToHuman(bil.hash)))
		.append(insertRow('Banca',bil.user))
		.append(insertRow('Cliente',bil.apostador))
		.append(insertRow('Valor', numberToRealcash(bil.valor)))
		.append(insertRow('Premio', numberToRealcash(bil.premio)))
		.append(insertRow('Data', datetimeSqlToHuman(bil.data_criado)))
		.append(insertRow('Estado', getEstadoByCod(bil.estado)))
		.append(insertRowSpan('<b>Palpites</b>',''));
		for(pal in bil.matchjson){
			ob = bil.matchjson[pal];
			ss = '';
			if(ob.s == 'LOSE') ss = 'danger';
			else if(ob.s == 'OPEN') ss = '';
			else if(ob.s == 'GAIN') ss = 'success'; 
			myp = ob[1]+'<br>'+ob[2]+'<br>'+ob[3]+' - Taxa: '+ob[4]+'<br>';
			if(ss != ''){
				myp+= 'Primeiro Tempo: '+ob.p[1].h+' X '+ob.p[1].v+'<br>';
				myp+= 'Segundo Tempo: '+ob.p[2].h+' X '+ob.p[2].v+'<br>';
				myp+= 'Final de Jogo: '+(parseInt(ob.p[1].h)+parseInt(ob.p[2].h))+' X '+(parseInt(ob.p[1].v)+parseInt(ob.p[2].v));
			}
			$(tbil).append(insertRowSpan(myp,ss));
		}
		$(tbil).append(insertRow('Total de Palpites',bil.matchjson.length));
		
	});
}	

$(function(){
	$("#menu-query").addClass('active');
	$("#bt-query").click(getBillByHash);
});