<?php
require($_SERVER["DOCUMENT_ROOT"] . "/utils/pp_kernel/global.php");
if ($admins) {
echo '
    <div id="wrap">
        <div id="page-heading">
            <h1>Transakcje</h1>
		</div>
            <div class="row">
              <div class="col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    <h4>Ostatnie 200 transakcji</h4>
                    <div class="options">
                    </div>
                    </div>
                    <div class="panel-body">
<table class="table">
<thead>
<tr>
<th>Nazwa Gracza</th>
<th>Pakiet</th>
<th>Kod SMS</th>
<th>Typ</th>
<th>Serwer</th>
<th>Data kupna</th>
</tr>
</thead>
<tbody>';
mysql_select_db ("polandcraft_playerpanel");
$result = mysql_query("SELECT * FROM `transakcje` ORDER BY data DESC LIMIT 200");
while($row = mysql_fetch_assoc($result)){
echo "<tr>
	  <td>".$row['nick']."</td>";
echo "<td>".$row['nazwa']."</td>";
echo "<td>".$row['kod']."</td>";
echo "<td>".$row['type']."</td>";
echo "<td>".$row['server']."</td>";
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