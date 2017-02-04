
<nav class="navbar navbar-inverse navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><?= $SYSTEMNAME ?></a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
    <?php
      if(isset($_SESSION['tipo'])) $type = $_SESSION['tipo'];
      else $type = null;
      switch ($type) {
        case 'bank':
          require('bank_menu.php');
          break;
        case 'conf':
          require('conf_menu.php');
          break; 
        case 'root':
          require('root_menu.php');
          break;  
        default:
          require('index_menu.php');
      }
    ?>
    </div><!--/.nav-collapse -->
  </div>
</nav>