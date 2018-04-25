<?php
require($_SERVER["DOCUMENT_ROOT"] . "/utils/pp_kernel/global.php");
?>

<div id="page-content">
    <div id="wrap">
        <div id="page-heading">
            <h1>Strona Główna</h1>
		</div>
		
					  <div class="panel-body">
					  <h4>Status Serwerów</h4>
					  <script>
var interval = 5000;
var lstatus = 0;
setInterval(function(){
  lstatus++;
  el = document.getElementById("status_"+lstatus);
  if(el == null){
    lstatus = 1;
    el = document.getElementById("status");
  }
  var adres = el.getAttribute("src").split("&t=");
  el.setAttribute("src",adres[0]+"&t="+Math.floor(99999*Math.random()));
  
}, interval);
</script>
<img id="status" src="http://polandcraft.eu/status/polandcraft.png">
<br><br><br>
<h4>Nawigacja</h4>
					  	<p>Kliknij na tabele aby dostać się do poszczególnych części panelu gracza.</p>
					  	<div class="tab-content">
						    <div class="tab-pane active" id="domshortcuttiles">
							  	<div class="row">
							  		<div class="col-md-2">
										<a href="../stats" class="shortcut-tiles tiles-info">
											<div class="tiles-body">
												<div class="pull-left"><i class="icon-tasks"></i></div>
											</div>
											<div class="tiles-footer">
												Statystyki Serwerowe
											</div>
										</a>
							  		</div>
							  		<div class="col-md-2">
										<a href="../shop" class="shortcut-tiles tiles-orange">
											<div class="tiles-body">
												<div class="pull-left"><i class="icon-euro"></i></div>
											</div>
											<div class="tiles-footer">
												Sklep Serwerowy
											</div>
										</a>
							  		</div>
							  		<div class="col-md-2">
										<a href="../bans" class="shortcut-tiles tiles-success">
											<div class="tiles-body">
												<div class="pull-left"><i class="icon-eye-open"></i></div>
												
											</div>
											<div class="tiles-footer">
												Lista Zbanowanych
											</div>
										</a>
							  		</div>
							  		<div class="col-md-2">
										<a href="../profile" class="shortcut-tiles tiles-danger">
											<div class="tiles-body">
												<div class="pull-left"><i class="icon-credit-card"></i></div>
											</div>
											<div class="tiles-footer">
												Twój Profil
											</div>
										</a>
							  		</div>

</div>
</div>
</div>
<br><br>
<h4>Nowości</h4>
Brak nowości.
</body>
</html>