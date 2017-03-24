//Function RemoveFoos
function removeFoos(content){
  content = content.replace("1.","");
  content = content.replace(" - "," ");
  if(content.endsWith("Lig")){
    content = content.replace("Lig","League");
  }
  return content.toLowerCase();
}

//Class ItemCamp
function listenerBtnCamp(){
  loadMatchs($(this).attr('data-query'));
}

function ItemCamp(id, content){
  this.dom = document.createElement("li");
  this.dom.innerHTML = content;
  $(this.dom).addClass('btn btn-primary btn-campeonato')
  .css("text-transform","capitalize")
  .attr('data-query',id)
  .click(listenerBtnCamp);
}
//END Class ItemCamp

//Action Camps Button
function loadMatchs(id){
  var raw = "get_externalapi.php?q=2&id="+id;
  $('#accordion').html('<img src="img/load.gif" />');
  $.get(raw, function(matchs){
    $('#accordion').empty();
    for(m in matchs){
      var casa = removeAcentos(matchs[m]['casa_time']);
      var visi = removeAcentos(matchs[m]['visit_time']);
      var accordItem = new AccordItem(matchs[m]['camp_jog_id'], casa, visi, matchs[m]['dt_hr_ini']);
      $('#accordion').append(accordItem.dom);
    }
    location.href = "#partidas";
  });
}

//Class AccordItem
function AccordItem(id, house, visit, datetime){
  var dt = datetime.split('T');
  var date = dt[0].split('-');
  
  //headA
  var hdrA = document.createElement('a');
  $(hdrA).attr('data-toggle','collapse')
  .attr('data-parent','#accordion')
  .attr('href','#cps'+id)
  .html(house+' X '+visit+'<br /> ( '+ date[2]+'/'+date[1]+'/'+date[0]+' - '+dt[1] +' )');

  //headH4
  var hdrH = document.createElement('div');
  $(hdrH).addClass('panel-title')
  .append(hdrA);

  //head
  var accHdr = document.createElement('div');
  $(accHdr).addClass('panel-heading')
  .append(hdrH);

  //bdyAcc
  var bdyAcc = document.createElement('div');
  $(bdyAcc).addClass('panel-body');
  
  //table of odds
  var tbOdd = new TableOdd(id);
  $(bdyAcc).html(tbOdd.dom);

  //bdy cps
  var bdyCps = document.createElement('div');
  $(bdyCps).addClass('panel-collapse collapse')
  .attr('id','cps'+id)
  .append(bdyAcc);

  //item
  this.dom = document.createElement('div');
  $(this.dom).addClass('panel panel-default')
  .append(accHdr).append(bdyCps);

  var raw="get_externalapi.php?q=3&id="+id;
  $.get(raw, function(odds){
    fillTableOdd(id, odds, house+' X '+visit, date[2]+'/'+date[1]+'/'+date[0]+' '+dt[1]);
  });
  
}
//END Class AccordItem

//Class TableOdd
function newThObj(content){
  var th = document.createElement('th');
  th.innerHTML = content;
  return th;  
}

function TableOdd(id){
  //th
  var trH = document.createElement('tr');
  $(trH).append(newThObj('Descrição'))
  .append(newThObj('Taxa'));

  //thead
  var tHdr = document.createElement('thead');
  $(tHdr).append(trH);

  //tbody
  var tBdy = document.createElement('tbody');
  $(tBdy).attr('id','odd-tby'+id)
  .html('<tr><td><img src="img/load.gif" /><td><tr>');;
  
  //table
  this.dom = document.createElement('table');
  $(this.dom).addClass('table')
  .append(tHdr).append(tBdy);
}
//END Class TableOdd

