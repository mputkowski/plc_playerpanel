<?php
require($_SERVER["DOCUMENT_ROOT"] . "/utils/pp_kernel/global.php");

if ($admins) {
echo '
    <div id="wrap">
        <div id="page-heading">
            <h1>Transakcje</h1>
		</div>
            <div class="container">';

function showTotalRevenue($server, $colour) {
mysql_select_db ("polandcraft_playerpanel");
$total = 0;
$totalPercentage = 0;
$date   = date("Y-m");
$query = mysql_query("SELECT * FROM transakcje WHERE server = '$server' AND yearAndMonth = '$date' AND kod != 'testowy' AND method != 'Voucher'"); 
while($row = mysql_fetch_array($query)){ 
$total += $row['price'];
$totalPercentage = round((($total*(52/100)*72/100)), 2);
}
echo '<div class="tab-pane" id="codeinfotiles">
<div class="row">
	<div class="col-md-3">
		<div class="info-tiles tiles-'.$colour.'">
		    <div class="tiles-heading">
		        <div class="pull-left">'.$server.' - '.$date.'</div>
		        <div class="pull-right">Zarobek: <i class="icon-gbp"></i>'.round($totalPercentage/5, 2).'</div>
		    </div>
		    <div class="tiles-body">
		        <div class="pull-left"><i class="icon-info"></i></div>
		        <div class="pull-right">'.$totalPercentage.' PLN</div>
		    </div>
	</div>
	</div>';
}

echo '<div class="col-xs-11">';
showTotalRevenue('metropolic', 'warning');
showTotalRevenue('evelated', 'success');
showTotalRevenue('nesteria', 'indigo');
showTotalRevenue('hardore', 'info');
echo '</div>';


echo '
              <div class="col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    <h4>Ostatnie 200 transakcji</h4>
                    <div class="options">
                    </div>
                    </div>
                    <div class="panel-body">';
echo '
<table class="table">
<thead>
<tr>
<th>Nazwa Gracza</th>
<th>Pakiet</th>
<th>Kod SMS</th>
<th>Typ</th>
<th>Serwer</th>
<th>Metoda</th>
<th>Data kupna</th>
</tr>
</thead>
<tbody>';
mysql_select_db ("polandcraft_playerpanel");
$result = mysql_query("SELECT * FROM `transakcje` WHERE kod != 'testowy' ORDER BY data DESC LIMIT 200");
while($row = mysql_fetch_assoc($result)){
echo "<tr>
	  <td>".$row['nick']."</td>";
echo "<td>".$row['nazwa']."</td>";
echo "<td>".$row['kod']."</td>";
echo "<td>".$row['type']."</td>";
echo "<td>".ucwords($row['server'])."</td>";
echo "<td>".$row['method']."</td>";
echo "<td>".$row['data']."</td></tr>";
}
} else {
header( 'Location: ../' );
}
?>
</table>
</div>
</div>
</div>
</div>
</div>

</body>
</html>