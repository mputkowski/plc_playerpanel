<?php
if ($_GET[unban] == 'form') {
    $isbanned = mysql_query("SELECT * FROM banlist WHERE name = '$name' AND (type = '0' OR type = '1' OR type = '9')");
    if (mysql_num_rows($isbanned) > 0) {
		if ($_COOKIE['formfilled']) {
		    echo '<div class="warnmsg" id="warnmsg"><center><img src=../images/other/no.png><b> Już wypełniłeś/aś podanie o unban, podania można składać co 7 dni.</center></div>';
        } else {
        $find      = mysql_query("SELECT * FROM banlist WHERE name = '$name' AND (type = '0' OR type = '1' OR type = '9')");
        $found     = mysql_fetch_array($find);
        $bannedby  = $found['admin'];
        $bannedfor = $found['reason'];
        echo '<div class=panel50p><center>
<FORM ACTION="?unban=add" METHOD="POST">
Sprawca<br>
<input type=text  value=' . $name . ' readonly><br>
Zbanowany przez<br>
<input type=text  value=' . $bannedby . ' readonly><br>
Zbanowany za<br>
<textarea cols=60 rows=2 readonly>' . $bannedfor . '</textarea><br>
<textarea cols=60 rows=15 name="reasonfor" placeholder="Dlaczego chcesz unbana?" required></textarea><br>
Serwer:<br>
<select name="server" required>
	<option>Metropolic.pl</option>
	<option>Evelated.pl</option>
	<option>Hardore.pl</option>
	<option>Spacefun.pl</option>
	<option>Nesteria.pl</option>
	<option>Craftops.pl</option>
</select><br>
<textarea cols=50 rows=5 name="evidence" placeholder="Dowody niewinności (podaj linki do wideo lub obrazków, podania bez dowodów bedą automatycznie odrzucane)" required></textarea>
<br>
<input type="submit" class=button value="Zakończ" />
<br><br>
</form>
</center></div>';
			}
	} else {
        echo '<div class="warnmsg" id="warnmsg"><center><img src=../images/other/no.png><b> Nie wykryto bana na twoim nicku, nie musisz składać podania.</center></div>';
    }
}
if ($_GET[unban] == 'add') {
    $isbanned = mysql_query("SELECT * FROM banlist WHERE name = '$name' AND (type = '0' OR type = '1' OR type = '9')");
    if (mysql_num_rows($isbanned) > 0) {
        if ($_COOKIE['formfilled']) {
            echo '<div class="warnmsg" id="warnmsg"><center><img src=../images/other/no.png><b> Już wypełniłeś/aś podanie o unban, podania można składać co 7 dni.</center></div>';
        } else {
            setcookie('formfilled', '1', time() + (604800 * 7));
            $name       = $_SESSION['user'];
            $find       = mysql_query("SELECT * FROM banlist WHERE name = '$name' AND (type = '0' OR type = '1' OR type = '9')");
            $found      = mysql_fetch_array($find);
            $bannedby   = $found['admin'];
            $bannedfor  = $found['reason'];
            $reasonfor  = mysql_real_escape_string($_POST['reasonfor']);
            $server     = mysql_real_escape_string($_POST['server']);
            $evidence   = mysql_real_escape_string($_POST['evidence']);
            $date       = date(U);
            $type       = 'unban-request';
            $isipbanned = $found['type'];
			//INTELISENSE
			$ic1 = strpos($bannedfor, "eklama");
			$ic2 = strpos($bannedfor, "eklamo");
			$ic3 = strpos($bannedfor, "ray");
			$ic4 = strpos($reasonfor, "iema");
			$ic5 = strpos($reasonfor, "bra");
			$ic6 = strpos($evidence, "iema");
			$ic7 = strpos($evidence, "bra");
			$ic8 = strpos($evidence, "mam");
			$iib = $isipbanned;
			//ENDOF
            if ($ic1 !== false or $ic2 !== false or $ic3 !== false or $ic4 !== false or $ic5 !== false or $ic6 !== false or $ic7 !== false or $ic8 !== false or $iib == "1") {
                $status = '2';
				$intelisense = 'Tak';
            } else {
                $status = '0';
				$intelisense = 'Nie';
            }
            if (!($name) or !($reasonfor) or !($server) or !($evidence)) {
                echo '<div class="warnmsg" id="warnmsg"><center><img src=../images/other/no.png><b> Nie wypełniłeś/aś wszystkich pul.</center></div>';
            } else {
                mysql_query("INSERT INTO banning_system (name,bannedby,bannedfor,reasonfor,server,evidence,date,type,status,intelisense) VALUES ('$name','$bannedby','$bannedfor','$reasonfor','$server','$evidence','$date','$type','$status','$intelisense')");
                echo "<center><h2>Podanie o Ban<h2></center><br><div class=panel50p><center>Twoje zgłoszenie zostało przyjęte, jeżeli dostaniesz unbana zostanie to ogłoszone na statusach zgłoszeń.<br>Informujemy jednak, że nasz system banów może automatycznie odrzucić twoje podanie jeżeli uzna je za niestosowne do dalszego dochodzenia.<br><FORM ACTION=../requests?unban=status><input type='submit' class=textbuttonlong value='Wróć do panelu.' /></FORM></center></div><br><br>";
            }
        }
    } else {
        echo '<div class="warnmsg" id="warnmsg"><center><img src=../images/other/no.png><b> Nie wykryto bana na twoim nicku, nie musisz składać podania.</center></div>';
    }
}
?>