<?php
header('Content-Type: text/html; charset=utf-8');
mysql_set_charset('utf8');

function displayMenu($serverName, $serverID, $admins) {
echo '
<div class="col-xs-12">
<div class="panel panel-primary">
<div class="panel-heading">
<img src="images/logos/'.$serverName.'.png" width="5%">
<div class="options">
</div>
</div>
<div class="panel-body">
<div class="table-responsive">
<table class="table">
<thead>
<tr>
<th style="padding-right:100px">Pakiet</th>
<th>Cena</th>
<th>Kup przez</th>
<th></th>
<th></th>
</tr>
</thead>
';
$result = mysql_query("SELECT * FROM itemshop WHERE serverID = '".$serverID."' ORDER BY `ID` ASC");
while ($is = mysql_fetch_assoc($result)) {
echo "<tbody>
<tr>
<td>" . $is['name'] . "</td>
<td>" . $is['price'] . "zł</td>
<td><a href='./shop/buy/sms/package/". $is['ID'] ."' class='btn btn-success'>SMS Premium</a></td>
<td><a href='./shop/buy/transfer/package/". $is['ID'] ."' class='btn btn-success'>Przelew</a></td>
<td><a href='./shop/buy/voucher/package/". $is['ID'] ."' class='btn btn-success'>Voucher</a></td>
</tr>
</thead>";
}
echo "</table></div></div></div></div><br>";
}

displayMenu("metropolic", "1", $admins);
displayMenu("evelated", "2", $admins);
//displayMenu("hardore", "3", $admins);
displayMenu("nesteria", "5", $admins);

?>