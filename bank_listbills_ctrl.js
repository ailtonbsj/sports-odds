function fillTable(){
	$('#list-bills').html("<td><img src='img/load.gif' /></td>");
	$.post('bank_listbills_model.php',{
		'q':$('#query').val(),
		's':$('#sta-select').val(),
		'cb_dtini':$('#cb-dtp1').is(":checked"),
		'dtini':$('#dtp1').val(),
		'cb_dtend':$('#cb-dtp2').is(":checked"),
		'dtend':$('#dtp2').val()
		}, function(data){
		$('#list-bills').empty();
		console.log(data);
		var table = JSON.parse(data);
		var somavb = 0;
		var somagb = 0;
		for(tr in table){
			//somatorio
			if(table[tr]['estado'] == "3") somagb += parseFloat(table[tr]['premio'].replace(',','.'));
			somavb += parseFloat(table[tr]['valor']);
			var trO = document.createElement('tr');
			var tdHash = document.createElement('td');
			$(tdHash).css('font-family','monospace');
			tdHash.innerHTML = hashToHuman(table[tr]['hash']);
			var tdApos = document.createElement('td');
			tdApos.innerHTML = table[tr]['apostador'];
			var tdValor = document.createElement('td');
			tdValor.innerHTML = 'R$ ' + table[tr]['valor'] + '<hr>R$ ' + table[tr]['premio'];
			var tdData = document.createElement('td');
			var tkDt = table[tr]['data_criado'].split(' ');
			var tkD = tkDt[0].split('-');
			var tkT = tkDt[1].split(':');
			tdData.innerHTML = tkD[2]+'/'+tkD[1]+' '+tkT[0]+':'+tkT[1];
			var tdMat = document.createElement('td');
			$(tdMat).addClass('hidden-xs');
			var mats = JSON.parse(table[tr]['matchjson']);
			for(m in mats){
				if(m != 0) $(tdMat).append("<hr>");
				$(tdMat).append(mats[m][1]+", "+mats[m][2]+", "+mats[m][3]+", "+mats[m][4]);
			}
			var tdSta = document.createElement('td');
			var state = getEstadoByCod(table[tr]['estado']);
			tdSta.innerHTML = state;
			$(trO).append(tdHash, tdApos, tdValor, tdData, tdMat, tdSta)
			.attr('data-hash',table[tr]['hash']);
			$('#list-bills').append(trO);
		}
		somabank = somavb*0.10;
		$("#inf-total").html(table.length);
		$("#inf-valor").html(numberToRealcash(somavb));
		$("#inf-gain").html(numberToRealcash(somagb));
		$("#inf-bank").html(numberToRealcash(somavb*0.10));
		$("#inf-site").html(numberToRealcash(somavb-somabank-somagb));
		$('#list-bills tr').click(moreInfo);
	});
}

function moreInfo(){
	window.open('querybill.php?hash='+$(this).attr('data-hash'),'_blank');
}

$(function(){
	$("#nav-item-consulta").addClass('active');
	$('#bt-filtrar').click(fillTable);
	fillTable();
	//2017-01-16 08:52:51
	$('#dtp1').datetimepicker({format:'YYYY-MM-DD HH:mm:ss'}).val(moment().format('YYYY-MM')+"-01"+" 04:00:00");
	$('#dtp2').datetimepicker({format:'YYYY-MM-DD HH:mm:ss'});
});