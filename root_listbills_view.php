<style>
#filtro-pn form label {
  display: block;
}
</style>
<div class="container">

<div class="panel-group" id="campeonatos">
  <div class="panel panel-primary">
  <div class="panel-heading">Filtro</div>
  <div class="panel-body">

<div id="filtro-pn" class='row'>
<form class="form-inline">

	<div class="form-group col-md-2">
		<label for="query">Buscar</label>
		<input type="text" class="form-control" id="query" placeholder="Digite algo">
	</div>

  <div class="form-group col-md-2">
  <label for="bank-select">Banca</label>
    <select id="bank-select" class="form-control">
      <option value="">Todos</option>
    </select>
  </div>

	<div class="form-group col-md-2">
	<label for="sta-select">Estado</label>
		<select id="sta-select" class="form-control">
			<option value="">Todos</option>
			<option value="0">Aberto</option>
      <option value="1">Fechado</option>
      <option value="2">Perdeu</option>
      <option value="3">Ganhou</option>
      <option value="6">Erro</option>
		</select>
	</div>

	<div class="form-group col-md-2">
		<label for="dtp1">Inicio</label>
		<div class="input-group">
			<span class="input-group-addon">
        		<input type="checkbox" checked="checked" id="cb-dtp1">
      		</span>
      		<input type='text' class="form-control" id='dtp1' />
		</div>
  </div>

  <div class="form-group col-md-2">
		<label for="dtp2">Fim</label>
		<div class="input-group">
			<span class="input-group-addon">
        		<input type="checkbox" id="cb-dtp2">
      		</span>
			<input type='text' class="form-control" id='dtp2' />
		</div>
	</div>
	<div class="col-md-2">
  <label>&nbsp;</label>
    <button type="button" id="bt-filtrar" class="btn btn-primary">Filtrar</button> 
  </div>

</form>
</div>


  </div>  
</div>
</div>

<div class="panel-group" id="campeonatos">
  <div class="panel panel-primary">
  <div class="panel-heading">Bilhetes</div>
  <div class="panel-body">
    <table class="table table-striped">
      <thead>
        <th>Id</th>
        <th>Cliente</th>
        <th>Valor/ Prêmio</th>
        <th>Data</th>
        <th class="hidden-xs">Apostas</th>
        <th>Estado</th>
      </thead>
      <tbody id="list-bills">
      </tbody>
    </table>
  </div>
</div>
</div>
<div class="panel-group" id="campeonatos">
  <div class="panel panel-primary">
  <div class="panel-heading">Detalhes do Filtro</div>
  <div class="panel-body">
    <table class="table table-bordered table-striped">
      <tbody>
      <tr><th>Total de Bilhetes</th><td id="inf-total"></td></tr>
      <tr><th style="width:1%;white-space:nowrap;">Total Arrecadado</th><td id="inf-valor"></td></tr>
      <tr><th>Total de Prêmios</th><td id="inf-gain"></td></tr>
      <tr><th>Total das Bancas</th><td id="inf-bank"></td></tr>
      <tr><th>Total do Site</th><td id="inf-site"></td></tr>
      </tbody>
    </table>
  </div>
</div>
</div>

</div> <!-- /container -->