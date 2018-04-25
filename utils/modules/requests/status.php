<?php
if ($_GET[unban] == 'status') {
    $user = $_SESSION['user'];
    echo '<center><div class="panel50p">
<h3>Zgłoszenia o Unbany - W toku</h3>';
    mysql_select_db("polandcraft_playerpanel");
    $result = mysql_query("SELECT * FROM banning_system WHERE type = 'unban-request' AND status = 0 AND name = '$user' ORDER BY date ASC");
    if (mysql_num_rows($result) > 0) {
        echo "<td><center><b>Zbanowany przez</b></td>
<td><center><b>Zbanowany za</b></td>
<td><center><b>Serwer</b></td>";
        while ($row = mysql_fetch_assoc($result)) {
            echo "<tr><td><center><b>" . $row['bannedby'] . "</b></td>";
            echo "<td><center><b>" . $row['bannedfor'] . "</b></td>";
            echo "<td><center><b>" . $row['server'] . "</b></td></tr>";
        }
		echo "</table>";
    } else {
        echo '<br>Brak dostępnych zgłoszeń.<br>';
    }
    echo '
<h3>Zgłoszenia o Unbany - Przyjęte</h3>';
    mysql_select_db("polandcraft_playerpanel");
    $result = mysql_query("SELECT * FROM banning_system WHERE type = 'unban-request' AND status = 1 AND name = '$user' ORDER BY date ASC");
    if (mysql_num_rows($result) > 0) {
        echo "
<table border=0 cellspacing=4 cellspading=4>		
<td><center><b>Zbanowany przez</b></td>
<td><center><b>Zbanowany za</b></td>
<td><center><b>Serwer</b></td>";
        while ($row = mysql_fetch_assoc($result)) {
            echo "<tr><td><center><b>" . $row['bannedby'] . "</b></td>";
            echo "<td><center><b>" . $row['bannedfor'] . "</b></td>";
            echo "<td><center><b>" . $row['server'] . "</b></td></tr>";
        }
		echo "</table>";
    } else {
        echo '<br>Brak dostępnych zgłoszeń.<br>';
    }
    echo '
<h3>Zgłoszenia o Unbany - Odrzucone</h3>';
    mysql_select_db("polandcraft_playerpanel");
    $result = mysql_query("SELECT * FROM banning_system WHERE type = 'unban-request' AND status = 2 AND name = '$user' ORDER BY date ASC");
    if (mysql_num_rows($result) > 0) {
        echo "
<table border=0 cellspacing=4 cellspading=4>
<td><center><b>Zbanowany przez</b></td>
<td><center><b>Zbanowany za</b></td>
<td><center><b>Serwer</b></td>";
        while ($row = mysql_fetch_assoc($result)) {
            echo "<tr><td><center><b>" . $row['bannedby'] . "</b></td>";
            echo "<td><center><b>" . $row['bannedfor'] . "</b></td>";
            echo "<td><center><b>" . $row['server'] . "</b></td>";
        }
		echo "</table>";
    } else {
        echo '<br>Brak dostępnych zgłoszeń.<br>';
    }
    echo "</div><br>";
}
?>