//FillOddsTable
myOdds = [];
function fillTableOdd(id,ods, partida, data){
  $('#odd-tby'+id).empty();
  for( o in ods){
    var oddt = ods[o]['descricao'];
    var odd_ = oddt.split(' - ');
    var oddC = oddt.split(' (');
    //console.log(oddc);
    /* */
    if(oddt != 'Casa' &&
       oddt != 'Empate' &&
       oddt != 'Fora' &&
       oddt != 'Casa ou Fora' &&
       oddt != 'Casa ou Empate' &&
       oddt != 'Fora ou Empate' &&
       oddt != 'Ambas Marcam' &&
       oddt != 'Apenas 1 marca' &&
       oddt != 'Total de Gols Par' &&
       oddt != 'Total de Gols Ímpar' &&
       odd_[0] != 'Jogo' &&
       odd_[0] != '1º Tempo' &&
       odd_[0] != '2º Tempo' &&
       oddC[0] != 'Resultado Exato' &&
       oddC[0] != 'Intervalo | Final') continue;
    if(odd_[0] == '1º Tempo' || odd_[0] == '2º Tempo'){
      if(odd_[1] != 'Casa' &&
         odd_[1] != 'Empate' &&
         odd_[1] != 'Fora' &&
         odd_[1] != 'Casa ou Fora' &&
         odd_[1] != 'Casa ou Empate' &&
         odd_[1] != 'Fora ou Empate') continue;
    }
    /* */
    var rw = document.createElement('tr');
    var td1 = document.createElement('td');
    var td2 = document.createElement('td');
    td1.innerHTML = ods[o]['descricao'];
    td2.innerHTML = ods[o]['taxa'];
    myOdds[ods[o]['jog_odd_id']] = [ods[o]['camp_jog_id'],partida,data, ods[o]['descricao'], ods[o]['taxa']];
    $(rw).append(td1, td2)
    .attr('data-idodd',ods[o]['jog_odd_id'])
    .click(function(){
      var oddid = $(this).attr('data-idodd');
      var tmpOd = myOdds[oddid];
      tmpOd[5] = oddid;
      var isBet = true;
      for(b in myBets){
        if(tmpOd[0] == myBets[b][0]){
          isBet = false;
          alert('Aposta já feita. Remova a anterior caso queira mudar!');
          break;
        }
      }
      if(isBet) {
        myBets.push(tmpOd);
        alert('Palpite adicionado ao Bilhete!');
      }
      fillMyBets();
    });
    $('#odd-tby'+id).append(rw);
  }
}

//MyBets
myBets = [];
function fillMyBets(){
  $('#mybets').empty();
  for(r in myBets){
    var rw = document.createElement('tr');
    var matchTd = document.createElement('td');
    var betTd = document.createElement('td');
    var taxTd = document.createElement('td');
    var rmTd = document.createElement('td');
    var rmBtn = document.createElement('span');
    matchTd.innerHTML = myBets[r][1] +'<br />'+ myBets[r][2];
    betTd.innerHTML = myBets[r][3];
    taxTd.innerHTML = myBets[r][4];
    $(rmBtn).addClass('glyphicon glyphicon-remove').attr('data-idodd', r)
    .css('cursor','pointer')
    .click(function(){
       myBets.splice($(this).attr('data-idodd'),1);
       fillMyBets();
    });
    $(rmTd).append(rmBtn);
    $(rw).append(matchTd,betTd,taxTd, rmTd);
    $('#mybets').append(rw);
  }
  if(myBets.length == 0) $('#mybets').html('<tr><td>Sem Apostas</td></tr>');
  calcEarn();
}

//CalcValor
function calcEarn(){
  var prod = 1;
  var premio = 0;
  var valorApos = parseFloat($('#valor-bill').val().replace(',','.'), 10);
  if(myBets.length != 0){
    for(r in myBets){
    prod *= myBets[r][4];
    }
    premio = (prod*valorApos).toFixed(2);
  }
  if(isNaN(premio)) premio = 0;
  $('#total-bill').val(premio); 
  //Restricao de aposta maxima
  if(premio >= 500*valorApos){
  	alert("A premiação não pode ser 500 vezes maior que o valor Apostado!");
  	return false;
  } else if(premio >= 5000){
  	alert('A premiação deve ser menor que R$5000,00');
  	return false;
  }
  return true;
}

function saveBill(){
  if(!logged) alert('Você precisa está logado!');
  else if(myBets.length == 0) alert('O Bilhete está vazio!');
  else if(parseFloat($('#total-bill').val()) == 0) alert('Preencha o valor correto!');
  else if(parseFloat($('#valor-bill').val()) < 2) alert('Valor permitido somente igual ou acima de R$2,00!');
  else if(!calcEarn()){}
  else {
    $('#confirmsavebill').show();
    $('#modal1-bdy').html('Clique em confirmar para fazer a validação do bilhete! Espere alguns segundos para completar a ação.');
    $('#savebillmodal').modal({backdrop: 'static', keyboard: false});
  }
}

//Main
$(function(){
<?php
if(isset($erro_login)) echo "alert('Login invalido!');\n";
if(isset($_SESSION['user'])) echo "logged = true;\n";
else echo "logged = false;\n";
?>
  //Load Camps
  $.get("get_externalapi.php?q=1", function(camps){
    $("#camp-list").empty();
    for ( i in camps ){
      var a = removeFoos(camps[i]['CAMP_NOME']);
      var item = new ItemCamp(camps[i]['CAMP_ID'], removeFoos(camps[i]['CAMP_NOME']));
      $("#camp-list").append(item.dom);
    }
    $("#camp-list").children().first().click();
  });

  $('#valor-bill').change(calcEarn);
  $('#save-bill').click(saveBill);
  $('#confirmsavebill').click(confirmSaveBill);
  $("#nav-item-inicio").addClass('active');
});