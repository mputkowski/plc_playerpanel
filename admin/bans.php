<?php
require($_SERVER["DOCUMENT_ROOT"] . "/utils/pp_kernel/global.php");
header('Content-Type: text/html; charset=utf-8');
mysql_set_charset('utf8');
if ($admins) {
    $user = $_SESSION['user'];
	echo "
<div id='page-content'>
    <div id='wrap'>
        <div id='page-heading'>
            <h1>Banowanie Graczy</h1>
        </div>
<div class='container'>
            <div class='row'>
                <div class='col-sm-12'>
                  <div class='panel panel-primary'>
                      <div class='panel-heading'>
                          <h4>Usuń Gracza z Banlisty</h4>
                          </div> <br>
                        <FORM ACTION='?admin=del' METHOD=POST class='form-horizontal'>
                          <div class='form-group'>
                            <div class='col-sm-6'>
                              <input type='text' class='form-control' name='name' id='focusedinput' placeholder='Nazwa gracza' required/>
                            </div>
                          </div>
<br>
                          <div class='btn-toolbar'>
                                    <button type='submit' class='btn-primary btn'>Usuń</button>
                          </div>
                          </form>
</div>
</div>
</div>
</div>

<div class='container'>
            <div class='row'>
                <div class='col-sm-12'>
                  <div class='panel panel-primary'>
                      <div class='panel-heading'>
                          <h4>Dodaj Gracza do Banlisty</h4>
                          </div> <br>
                        <FORM ACTION='?admin=add' METHOD=POST class='form-horizontal'>
                          <div class='form-group'>
                            <div class='col-sm-6'>
                              <input type='text' class='form-control' name='name' id='focusedinput' placeholder='Nazwa gracza' required/>
                            </div>
                          </div>
                          <div class='form-group'>
                            <div class='col-sm-6'>
                              <input type='text' class='form-control' name='reason' id='focusedinput' placeholder='Powód' required/>
                            </div>
                          </div>
                          <div class='btn-toolbar'>
                                    <button type='submit' class='btn-primary btn'>Dodaj</button>
                          </div>
                          </form>
</div>
</div>
</div>
</div>
";
}
if ($_GET[admin] == 'del') {
    $name = mysql_real_escape_string($_POST['name']);
    mysql_query("DELETE FROM bans WHERE `name` = '$name'");
    msgAndGoBack('Gracz został odbanowany.', 1, 0, 1);
}
if ($_GET[admin] == 'add') {
    $name     = mysql_real_escape_string($_POST['name']);
    $reason   = mysql_real_escape_string($_POST['reason']);
    $admin    = $user;
    $time     = date(U);
    $expires = '0';
	mysql_query("INSERT INTO bans (name,reason,banner,time,expires) VALUES ('$name','$reason','$admin','$time','$expires')") or die(mysql_error());
  msgAndGoBack('Gracz został zbanowany.', 1, 0, 1);
}
?>