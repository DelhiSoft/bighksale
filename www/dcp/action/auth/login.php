<?php
$user = $db->select("auth", "*", "where user like '{$r['user']}' and pass = md5('{$r['pass']}')");
if (count($user) == 1) {
    unset($user[0]['pass']);
    unset($user[0]['updated_on']);
    unset($user[0]['updated_from']);
    $_SESSION['user'] = $user[0];
    header("Location: /dcp");
} else {
    $error = "There is some error";
}
