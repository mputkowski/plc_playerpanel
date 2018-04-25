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
   <script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'white'
 };
 </script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body class="focusedform">
<div class="verticalcenter">
  <img src="assets/img/logo-big.png" alt="Logo" class="brand" />
  <div class="panel panel-primary">
    <div class="panel-body">
      <h4 class="text-center" style="margin-bottom: 25px;">Rejestracja</h4>
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
                  <span class="input-group-addon"><i class="icon-lock"></i></span>
                  <input type="password" class="form-control" name="password" placeholder="Hasło" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <span class="input-group-addon"><i class="icon-lock"></i></span>
                  <input type="password" class="form-control" name="password-verify" placeholder="Hasło (powtórz)" />
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
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                <center>
                   <?php
                     require_once('utils/functions/recaptcha.php');
                     $publickey = "6LeSSu8SAAAAAKEnDuttK-JZy-wSiRQ3uegrNgHR";
                     echo recaptcha_get_html($publickey);
                   ?>
                </center>
                </div>
              </div>
            </div>
            <div class="clearfix">
              <div class="pull-right"></div>
            </div>
            <div class="pull-right">
        <input type="submit" class="btn btn-primary" value="Zarejestruj się">
            </div>
       </form>
    </div>
  </div>
 </div>
</body>
</html>

<?php
if (isset($_GET['send'])) {
    require("utils/config.php");
    mysql_connect($dbip, $dbuser, $dbpass);
    mysql_set_charset('utf8');
    mysql_select_db('polandcraft_playerpanel');
    $name        = mysql_real_escape_string($_POST['name']);
    $email       = mysql_real_escape_string($_POST['email']);
    $passwordEmail = mysql_real_escape_string($_POST['password']);
    $password    = md5($_POST['password']);
    $passwordVerify    = md5($_POST['password-verify']);
    $queryName       = "SELECT * FROM users WHERE username ='$name'";
    $resName         = mysql_query($queryName);
    $queryEmail       = "SELECT * FROM users WHERE email ='$email'";
    $resEmail         = mysql_query($queryEmail);
    require_once('utils/functions/recaptcha.php');
    $privatekey = "6LeSSu8SAAAAAH_WdWsq5p0dyBXgGgQUC-VTBfZY";
    $captchaResponse = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
	include("/var/www/panelgracza/utils/classes/admins.php");
    if (mysql_num_rows($resName) == 0 && mysql_num_rows($resEmail) == 0) {
				if (!$name or !$email) {
					echo '<div class="alert alert-dismissable alert-danger">
                                <strong>Auto stop!</strong> Niewypełniłeś/aś wszystkich wymaganych pul.
                            </div>';
                } else {
                  if ($password == $passwordVerify) {
                    if ($captchaResponse->is_valid) {
                        echo '<div class="alert alert-dismissable alert-success">
                                <strong>Oh yeah!</strong> Zostałeś zarejestrowany, na twój email zostały wysłane informacje dotyczące twojej rejestracji.
                            </div>';
            mysql_query("INSERT INTO users (username,password,email) VALUES ('$name','$password','$email')") or die(mysql_error());
						$_SESSION['passwd'] = $pass;
						$msg = "Witaj, ".$name."\n\nTwoja nazwa gracza to: ${name}\nTwoje hasło to: ${passwordEmail}";
						$from = "noreply@ionet.pro";
						$headers = "From:" . $from;
						mail($email,"Rejestracja w Panelu Gracza",$msg,$headers);
          } else {
            echo '<div class="alert alert-dismissable alert-danger">
                                <strong>Auto stop!</strong> Kod weryfikujący nie zgadza się.
                            </div>';
          }
        } else {
                        echo '<div class="alert alert-dismissable alert-danger">
                                <strong>Auto stop!</strong> Wpisane hasła nie zgadzają się.
                            </div>';
          }
        }
    } else {
					echo '<div class="alert alert-dismissable alert-danger">
                                <strong>Auto stop!</strong> Konto o tej nazwie juz istnieje, lub ten email został już użyty.
                            </div>';
    }
}
?>