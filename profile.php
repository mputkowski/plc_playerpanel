<?php
require($_SERVER["DOCUMENT_ROOT"] . "/utils/pp_kernel/global.php");
$user = $_SESSION['user'];
?>
<div id="page-content">
    <div id="wrap">
        <div id="page-heading">
            <h1>Edycja Profilu</h1>
		</div>
<div class='container'>
			<div class="row">
				<div class="col-sm-12">
				  <div class="panel panel-primary">
				      <div class="panel-heading">
				          <h4><?php print '<img src=//panel.polandcraft.eu/utils/generator/head?player='.$user.' width=24 height=24>'; ?> Twój Profil</h4>
				          </div>
<?php

if (isset($_GET['edit'])) {
        $playerCurrent    = mysql_real_escape_string($_SESSION['user']);
        $playerNew = mysql_real_escape_string($_POST['player']);
        $oldPassword = md5($_POST['password']);
        $email = mysql_real_escape_string($_POST['email']);
        $newpassform = $_POST['newpass'];
        $newpass = md5($newpassform);
        $newpassverify = md5($_POST['newpassverify']);
        $query   = mysql_query("SELECT * FROM  users WHERE username = '$playerCurrent'");
        $result  = mysql_fetch_array($query);
        if ($result['password'] == $oldPassword) {
        	if ($newpassform && ($newpass == $newpassverify)) {
            	mysql_query("UPDATE users SET password = '$newpass' WHERE username = '$playerCurrent'");
                msgAndGoBack('Twoje hasło zostało zmienione..', 1, 0, 1);
        	}
        	if ($email) {
        		mysql_query("UPDATE users SET email = '$email' WHERE username = '$playerCurrent'");
				msgAndGoBack('Twój email został zmieniony.', 1, 0, 1);
        	}
        	if ($playerNew) {
	        	mysql_query("UPDATE users SET username = '$playerNew' WHERE username = '$playerCurrent'");
				msgAndGoBack('Twoja nazwa gracza została zmieniona. Zostaniesz wylogowany/a za 5 sekund, zaloguj się ponownie z nowymi danymi.', 1, 0, 1);
            	echo '<meta http-equiv="refresh" content="5; url=../verify?logout=indeed" />';
        	}
		} else {
		msgAndGoBack('Hasło jest niepoprawne lub nie zostało wpisane.', 0, 0, 1);
		}
}

$ch = curl_init();
curl_setopt ($ch, CURLOPT_URL, 'https://minecraft.net/haspaid.jsp?user='.$user.''); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 0); 
$sprawdz = curl_exec($ch); 
curl_close($ch); 
if ($sprawdz == 'true') {
	$premium = 'Tak';
} else {
	$premium = 'Nie';
}
$bier  = mysql_query("SELECT * FROM  users WHERE username = '$user'");
while ($rower = mysql_fetch_assoc($bier)) {
	$ostlogowanie = date("H:i d-m-Y",substr($rower['ostatnilog'], 0, 10));
echo '<form method="post" action="../profile?edit" class="form-horizontal" />';
echo '<br><br><br>
						  <div class="form-group">
						    <label for="focusedinput" class="col-sm-3 control-label">ID Gracza</label>
						    <div class="col-sm-6">
						      <input type="text" class="form-control" id="focusedinput" value="'.$rower['id'].'" disabled />
						    </div>
						  </div>

						  <div class="form-group">
						    <label for="focusedinput" class="col-sm-3 control-label">Ostatnie Logowanie</label>
						    <div class="col-sm-6">
						      <input type="text" class="form-control" id="focusedinput" value="'.$ostlogowanie.'" disabled />
						    </div>
						  </div>

						  <div class="form-group">
						    <label for="focusedinput" class="col-sm-3 control-label">Adres IP</label>
						    <div class="col-sm-6">
						      <input type="text" class="form-control" id="focusedinput" value="'.$rower['ip'].'" disabled />
						    </div>
						  </div>

						 <div class="form-group">
						    <label for="focusedinput" class="col-sm-3 control-label">Konto Premium</label>
						    <div class="col-sm-6">
						      <input type="text" class="form-control" id="focusedinput" value="'.$premium.'" disabled />
						    </div>
						  </div>

						  <br><br>

						  <div class="form-group">
						    <label for="focusedinput" class="col-sm-3 control-label">Nazwa użytkownika</label>
						    <div class="col-sm-6">
						      <input type="text" class="form-control" id="focusedinput" placeholder="'.$user.'" name="player" />
						    </div>
						  </div>

						 <div class="form-group">
						    <label for="focusedinput" class="col-sm-3 control-label">Email kontaktowy</label>
						    <div class="col-sm-6">
						      <input type="text" class="form-control" id="focusedinput" placeholder="'.$rower['email'].'" name="email" />
						    </div>
						  </div>

						  <div class="form-group">
						    <label for="focusedinput" class="col-sm-3 control-label">Nowe hasło</label>
						    <div class="col-sm-6">
						      <input type="password" class="form-control" id="focusedinput" name="newpass" />
						    </div>
						  </div>

						  <div class="form-group">
						    <label for="focusedinput" class="col-sm-3 control-label">Nowe hasło (powtórz)</label>
						    <div class="col-sm-6">
						      <input type="password" class="form-control" id="focusedinput" name="newpassverify" />
						    </div>
						  </div>

						<br><br>

						  <div class="form-group">
						    <label for="focusedinput" class="col-sm-3 control-label">Hasło (weryfikacja)</label>
						    <div class="col-sm-6">
						      <input type="password" class="form-control" id="focusedinput" name="password" required/>
						    </div>
						  </div>

						  <div class="btn-toolbar">
					      			<button type="submit" class="btn-primary btn">Wyślij</button>
				      	  </div>

						  </form>
						  ';

}
?>
</center>
</div></div></div></div></div></div>