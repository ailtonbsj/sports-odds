<div class="container">
<ul class="nav visible-xs">
  <li id="apostas-menu-xs"><a href="#contact" data-toggle="collapse" data-target="#apostas">Minhas Apostas</a></li>
</ul>
<div id="apostas" class="collapse collapsed">

<table class="table">
  <thead>
    <tr>
      <th>Partida</th>
      <th>Aposta</th>
      <th>Taxa</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody id="mybets">
  	<tr><td>Sem Apostas</td></tr>
  </tbody>
</table>

<form class="form-inline">
  <div class="form-group">
    <label for="valor">Valor</label>
    <div class="input-group">
    <span class="input-group-addon">R$</span>
    <input type="text" id="valor-bill" class="form-control">
    </div>
  </div>
  <div class="form-group">
    <label for="apostador">Nome do Apostador</label>
    <div class="input-group">
    <span class="input-group-addon">
      <span class="glyphicon glyphicon-user"></span>
    </span>
    <input type="text" id="apostador" class="form-control">
    </div>
  </div>
  <div class="form-group">
    <label>Premiação</label>
    <div class="input-group">
      <span class="input-group-addon">
        <span class="glyphicon glyphicon-gift"></span>
      </span>
      <input type="text" class="form-control" readonly="readonly" id="total-bill">
    </div>
  </div>
  <input type="button" class="btn btn-default" value="Gerar Bilhete" id="save-bill">
</form>
</div>

<div class="panel-group" id="campeonatos">
  <div class="panel panel-primary">
  <div class="panel-heading">Campeonatos</div>
  <div class="panel-body">

<ul class="nav navbar-nav" id="camp-list">
<img src="img/load.gif" />
</ul>

  </div>
</div>
</div>
<div class="panel-group" id="partidas">
  <div class="panel panel-primary">
  <div class="panel-heading">Partidas</div>
  <div class="panel-body">

<div class="panel-group" id="accordion">
<img src="img/load.gif" />
</div>

  </div>
</div>
</div>

</div> <!-- /container -->