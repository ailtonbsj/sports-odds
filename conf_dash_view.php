<style type="text/css">
.timelabel {
  width: 150px;
}
#tempoum, #tempodois, #tempofinal {
  margin-bottom: 10px;
}
</style>
<div class="container">

<div class="panel-group" id="campeonatos">
  <div class="panel panel-primary">
  <div class="panel-heading" id="restotal">Resultado (3/12)</div>
  <div class="panel-body" id="formres">

  <form class="form-inline">

  	<div id="tempoum" class="form-group">
		<label class="timelabel" for="housein" id="houselab">House</label>
    <div class="input-group">
    <div class="input-group-addon">1&ordm; tempo</div>
		<input type="text" class="form-control" id="housein1" placeholder="Casa">
    </div>
    <div class="input-group">
    <div class="input-group-addon">2&ordm; tempo</div>
    <input type="text" class="form-control" id="housein2" placeholder="Casa">
    </div>
    <div class="input-group">
    <div class="input-group-addon">&nbsp;&nbsp;&nbsp;Total&nbsp;&nbsp;&nbsp;</div>
    <input type="text" class="form-control" readonly="readonly" id="houseinfn" placeholder="Visita">
    </div>
	</div>

  <br>

	<div id="tempodois" class="form-group">
    <label class="timelabel" for="housein" id="visitlab">Visit</label>
    <div class="input-group">
    <div class="input-group-addon">1&ordm; tempo</div>
    <input type="text" class="form-control" id="visitin1" placeholder="Visita">
    </div>
    <div class="input-group">
    <div class="input-group-addon">2&ordm; tempo</div>
    <input type="text" class="form-control" id="visitin2" placeholder="Visita">
    </div>
    <div class="input-group">
    <div class="input-group-addon">&nbsp;&nbsp;&nbsp;Total&nbsp;&nbsp;&nbsp;</div>
    <input type="text" class="form-control" readonly="readonly" id="visitinfn" placeholder="Visita">
    </div>
	</div>

  <div class="form-group">
    <label>Data</label>
    <input type="text" class="form-control" readonly="readonly"  id="datalab">
  </div>
	<input type="button" class="btn btn-primary" value="Confirmar" id="resbtn">
  	
  </form>

  </div>
</div>
</div>

<div class="panel-group" id="campeonatos">
  <div class="panel panel-primary">
  <div class="panel-heading">Resultados.com</div>
  <div class="panel-body" id="quadro1"> 
  </div>
</div>
</div>

</div> <!-- /container -->