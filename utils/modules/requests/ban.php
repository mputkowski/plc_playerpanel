<?php
session_start();
require ("captcha.php");
if ($_GET[ban] == 'form') {
    echo '<div class=panel50p><center>
<FORM ACTION="?ban=add" METHOD="POST">
<input type=text value=' . $name . ' placeholder="" readonly required><br>
<input type=text name=offender placeholder="Nazwa sprawcy" required><br>
<input type=text name=banfor placeholder="Zbanować za" required><br>
<textarea cols=60 rows=15 name="reasonfor" placeholder="Dlaczego mamy go zbanować, dokładniej." required></textarea><br>
Serwer:<br>
<select name="server" required>
	<option>Metropolic.pl</option>
	<option>Evelated.pl</option>
	<option>Hardore.pl</option>
	<option>Spacefun.pl</option>
	<option>Nesteria.pl</option>
	<option>Craftops.pl</option>
</select>
<br>
<textarea cols=50 rows=5 name="evidence" placeholder="Dowody winy (podaj linki do wideo lub obrazków)" required></textarea>
<br>
<img src=../requests?captcha><br>
<input type=text name=captcha placeholder="Kod weryfikacyjny" required><br>
<br>
<input type="submit" class=button value="Zakończ" />
<br><br>
</form>
</center></div><br><br>';
}
if ($_GET[ban] == 'add') {
    $name         = $_SESSION['user'];
    $offendername = mysql_real_escape_string($_POST['offender']);
    $banfor       = mysql_real_escape_string($_POST['banfor']);
	$reasonfor       = mysql_real_escape_string($_POST['reasonfor']);
    $server       = mysql_real_escape_string($_POST['server']);
    $evidence     = mysql_real_escape_string($_POST['evidence']);
    $date         = date(U);
    $type         = 'ban-request';
			//INTELISENSE
			$ic1 = strpos($evidence, "iema");
			$ic2 = strpos($evidence, "bra");
			$ic3 = strpos($evidence, "mam");
			//ENDOF
            if ($ic1 !== false or $ic2 !== false or $ic3 !== false) {
                $status = '2';
				$intelisense = 'Tak';
            } else {
                $status = '0';
				$intelisense = 'Nie';
            }
		if (!($name) or !($offendername) or !($banfor) or !($server) or !($evidence)) {
			echo '<div class="warnmsg" id="warnmsg"><center><img src=../images/other/no.png><b> Nie wypełniłeś/aś wszystkich pul.</center></div>';
		} 
		include("utils/classes/admins.php");
		if ($checkadminban or $checkmodban) {
			echo '<div class="warnmsg" id="warnmsg"><center><img src=../images/other/no.png><b> Nie możesz zbanować moderatora panelu.</center></div>';
		} else {
		if ($_SESSION['captcha'] == $_POST['captcha']) { 
			mysql_query("INSERT INTO banning_system (name,offendername,bannedfor,banfor,reasonfor,server,evidence,date,type,status,intelisense) VALUES ('$name','$offendername','$bannedfor','$banfor','$reasonfor','$server','$evidence','$date','$type','$status','$intelisense')");
			echo "<center><h2>Podanie o Ban<h2></center><br><div class=panel50p><center>Twoje zgłoszenie zostało przyjęte, dziękujemy.<br><FORM ACTION=../><input type='submit' class=textbuttonlong value='Wróć do panelu.' /></FORM></center></div><br><br>";
		} else {
			echo '<div class="warnmsg" id="warnmsg"><center><img src=../images/other/no.png><b> Niepoprawny kod weryfikacyjny.</center></div>';
		}
	}
}
?>