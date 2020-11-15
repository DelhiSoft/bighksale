<?php
$p = explode("/", $_REQUEST['path']);
$db->delete("slider", "where id={$p[2]}");
header("Location: /admin/slider");
die;
