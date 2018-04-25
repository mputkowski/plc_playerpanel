<?php
require($_SERVER["DOCUMENT_ROOT"] . "/utils/pp_kernel/global.php");
?>

<div id="page-content">
    <div id="wrap">
        <div id="page-heading">
            <h1>Sklep Serwerowy</h1>
		</div>
<div class='container'>

<?php
include("utils/modules/shop/buy.php");
include("utils/modules/shop/history.php");
include("utils/modules/shop/admins.php");
include("utils/modules/shop/menu.php");
?>

</div>
</div>
</div>