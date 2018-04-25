<?php
$admin = array("deltadevil360","ActimelPL","Michu189PL","TrylekPl","7err0r");
$admins = in_array($_SESSION['user'], $admin);
$strladm = array_map('strtolower', $admin);