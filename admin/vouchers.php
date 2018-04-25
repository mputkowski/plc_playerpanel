<?php
require($_SERVER["DOCUMENT_ROOT"] . "/utils/pp_kernel/global.php");
?>

<div ID="page-content">
    <div ID="wrap">
        <div ID="page-heading">
            <h1>Lista Voucherów</h1>
		</div>
<div class='container'>

<?php
function generateCode($length) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

if ($_GET[admin] == 'add') {
        $dod = mysql_real_escape_string($_POST['dodaj']);
        if ('dodaj' == $dod) {
        $code   = generateCode(8);
        $price  = mysql_real_escape_string($_POST['price']);
        $serverName = mysql_real_escape_string($_POST['serverName']);
        $date   = date(U);
        $used   = mysql_real_escape_string($_POST['used']);
        $dodaj  = mysql_query("INSERT INTO vouchers (code,price,serverName,date) VALUES ('$code','$price','$serverName','$date')") or die(mysql_error());
		msgAndGoBack('Nowy voucher został dodany.', 1, 1, 0);
        } else {
            echo '<div class="container">
			<div class="row">
				<div class="col-sm-12">
				  <div class="panel panel-primary">
				      <div class="panel-heading">
				          <h4>Dodawanie Vouchera</h4>
				          </div>';
			echo "<br><div class='btn-toolbar'>
									<button type='button' class='btn-primary btn' onclick=window.location.href='?'>Wróć</button>
				      	  </div>";
            echo "<FORM ACTION='' METHOD=POST class='form-horizontal'>";
			echo '<div class="form-group">
						  	<label for="radio" class="col-sm-3 control-label">Numer SMS (Cena Vouchera)</label>
						  	<div class="col-sm-6">
						  		<div class="radio block"><label><input type="radio" name="price" value="7055" > 7055 (0.62zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="price" value="7155" > 7155 (1.23zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="price" value="7255" > 7255 (2.46zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="price" value="7355" > 7355 (3.69zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="price" value="7455" > 7455 (4.92zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="price" value="7555" > 7555 (6.15zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="price" value="7655" > 7655 (7.38zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="price" value="7955" > 7955 (11.07zł)</label></div>
								<div class="radio block"><label><input type="radio" name="price" value="91055" > 91055 (12.30zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="price" value="91155" > 91155 (13.53zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="price" value="91455" > 91455 (17.22zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="price" value="91955" > 91955 (23.37zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="price" value="92055" > 92055 (26.60zł)</label></div>
						  		<div class="radio block"><label><input type="radio" name="price" value="92555" > 92555 (30.75zł)</label></div>
						  	</div>
						  </div>';

			echo '<div class="form-group">
						  	<label for="radio" class="col-sm-3 control-label">Serwer</label>
						  	<div class="col-sm-6">
						  		<div class="radio block"><label><input type="radio" name="serverName" value="metropolic" > Metropolic</label></div>
						  		<div class="radio block"><label><input type="radio" name="serverName" value="evelated" > Evelated</label></div>
						  		<div class="radio block"><label><input type="radio" name="serverName" value="hardore" > Hardore</label></div>
						  		<div class="radio block"><label><input type="radio" name="serverName" value="nesteria" > Nesteria</label></div>
						  		<div class="radio block"><label><input type="radio" name="serverName" value="spacefun" > Spacefun</label></div>
						  	</div>
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


    //USUWANIE
	    if ($_GET[admin] == 'del') {
        $package = mysql_real_escape_string($_GET['package']);
		echo '<div class=container>
			<div class="row">
				<div class="col-sm-12">
				  <div class="panel panel-primary">
				      <div class="panel-heading">
				          <h4>Usuń Voucher</h4>
				          </div>';
		echo "Czy aby napewno chcesz usunąć voucher o ID $package?<br><br>";
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
			mysql_query("DELETE FROM vouchers WHERE `id`='$package'");
			msgAndGoBack('Usunięto voucher o ID '.$package.'', 1, 1, 0);
			die();
		} else {
			msgAndGoBack('Coś nie wyszło.', 0, 1, 0);
			die();
		}
    }

if ($admins) {
header('Content-Type: text/html; charset=utf-8');
mysql_set_charset('utf8');

echo "<div class='btn-toolbar'><button type='button' class='btn-primary btn' onclick=window.location.href='./vouchers?admin=add'>Dodaj nowy voucher</button></div><br>";
echo '
<div class="col-xs-12">
<div class="panel panel-primary">
<div class="panel-heading">
Vouchery
<div class="options">
</div>
</div>
<div class="panel-body">
<div class="table-responsive">
<table class="table">
<thead>
<tr>
<th style="padding-right:100px">Kod Vouchera</th>
<th>Kod SMS</th>
<th>Data utworzenia</th>
<th>Użyty</th>
<th>Użyty przez</th>
<th>Serwer</th>
</tr>
</thead>
';
$result = mysql_query("SELECT * FROM vouchers ORDER BY `id` ASC");
while ($i = mysql_fetch_assoc($result)) {
echo "<tbody>
<tr>
<td>
<div class='form-group'>
       <div class='col-sm-6'>
           <input type='text' class='form-control' value='".$i['code']."' onClick='this.select();' disabled>
      </div>
</div>
</td>
<td>" . $i['price'] . "</td>
<td>" . date("G:i d.m.Y", $i['date']) . "</td>
<td>" . $i['used'] . "</td>
<td>" . $i['usedby'] . "</td>
<td>" . ucfirst($i['serverName']) . "</td>
<td>
<a href='./vouchers?admin=del&package=". $i['id'] ."' class='btn btn-success'>Usuń</a>
</td>
</tr>
</thead>";
}
echo "</table></div></div></div></div><br>";
}
?>

</div>
</div>
</div>