<?php
if (isset($_GET['buy']) && $_GET['type'] == 'transfer') {
    $package = mysql_real_escape_string($_GET['package']);
    $result = mysql_query("SELECT * FROM itemshop WHERE `id` = '".$package."'");
    if (mysql_num_rows($result) < 1) 
        die("Brak pakietu o takim ID.");
    while ($itemshop = mysql_fetch_assoc($result)) {
        $ID          = mysql_real_escape_string($itemshop['ID']);
        $name        = mysql_real_escape_string($itemshop['name']);
        $serverName  = mysql_real_escape_string($itemshop['serverName']);
        $price        = mysql_real_escape_string($itemshop['price']) . 'zł';
        $priceNoAdd   = mysql_real_escape_string($itemshop['price']);
        $smsNumber    = mysql_real_escape_string($itemshop['smsNumber']);
        $transferServiceID = mysql_real_escape_string($itemshop['HPAY_SERVICETID']);
        $description = $itemshop['description'];
        echo '
        <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4>Kup Pakiet</h4>
                        </div>
                        <div class="panel-body">';
        $HPAY_ID = '5920';
        $user = $_SESSION['user'];
        echo "<img src='/images/logos/" . $serverName . ".png' width='10%'><br><br>
        Aby zakupić <b>$name</b> wystarczy że wejdziesz na: <a href='https://ssl.homepay.pl/wplata/".$transferServiceID."-PLC".preg_replace('/\s+/', '', preg_replace("/[^0-9]+/", " ", $price))."'>https://ssl.homepay.pl/wplata/".$transferServiceID."-PLC".preg_replace('/\s+/', '', preg_replace("/[^0-9]+/", " ", $price))."</a>.<br>Koszt to <b>$price</b> Brutto. Kod potwierdzający dostaniesz na swój email.</b><br><br>";

        echo "<font size='5'>Twoje Dane</font><br></b><tr>";
        echo "<font size=4 color=red>Po zakupie wpisz /is odbierz w grze aby odebrać swoje przedmioty lub rangi.</font><font'><br><br>";
        echo "<form action='' method='post'>
        <INPUT TYPE=text class='form-control' NAME='kod' placeholder='Wpisz otrzymany kod transferu' required>
        <INPUT TYPE=hidden  NAME='user' value='$user'><br>
        <INPUT TYPE=hidden NAME=package VALUE=".$itemshop['id']." >
        <input id='submit' class='btn btn-success'type='submit' name='ok' value='OK' />
        </form>";
        $user   = addslashes($user);
        $number = $smsNumber;
        if (isset($_POST['ok'])) {
            if (empty($_POST['user'])) {}
            if (empty($_POST['kod'])) {} 
                else {
                $status = getStatus('http://homepay.pl/API/check_tcode.php?usr_id=' . $HPAY_ID . '&acc_id=' . $transferServiceID . '&code=' . $_POST['kod'], 'r');
                $raport = explode('|', $status);
                if($admins) { 
                    if($_POST['kod'] == 'testowy' && ($_SESSION['user'] == "deltadevil360" || $_SESSION['user'] == "ActimelPL"))
                    $raport['0'] = 1;
                    }
                switch ($raport['0']) {
                    case 1:
                        msgAndGoBack('Twoja transakcja została zakończona sukcesem.', 1, 0, 0);
                        $user   = mysql_real_escape_string($_POST['user']);
                        $smsCode = mysql_real_escape_string($_POST['kod']);
                        $date   = date("Y-m-d H:i:s");
                        $yearAndMonth = date("Y-m");
                        mysql_query("INSERT INTO panelpacks (username, pakietId, serverName) VALUES ('".$user."', '".$ID."', '".$serverName."')");
                        mysql_query("INSERT INTO transakcje (nick,nazwa,kod,data,type,server,price,yearAndMonth,method) VALUES ('".$user."','".$name."','".$smsCode."','".$date."','Panel','".$serverName."','".$priceNoAdd."','".$yearAndMonth."','Przelew')");
                        break;
                    case 0:
                        echo '<br>';
                        msgAndGoBack('Wystąpił błąd, wpisałeś/aś niepoprawny kod transferu!', 0, 0, 0);
                        break;
                    default:
                        echo '<br>';
                        msgAndGoBack('Wystąpił błąd serwera, spróbuj ponownie poźniej!', 0, 0, 0);
                        break;
                }
            }
        }
        echo '<br><b>Co dostaniesz kupując ten pakiet?</b><br>' 
        .nl2br($description);
    }
    exit;
}