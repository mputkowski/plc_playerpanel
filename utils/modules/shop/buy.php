<?php
header('Content-Type: text/html; charset=utf-8');
mysql_set_charset('utf8');

foreach( glob(dirname(__FILE__) . '/payment_methods/*.php') as $class_path )
		require_once( $class_path );
?>