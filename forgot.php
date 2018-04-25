<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="utf-8" />
  <title>Panel Gracza</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Panel Gracza @ PolandCraft.eu" />
  <meta name="author" content="ioNetwork Limited" />
  <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600" rel="stylesheet" type="text/css" />
  <link href="assets/css/styles.min.css" rel="stylesheet" type="text/css" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body class="focusedform">
<div class="verticalcenter">
  <img src="assets/img/logo-big.png" alt="Logo" class="brand" />
  <div class="panel panel-primary">
    <div class="panel-body">
      <h4 class="text-center" style="margin-bottom: 25px;">Przypomnienie Hasła</h4>
        <form method="post" action="?send" class="form-horizontal" style="margin-bottom: 0px !important;" />
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <span class="input-group-addon"><i class="icon-user"></i></span>
                  <input type="text" class="form-control" name="name" placeholder="Nazwa użytkownika" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <span class="input-group-addon"><i class="icon-inbox"></i></span>
                  <input type="email" class="form-control" name="email" placeholder="Email" />
                </div>
              </div>
            </div>
            <div class="clearfix">
              <div class="pull-right"></div>
            </div>
            <div class="pull-right">
        <input type="submit" class="btn btn-primary" value="Przypomnij">
            </div>
       </form>
    </div>
  </div>
 </div>
</body>
</html>

<?php
if (isset($_GET['send'])) {
function noweHaslo() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); 
}
    require("utils/config.php");
    mysql_connect($dbip, $dbuser, $dbpass);
    mysql_set_charset('utf8');
    mysql_select_db('polandcraft_playerpanel');
    $name        = mysql_real_escape_string($_POST['name']);
    $email       = mysql_real_escape_string($_POST['email']);
    $data        = date("Y-m-d H:i:s");
	  $pass 		 = noweHaslo();
    $query       = "SELECT * FROM users WHERE username ='$name' AND email='$email'";
    $res         = mysql_query($query);
	include("/var/www/panelgracza/utils/classes/admins.php");
    if (mysql_num_rows($res) > 0) {
				if (!$name or !$email) {
					echo '<div class="alert alert-dismissable alert-danger">
                                <strong>Auto stop!</strong> Niewypełniłeś/aś wszystkich wymaganych pul.
                            </div>';
                } elseif ($email == "your@email.com") {
					echo '<div class="alert alert-dismissable alert-danger">
                                <strong>Auto stop!</strong> Wystąpił błąd, skontaktuj się z administratorem.
                            </div>';
				} else {
                        echo '<div class="alert alert-dismissable alert-success">
                                <strong>Oh yeah!</strong> Nowe hasło zostało wysłane na twój email.
                            </div>';
						$zmienhaslo = "UPDATE users SET password='".md5($pass)."' WHERE username = '$name'";
						mysql_query($zmienhaslo);
						$_SESSION['passwd'] = $pass;
						$msg = "Witaj, ".$name."\n-------------------------------------------\nTwoje nowe hasło do Panelu Gracza to: ".$_SESSION['passwd']."\n-------------------------------------------";
						$from = "noreply@ionet.pro";
						$headers = "From:" . $from;
						mail($email,"Zmiana Hasła na Panelu Gracza @ PolandCraft.eu",$msg,$headers);
                }
    } else {
					echo '<div class="alert alert-dismissable alert-danger">
                                <strong>Auto stop!</strong> Konto o tej nazwie nie istnieje lub wpisany email jest niepoprawny.
                            </div>';
    }
}
?>