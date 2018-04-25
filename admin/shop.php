<?php
require($_SERVER["DOCUMENT_ROOT"] . "/utils/pp_kernel/global.php");
?>

<div ID="page-content">
    <div ID="wrap">
        <div ID="page-heading">
            <h1>Edytuj Sklep</h1>
		</div>
<div class='container'>

<?php
if ($admins) {
header('Content-Type: text/html; charset=utf-8');
mysql_set_charset('utf8');


function displayMenu($serverName, $serverID, $admins) {
echo '
<div class="col-xs-12">
<div class="panel panel-primary">
<div class="panel-heading">
<img src="../images/logos/'.$serverName.'.png" width="5%">
<div class="options">
</div>
</div>
<div class="panel-body">
<div class="table-responsive">
<table class="table">
<thead>
<tr>
<th style="padding-right:100px">Pakiet</th>
<th>Cena</th>
<th></th>
</tr>
</thead>
';
$result = mysql_query("SELECT * FROM itemshop WHERE serverID = '".$serverID."' ORDER BY `ID` ASC");
while ($is = mysql_fetch_assoc($result)) {
echo "<tbody>
<tr>
<td>" . $is['name'] . "</td>
<td>" . $is['price'] . "zł</td>
<td>
<a href='./shop?admin=edit&package=". $is['ID'] ."' class='btn btn-success'>Edytuj</a>
</td>
<td>
<a href='./shop?admin=del&package=". $is['ID'] ."' class='btn btn-success'>Usuń</a>
</td>
</td>
</tr>
</thead>";
}
echo "</table></div></div></div></div><br>";
}

function serviceIDs($s) {
	if ($s == '7055') {
		return "15500";
	} elseif ($s == '7155') {
		return "15502";
	} elseif ($s == '7255') {
		return "15503";
	} elseif ($s == '7355') {
		return "15504";
	} elseif ($s == '7455') {
		return "15505";
	} elseif ($s == '7555') {
		return "15506";
	} elseif ($s == '7655') {
		return "15507";
	} elseif ($s == '7955') {
		return "15508";
	} elseif ($s == '91055') {
		return "15509";
	} elseif ($s == '91155') {
		return "15652";
	} elseif ($s == '91455') {
		return "15653";
	} elseif ($s == '91955') {
		return "15654";
	} elseif ($s == '92055') {
		return "15510";
	} elseif ($s == '92555') {
		return "15511";
	} elseif ($s == 'testowy') {
		return "00000";
	}
}


function serviceTIDs($s) {
	if ($s == '7055') {
		return "6442";
	} elseif ($s == '7155') {
		return "6443";
	} elseif ($s == '7255') {
		return "6444";
	} elseif ($s == '7355') {
		return "6445";
	} elseif ($s == '7455') {
		return "6446";
	} elseif ($s == '7555') {
		return "6447";
	} elseif ($s == '7655') {
		return "6448";
	} elseif ($s == '7955') {
		return "6449";
	} elseif ($s == '91055') {
		return "6455";
	} elseif ($s == '91155') {
		return "6450";
	} elseif ($s == '91455') {
		return "6451";
	} elseif ($s == '91955') {
		return "6452";
	} elseif ($s == '92055') {
		return "6453";
	} elseif ($s == '92555') {
		return "6454";
	} elseif ($s == 'testowy') {
		return "0000";
	}
}

function prices($s) {
	if ($s == '7055') {
		return "0.62";
	} elseif ($s == '7155') {
		return "1.24";
	} elseif ($s == '7255') {
		return "2.46";
	} elseif ($s == '7355') {
		return "3.69";
	} elseif ($s == '7455') {
		return "4.92";
	} elseif ($s == '7555') {
		return "6.15";
	} elseif ($s == '7655') {
		return "7.38";
	} elseif ($s == '7955') {
		return "11.07";
	} elseif ($s == '91055') {
		return "12.30";
	} elseif ($s == '91155') {
		return "13.53";
	} elseif ($s == '91455') {
		return "17.22";
	} elseif ($s == '91955') {
		return "23.37";
	} elseif ($s == '92055') {
		return "26.60";
	} elseif ($s == '92555') {
		return "30.75";
	} elseif ($s == 'testowy') {
		return "99.99";
	}
}

function serverNames($s) {
	if ($s == 'metropolic') {
		return "1";
	} elseif ($s == 'evelated') {
		return "2";
	} elseif ($s == 'hardore') {
		return "3";
	} elseif ($s == 'spacefun') {
		return "4";
	} elseif ($s == 'nesteria') {
		return "5";
	}
}


if ($_GET[admin] == 'add') {
        $dod = mysql_real_escape_string($_POST['dodaj']);
        if ('dodaj' == $dod) {
        $ID          = mysql_real_escape_string($_POST['ID']);
        $name        = mysql_real_escape_string($_POST['name']);
        $serverName  = mysql_real_escape_string($_POST['serverName']);
        $smsNumber   = mysql_real_escape_string($_POST['smsNumber']);
        $price       = mysql_real_escape_string(prices($smsNumber));
        $serviceID   = mysql_real_escape_string(serviceIDs($smsNumber));
        $serviceTID   = mysql_real_escape_string(serviceTIDs($smsNumber));
        $serverID    = mysql_real_escape_string(serverNames($serverName));
        $description = mysql_real_escape_string($_POST['description']);
        $rank        = mysql_real_escape_string($_POST['rank']);
        $commands       = mysql_real_escape_string($_POST['commands']);
        $rankNum     = mysql_real_escape_string($_POST['rankNum']);

        	if (!$name or !$description or !$smsNumber or !$serverName) {
        		msgAndGoBack('Nein nein nein, sprawdź czy wypełniłeś/aś wszystkie pola!', 0, 1, 0);
        		exit;
        	}

            $user = addslashes($user);
            $dodaj = mysql_query("INSERT INTO itemshop (name,serverName,serverID,price,HPAY_SERVICEID,HPAY_SERVICETID,smsNumber,description,rank,ranknum,commands) VALUES ('$name','$serverName','$serverID','$price','$serviceID','$serviceTID','$smsNumber','$description','$rank','$ranknum','$commands') ") or die(mysql_error());
			msgAndGoBack('Nowy pakiet został dodany.', 1, 1, 0);
        } else {
            echo '<div class="container">
			<div class="row">
				<div class="col-sm-12">
				  <div class="panel panel-primary">
				      <div class="panel-heading">
				          <h4>Dodawanie Pakietu</h4>
				          </div>';
			echo "<br><div class='btn-toolbar'>
									<button type='button' class='btn-primary btn' onclick=window.location.href='?'>Wróć</button>
				      	  </div>";
            echo "<FORM ACTION='' METHOD=POST class='form-horizontal'>";
            echo '<br><div class="form-group">
						    <label for="focusedinput" class="col-sm-3 control-label">Nazwa Pakietu</label>
						    <div class="col-sm-6">
						      <input type="text" class="form-control" id="focusedinput" name="name" required/>
						    </div>
						  </div>';
			echo '<div class="form-group">
						  	<label for="radio" class="col-sm-3 control-label">Numer SMS (Cena)</label>
						  	<div class="col-sm-6">
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="7055" > 7055 (0.62zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="7155" > 7155 (1.23zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="7255" > 7255 (2.46zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="7355" > 7355 (3.69zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="7455" > 7455 (4.92zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="7555" > 7555 (6.15zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="7655" > 7655 (7.38zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="7955" > 7955 (11.07zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="91055" > 91055 (12.30zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="91155" > 91155 (13.53zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="91455" > 91455 (17.22zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="91955" > 91955 (23.37zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="92055" > 92055 (26.60zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="92555" > 92555 (30.75zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="testowy" > Testowy (0.00zł)</label></div>
						  	</div>
						  </div>';
			echo '<div class="form-group">
						  	<label for="radio" class="col-sm-3 control-label">Serwer</label>
						  	<div class="col-sm-6">
						  		<div class="radio block"><label><input type="radio" name="serverName" value="metropolic" > Metropolic</label></div>
						  		<div class="radio block"><label><input type="radio" name="serverName" value="evelated" > Evelated</label></div>
						  		<div class="radio block"><label><input type="radio" name="serverName" value="hardore" > Hardore</label></div>
						  		<div class="radio block"><label><input type="radio" name="serverName" value="spacefun" > Spacefun</label></div>
						  		<div class="radio block"><label><input type="radio" name="serverName" value="nesteria" > Nesteria</label></div>
						  	</div>
						  </div>';
            echo '<div class="form-group">
						    <label for="focusedinput" class="col-sm-3 control-label">Okres ważności grupy</label>
						    <div class="col-sm-6">
						      <input type="text" class="form-control" id="focusedinput" name="ranknum"/>
						    </div>
						  </div>';
            echo '<div class="form-group">
						    <label for="focusedinput" class="col-sm-3 control-label">Nazwa grupy</label>
						    <div class="col-sm-6">
						      <input type="text" class="form-control" id="focusedinput" name="rank"/>
						    </div>
						  </div>';

			echo '<div class="form-group">
						  	<label class="col-sm-3 control-label">Komendy do wykonania ([p] to nazwa gracza)</label>
						  	<div class="col-sm-6"><textarea name="commands" cols="50" rows="10" class="form-control">'.$row['commands'].'</textarea></div>
						  </div>';

			echo '<div class="form-group">
						  	<label class="col-sm-3 control-label">Opis Pakietu</label>
						  	<div class="col-sm-6"><textarea name="description" cols="50" rows="10" class="form-control"></textarea></div>
						  </div>';

            echo "<INPUT type=hidden name=dodaj value=dodaj>
            <div class='btn-toolbar'>
            <input type='submit' class='btn btn-success' value='Dodaj' />
            </form>
            </div>";
            echo "</div></div></div></div>";
        }
        exit;
    }

	
    //EDYTOWANIE
    if ($_GET[admin] == 'edit') {
        $package = mysql_real_escape_string($_GET['package']);
        $result  = mysql_query(" SELECT * FROM itemshop WHERE `ID` = '" . $package . "' ");
        $doit    = mysql_real_escape_string($_POST['edit']);
        if ('edit' == $doit) {
        $ID          = mysql_real_escape_string($package);
        $name        = mysql_real_escape_string($_POST['name']);
        $serverName  = mysql_real_escape_string($_POST['serverName']);
        $smsNumber   = mysql_real_escape_string($_POST['smsNumber']);
        $price       = mysql_real_escape_string(prices($smsNumber));
        $serviceID   = mysql_real_escape_string(serviceIDs($smsNumber));
        $serviceTID   = mysql_real_escape_string(serviceTIDs($smsNumber));
        $serverID    = mysql_real_escape_string(serverNames($serverName));
        $description = mysql_real_escape_string($_POST['description']);
        $rank        = mysql_real_escape_string($_POST['rank']);
        $commands       = mysql_real_escape_string($_POST['commands']);
        $rankNum     = mysql_real_escape_string($_POST['rankNum']);

        	if (!$name or !$description or !$smsNumber) {
        		msgAndGoBack('Nein nein nein, sprawdź czy wypełniłeś/aś wszystkie pola!', 0, 1, 0);
        		exit;
        	}

            $zapytanie = "UPDATE itemshop SET `name` = '$name', `price` = '$price', `HPAY_SERVICEID` = '$serviceID', `HPAY_SERVICETID` = '$serviceTID', `smsNumber` = '$smsNumber', `description` = '$description', `rank` = '$rank', `ranknum` = '$rankNum', `commands` = '$commands' WHERE ID ='$ID'";
            mysql_query($zapytanie) or die(mysql_error());
            msgAndGoBack('Pakiet o ID '.$ID.' został edytowany.', 1, 0, 0);
        }
        while ($row = mysql_fetch_assoc($result)) {
echo '<div class="container">
			<div class="row">
				<div class="col-sm-12">
				  <div class="panel panel-primary">
				      <div class="panel-heading">
				          <h4>Edytowanie Pakietu</h4>
				          </div>';
			echo "<br><div class='btn-toolbar'>
									<button type='button' class='btn-primary btn' onclick=window.location.href='?'>Wróć</button>
				      	  </div>";
            echo "<FORM ACTION='' METHOD=POST class='form-horizontal'>";
            echo '<br><div class="form-group">
						    <label for="focusedinput" class="col-sm-3 control-label">Nazwa Pakietu</label>
						    <div class="col-sm-6">
						      <input type="text" class="form-control" id="focusedinput" name="name" value="'.$row['name'].'" required/>
						    </div>
						  </div>';
            echo '<div class="form-group">
						    <label for="focusedinput" class="col-sm-3 control-label">Cena</label>
						    <div class="col-sm-6">
						      <input type="text" class="form-control" id="focusedinput" value="'.$row['price'].'" disabled/>
						    </div>
						  </div>';
            echo '<div class="form-group">
						    <label for="focusedinput" class="col-sm-3 control-label">Numer SMS</label>
						    <div class="col-sm-6">
						      <input type="text" class="form-control" id="focusedinput" name="smsNumber" value="'.$row['smsNumber'].'" disabled/>
						    </div>
						  </div>';
			echo '<div class="form-group">
						  	<label for="radio" class="col-sm-3 control-label">Nowy Numer SMS (Cena)</label>
						  	<div class="col-sm-6">
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="'.$row['smsNumber'].'" checked> Bez zmian.</label></div>	
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="7055" > 7055 (0.62zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="7155" > 7155 (1.23zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="7255" > 7255 (2.46zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="7355" > 7355 (3.69zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="7455" > 7455 (4.92zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="7555" > 7555 (6.15zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="7655" > 7655 (7.38zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="7955" > 7955 (11.07zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="91055" > 91055 (12.30zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="91155" > 91155 (13.53zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="91455" > 91455 (17.22zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="91955" > 91955 (23.37zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="92055" > 92055 (26.60zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="92555" > 92555 (30.75zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="smsNumber" value="testowy" > Testowy (99.99zł)</label></div>
						  	</div>
						  </div>';
            echo '<div class="form-group">
						    <label for="focusedinput" class="col-sm-3 control-label">Okres ważności grupy</label>
						    <div class="col-sm-6">
						      <input type="text" class="form-control" id="focusedinput" name="rankNum" value="'.$row['ranknum'].'"/>
						    </div>
						  </div>';
            echo '<div class="form-group">
						    <label for="focusedinput" class="col-sm-3 control-label">Nazwa grupy</label>
						    <div class="col-sm-6">
						      <input type="text" class="form-control" id="focusedinput" name="rank" value="'.$row['rank'].'"/>
						    </div>
						  </div>';

			echo '<div class="form-group">
						  	<label class="col-sm-3 control-label">Komendy do wykonania ([p] to nazwa gracza)</label>
						  	<div class="col-sm-6"><textarea name="commands" cols="50" rows="10" class="form-control">'.$row['commands'].'</textarea></div>
						  </div>';

			echo '<div class="form-group">
						  	<label class="col-sm-3 control-label">Opis Pakietu</label>
						  	<div class="col-sm-6"><textarea name="description" cols="50" rows="10" class="form-control">'.$row['description'].'</textarea></div>
						  </div>';

            echo "<INPUT type=hidden name=edit value=edit>
            <INPUT type=hidden name=pakiet value=" . $row['ID'] . ">
            <div class='btn-toolbar'>
            <input type='submit' class='btn btn-success' value='Edytuj' />
            </form>
            </div>";
            echo "</div></div></div></div>";
        }
        exit;
    }

    //USUWANIE
	    if ($_GET[admin] == 'del') {
        $package = mysql_real_escape_string($_GET['package']);
        echo "   <script type='text/javascript'>
 var RecaptchaOptions = {
    theme : 'clean'
 };
 </script>";
		echo '<div class=container>
			<div class="row">
				<div class="col-sm-12">
				  <div class="panel panel-primary">
				      <div class="panel-heading">
				          <h4>Usuń Pakiet</h4>
				          </div>';
		echo "Czy aby napewno chcesz usunąć pakiet o ID $package?<br><br>";
		echo "
		<form action='?admin=delconfirm&package=".$package."' method=post  class='form-horizontal' >
						   <div class='btn-toolbar'>
					      			<button type='submit' class='btn-primary btn'>Usuń</button>
									<button type='button' class='btn-primary btn' onclick=window.location.href='?'>Anuluj</button>
				      	  </div>
		</form>";
		die();
    }
    if ($_GET[admin] == 'delconfirm') {
        $package = mysql_real_escape_string($_GET['package']);
		if ($package) {
			mysql_query("DELETE FROM itemshop WHERE `ID`='$package'");
			msgAndGoBack('Usunięto pakiet o ID '.$package.'', 1, 1, 0);
			die();
		} else {
			msgAndGoBack('Coś nie wyszło.', 0, 1, 0);
			die();
		}
    }

echo "<div class='btn-toolbar'><button type='button' class='btn-primary btn' onclick=window.location.href='./shop?admin=add'>Dodaj nowy pakiet</button></div><br>";
displayMenu("metropolic", "1", $admins);
displayMenu("evelated", "2", $admins);
//displayMenu("hardore", "3", $admins);
displayMenu("nesteria", "5", $admins);
}
?>

</div>
</div>
</div>