<?php 
require($_SERVER["DOCUMENT_ROOT"] . "/utils/pp_kernel/auth.php");
require($_SERVER["DOCUMENT_ROOT"] . "/utils/pp_kernel/admins.php");
require($_SERVER["DOCUMENT_ROOT"] . "/utils/pp_kernel/functions.php");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Panel Gracza</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="//panel.polandcraft.eu/assets/css/styles.min.css" rel="stylesheet" type='text/css' media="all" />
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css' />
    
	<!--[if lt IE 9]>
		<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
        <script type="text/javascript" src="//panel.polandcraft.eu/assets/plugins/charts-flot/excanvas.min.js"></script>
        <link rel="stylesheet" href="//panel.polandcraft.eu/assets/css/ie8.css">
	<![endif]-->


<link rel='stylesheet' type='text/css' href='//panel.polandcraft.eu/assets/plugins/form-daterangepicker/daterangepicker-bs3.css' /> 
<link rel='stylesheet' type='text/css' href='//panel.polandcraft.eu/assets/plugins/fullcalendar/fullcalendar.css' /> 
<link rel='stylesheet' type='text/css' href='//panel.polandcraft.eu/assets/plugins/form-markdown/css/bootstrap-markdown.min.css' /> 
<link rel='stylesheet' type='text/css' href='//panel.polandcraft.eu/assets/plugins/codeprettifier/prettify.css' /> 
<link rel='stylesheet' type='text/css' href='//panel.polandcraft.eu/assets/plugins/form-toggle/toggles.css' /> 


<script type='text/javascript' src='//panel.polandcraft.eu/assets/js/jquery-1.10.2.min.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/js/jqueryui-1.10.3.min.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/js/bootstrap.min.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/js/enquire.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/js/jquery.cookie.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/js/jquery.touchSwipe.min.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/js/jquery.nicescroll.min.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/plugins/codeprettifier/prettify.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/plugins/easypiechart/jquery.easypiechart.min.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/plugins/sparklines/jquery.sparklines.min.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/plugins/form-toggle/toggle.min.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/plugins/form-wysihtml5/wysihtml5-0.3.0.min.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/plugins/form-wysihtml5/bootstrap-wysihtml5.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/plugins/fullcalendar/fullcalendar.min.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/plugins/form-daterangepicker/daterangepicker.min.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/plugins/form-daterangepicker/moment.min.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/plugins/charts-flot/jquery.flot.min.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/plugins/charts-flot/jquery.flot.resize.min.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/plugins/charts-flot/jquery.flot.orderBars.min.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/js/placeholdr.js'></script> 
<script type='text/javascript' src='//panel.polandcraft.eu/assets/js/application.js'></script> 

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body class="">
    <div id="headerbar">
        <div class="container">
        </div>
    </div>

    <header class="navbar navbar-inverse navbar-fixed-top" role="banner">
		<a id="leftmenu-trigger" class="pull-left" data-toggle="tooltip" data-placement="bottom"></a>
        <div class="navbar-header pull-left">
            <a class="navbar-brand" href="../">Panel Gracza</a>
        </div>

        <ul class="nav navbar-nav pull-right toolbar">
        	<li class="dropdown">
        		<a href="#" class="dropdown-toggle username" data-toggle="dropdown"><span class="hidden-xs"><?php print $_SESSION['user']; ?> <i class="icon-caret-down icon-scale"></i></span><img src="//panel.polandcraft.eu/utils/generator/head?player=<?php print $_SESSION['user']; ?>"/></a>
        		<ul class="dropdown-menu userinfo arrow">
        			<li class="userlinks">
        				<ul class="dropdown-menu">
        					<li><a href="//panel.polandcraft.eu/profile">Edytuj Profil<i class="pull-right icon-pencil"></i></a></li>
        					<li class="divider"></li>
        					<li><a href="//panel.polandcraft.eu/?logout" class="text-right">Wyloguj się</a></li>
        				</ul>
        			</li>
        		</ul>
        	</li>
		</ul>
    </header>

        <nav id="page-leftbar" role="navigation">
            <ul class="acc-menu" id="sidebar">
                <li><a href="//panel.polandcraft.eu/"><i class="icon-home"></i> <span>Strona Główna</span></a ></li>
                <li><a href="//panel.polandcraft.eu/stats"><i class="icon-tasks"></i> <span>Statystyki Serwerowe</span></a> </li>
                <li><a href="//panel.polandcraft.eu/shop"><i class="icon-euro"></i> <span>Sklep Serwerowy</span></a> </li>
                <li><a href="//panel.polandcraft.eu/bans"><i class="icon-eye-open"></i> <span>Lista Zbanowanych</span></a> </li>
                <?php
                include("admins.php");
                if ($admins) {
                echo '
				<li class="divider"></li>
                <li><a href="#"><i class="icon-minus-sign"></i> <span>Narzędzia Administratorskie</span></a>
                    <ul class="acc-menu">
                        <li><a href="//panel.polandcraft.eu/admin/transactions"><span>Transakcje</span></a></li>
                        <li><a href="//panel.polandcraft.eu/admin/shop"><span>Sklep</span></a></li>
                        <li><a href="//panel.polandcraft.eu/admin/vouchers"><span>Vouchery</span></a></li>
						<li><a href="//panel.polandcraft.eu/admin/bans"><span>Banowanie</span></a></li>
                    </ul>
                 </li></ul>';
                }
                ?>
        </nav>