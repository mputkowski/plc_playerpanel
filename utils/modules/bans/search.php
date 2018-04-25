<?php
header('Content-Type: text/html; charset=utf-8');
if (isset($_GET['search'])) {
    if (!isset($_GET['name'])) {
        die('<meta http-equiv="Refresh" content="0; url=./bans">');
    }
    $term = mysql_real_escape_string($_GET['name']);
    $sql  = mysql_query("select * from bans where name like '$term%'");
echo '
            <div class="row">
              <div class="col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    <h4>Wyniki wyszukiwania wydanych banów</h4>
                    <div class="options">
                    </div>
                    </div>
                    <div class="panel-body">
';
echo "<table class='table'>";
echo "
<thead>
<tr>
<th></th>
<th>Nazwa Gracza</th>
<th>Powód</th>
<th>Wydane przez</th>
<th>Data wydania</th>
</tr>
</thead>
<tbody>";
    if (mysql_num_rows($sql) == 0)
        echo 'Nie znaleziono gracza o takim nicku. </table>';
    while ($row = mysql_fetch_array($sql)) {
        echo "<tr>";
        echo "<td><img src=//panel.polandcraft.eu/utils/generator/head?player=" . $row['name'] . " width=35 height=35 align=center>" . $row['name'] . "</td>";
        echo "<td>" . $row['reason'] . "</td>";
        echo "<td>". $row['banner'] . "</td>";
        echo "<td>" . date("G:i d.m.Y", substr($row['time'], 0, 10)) . "</td>";
        if ($row['expires'] == "0") {
            echo "<td><font color=red>Nigdy</td>";
        } else {
            echo "<td>" . date("G:i d.m.Y", substr($row['expires'], 0, 10)) . "</td>";
        }
        echo "</tr>";
    }
    exit;
}
?>