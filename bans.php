<?php
require($_SERVER["DOCUMENT_ROOT"] . "/utils/pp_kernel/global.php");
?>

<div id="page-content">
    <div id="wrap">
        <div id="page-heading">
            <h1>Lista Zbanowanych</h1>
		</div>
<div class='container'>
<?php
include("utils/modules/bans/bancheck.php");
?>

<?php
include("utils/modules/bans/search.php");
?>

<form class="form-horizontal" action="?search" method="get">
<input type="hidden" name="search">
						  <div class="form-group">
						    <label for="focusedinput" class="col-sm-3 control-label" >Gracz</label>
						    <div class="col-sm-6">
						      <input type="text" class="form-control" id="focusedinput" name="name" placeholder="Wpisz nazwę gracza tutaj" required>
						    </div>
							<div class="col-sm-3">
						    	<p class="help-block"><input type="submit" class="btn btn-info" value="Szukaj" /></p>
						    </div>
						  </div>
						</form>

<?php
include("utils/modules/bans/recent.php");
?>

</div>
</div>
</div>