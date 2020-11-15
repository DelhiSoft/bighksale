<?php
include "setup.php";
if (isset($_REQUEST['action'])) {
    include "action/route.php";
}
include "guard.php";
echo $twig->render($view, $data);
