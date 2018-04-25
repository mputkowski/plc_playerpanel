<?php
mysql_set_charset('utf8');
$result = mysql_query("SELECT * FROM bans ORDER BY time DESC LIMIT 15");
echo '
            <div class="row">
              <div class="col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    <h4>Ostatnio wydane bany</h4>
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
<th>Wygasa</th>
</tr>
</thead>
<tbody>";
while ($row = mysql_fetch_array($result)) {
	echo "<tr>
    <td><img src=//panel.polandcraft.eu/utils/generator/head?player=" . $row['name'] . " width=35 height=35 align=center></td>";
    echo "<td>".$row['name']."</td>";
    echo "<td>" . $row['reason'] . "</td>";
	echo "<td>".$row['banner']."</td>";
    echo "<td>" . date("G:i d.m.Y", substr($row['time'], 0, 10)) . "</td>";
    if ($row['expires'] == "0") {
        echo "<td><font color=red>Nigdy</td>";
    } else {
        echo "<td>" . date("G:i d.m.Y", substr($row['expires'], 0, 10)) . "</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>