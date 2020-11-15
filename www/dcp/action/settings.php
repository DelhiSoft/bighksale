<?php
unset($r['action']);
$resp = [];
foreach ($r as $key => $value) {
    $resp[] = $db->update("settings", ["details" => $value, "updated_by" => $_SESSION['user']['id']], "where name='{$key}'", true);
}
