<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', 'On');
*/
session_start();
require($_SERVER["DOCUMENT_ROOT"] . "/utils/config.php");
mysql_connect($dbip, $dbuser, $dbpass) or die("<title>Błąd</title><h1>Panel Gracza jest chwilowo niedostępny.</H1>Wysłaliśmy bardzo inteligente małpy aby poradziły sobie z tym problemem.");
mysql_select_db("polandcraft_playerpanel");
header('Content-Type: text/html; charset=utf-8');
mysql_set_charset('utf8');

if (isset($_GET['logout'])) {
    setcookie("verify", $cookie, time() - 3600);
    header('Location: //panel.polandcraft.eu/ ');
    exit();
}

function logincheck($error) {
echo '

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
  <link href="//panel.polandcraft.eu/assets/css/styles.min.css" rel="stylesheet" type="text/css" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body class="focusedform">
<div class="verticalcenter">
  <img src="//panel.polandcraft.eu/assets/img/logo-big.png" alt="Logo" class="brand" />
  <div class="panel panel-primary">
    <div class="panel-body">
      <h4 class="text-center" style="margin-bottom: 25px;">Użyj loginu z serwera aby się zalogować.</h4>
        <form method="post" class="form-horizontal" style="margin-bottom: 0px !important;" />
		        '.$error.'
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <span class="input-group-addon"><i class="icon-user"></i></span>
                  <input type="text" class="form-control" id="username" name="login" placeholder="Nazwa użytkownika" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <span class="input-group-addon"><i class="icon-lock"></i></span>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Hasło" />
                </div>
              </div>
            </div>
            <div class="clearfix">
              <div class="pull-right"></div>
            </div>
            <div class="pull-right">
        <a href="../register" class="btn btn-success">Zarejestruj się</a>
        <input type="submit" class="btn btn-primary" name="ok" value="Zaloguj się">
            </div>
       </form>
    </div>
    <div class="panel-footer">
      <a href="../forgot" class="pull-left btn btn-link" style="padding-left:0">Zapomniane hasło?</a>
    </div>
  </div>
 </div>
</body>
</html>
';
die();
}

if (isset($_POST['password']) and isset($_POST['login'])) {
    if (empty($_POST['login']) || empty($_POST['password'])) {
        logincheck('<div class="alert alert-dismissable alert-danger">
                                <strong>Auto stop!</strong> Wypełnij wszystkie pola.
                            </div>');
    }
    $login = mysql_real_escape_string($_POST['login']);
    $pass  = mysql_real_escape_string($_POST['password']);
    $user  = mysql_real_escape_string($login);
    $sql   = "SELECT * FROM users WHERE username = '$user'";
    $res   = mysql_query($sql);
    $arr   = mysql_fetch_array($res);
    $login = $arr["username"];
	$id = $arr["id"];
	if (!($arr['password'] == md5($pass))) {
        $adresip = $_SERVER['REMOTE_ADDR'];
        $time    = date('Y-m-d H:i:s');
        mysql_select_db("accounts");
        logincheck('<div class="alert alert-dismissable alert-danger">
                                <strong>Auto stop!</strong> Niepoprawny login lub hasło.
                            </div>');
    }
		mysql_select_db('servers');
		$cookie = md5($id . '%' . $arr['password']);
		$sql    = "UPDATE users SET cookie = '$cookie' WHERE username = '$user'";
		$_SESSION['user'] = $login;
		mysql_query($sql);
		setcookie("verify", $cookie, time() + 3600);
} else {
    if (!isset($_COOKIE['verify'])) {
        logincheck("");
    }
    $cookie = $_COOKIE['verify'];
    $found  = false;
    $sql    = "SELECT * FROM users WHERE cookie = '$cookie'";
    $res    = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $found = true;
    }
    if (!$found || empty($_SESSION['user'])) {
        logincheck("");
    }
}
?>