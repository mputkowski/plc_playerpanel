<?php
function msgAndGoBack($msg, $type, $goBack, $showBR) {
	if ($showBR == 1) {
		echo '<br>';
	}
	if ($type == 0) {
				echo '<div class="alert alert-dismissable alert-danger">
                                <strong>Auto stop!</strong> '.$msg.'
                            </div>';
    } elseif ($type == 1) {
				echo '<div class="alert alert-dismissable alert-success">
                                <strong>Oh yeah!</strong> '.$msg.'
                            </div>';
    }
    if ($goBack == 1) {
				echo "<div class='btn-toolbar'>
									<button type='button' class='btn-primary btn' onclick=window.location.href='?'>Wróć</button>
				      	  </div>";
	}
}
 
function getStatus($url) {
    if (in_array('curl', get_loaded_extensions())) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $source = curl_exec($curl);
        curl_close($curl);
    } else {
        $source = file_get_contents($url);
    }
    return $source;
}

?>