
jsonres = [];
winbill = "";
hashdo = "";
function confirmSaveBill(){
  $('#confirmsavebill').hide();
  $('#modal1-bdy').html("<img src='img/load.gif' /><br />Validando o seu bilhete...");
  var jsonb = JSON.stringify(myBets);
  $.post('genbill_platform_validate.php', {'bill':jsonb, 'value':$('#valor-bill').val(), 'name':$('#apostador').val()}, function(data){
    jsonres = [];
    try {
      jsonres = JSON.parse(data);
    }
    catch(err){}
    if(jsonres['state'] == 'SUCCESS'){
      $('#modal1-bdy').html("Validado com Sucesso!<br /><button id='print-bill' class='btn btn-default btn-primary btn-lg'>Imprimir Comprovante</button>");
      hashd = jsonres['hash'];
      $('#print-bill').click(printBill);
        winbill = "";
        winbill+="<html><head><style>body {font-family: 'monospace'; font-size: 12px;}</style></head><body>";
        winbill+="<pre>";
        winbill+="--------------------------------<br />";
        winbill+="       PALPITE ESPORTIVO        <br />";
        winbill+=" www.palpiteesportivo.16mb.com  <br />";
        winbill+=" BANCA: " + $("#user-id").html() + "<br />";
        winbill+=" APOSTADOR: " + $("#apostador").val() + "<br />";
        winbill+=' DATA: '+jsonres['date'] + "<br /><br />";
        winbill+=" "+jsonres['hash'] + " <br />";
        winbill+="--------------------------------<br />";
        winbill+="<br />";
        winbill+="        SUAS APOSTAS            <br />";
        winbill+="--------------------------------<br />";
        for(i in myBets){
          winbill+=myBets[i][1] + "<br />";
          winbill+=myBets[i][2] + "<br />";
          winbill+='PALPITE: ' + myBets[i][3] +' - '+ myBets[i][4] + "<br />";
          winbill+="--------------------------------<br />";
        }
        winbill+="TOTAL DE JOGOS: "+ myBets.length +"<br />";
        winbill+="VALOR APOSTADO: R$ "+ $("#valor-bill").val() +"<br />";
        winbill+="PREMIACAO: R$ "+ $("#total-bill").val() +"<br />";
        winbill+="</pre></body></html>";
        $("#valor-bill").val('');
        $("#apostador").val('');
        myBets = [];
        fillMyBets();
    }
    else {
      $('#modal1-bdy').html("<div class='alert alert-danger'>Erro! Tente novamente!</div>");
    }
  });
}

function printBill(){
  var wpri = window.open("genbill_platform_print.php?id="+hashd, "_blank");
  //var wpri = window.open("", "_blank");
  //wpri.document.write(winbill);
  //wpri.print();
}