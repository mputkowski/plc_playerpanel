<?php
header('Content-Type: text/html; charset=utf-8');
mysql_set_charset('utf8');
$user = $_SESSION['user'];
$q    = mysql_query("SELECT * FROM bans WHERE name = '$user'");
if (mysql_num_rows($q) > 0) {
    $row = mysql_fetch_array($q);
    $checkUnbanOption = mysql_query("SELECT * FROM users WHERE username = '$user' AND unbanned = '0'");
    if (mysql_num_rows($checkUnbanOption) > 0) {
    	msgAndGoBack(''.$user.', jesteś zbanowany za '.$row['reason'].' przez administratora '.$row['banner'].'. Dobra wiadomość jest taka że masz możliwość odbanowania się <a href="./bans?yban=1">tutaj</a>.', 0, 0, 0);
	} else {
		msgAndGoBack(''.$user.', jesteś zbanowany za '.$row['reason'].' przez administratora '.$row['banner'].'', 0, 0, 0);
	}
} else {
    msgAndGoBack('Nie jesteś zbanowany/a, jesteś bezpieczny!', 1, 0, 0);
}

if ($_GET[yban] == '1') {
	$checkIfBanned = mysql_query("SELECT * FROM bans WHERE name = '$user'");
		if (mysql_num_rows($checkIfBanned) > 0) {
			$checkIfDone = mysql_query("SELECT * FROM users WHERE username = '$user' AND unbanned = '0'");
			if (mysql_num_rows($checkIfDone) > 0) {
				mysql_query("UPDATE users SET `unbanned` = '1' WHERE `username` = '$user'");
    			mysql_query("DELETE FROM bans WHERE `name` = '$user'");
    			msgAndGoBack('Zostałeś/aś odbanowany/a.', 1, 0, 0);
   		 } else {
    		msgAndGoBack('Już wykorzystałeś swoją możliwość odbanowania.', 0, 0, 0);
    	}
	} else {
		msgAndGoBack('Nie jesteś zbanowany/a.', 0, 0, 0);
	}
}

?>