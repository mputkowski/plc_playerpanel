<?php
$code = addslashes($_GET['code']);
$serverName = addslashes($_GET['server']);
$smsNumber = addslashes($_GET['smsNumber']);
$name = addslashes($_GET['name']);

mysql_connect('localhost', 'plc_playerpanel', '2HaXoR32EX5xD');
mysql_select_db('polandcraft_playerpanel');
$check = mysql_query("SELECT * FROM vouchers WHERE `code` = '".$code."' AND `serverName` = '".$serverName."' AND `price` = '".$smsNumber."' AND `used` = 'Nie'");
if (mysql_num_rows($check) > 0) {
	mysql_query("UPDATE vouchers SET `used` = 'Tak', `usedby` = '".$name."' WHERE `code` = '".$code."'");
	$status = 1;
} else {
	$status = 0;
}
echo $status;