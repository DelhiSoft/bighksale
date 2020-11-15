<?php
switch ($r['action']) {
    case "register":
        $data = [
            "firstname" => $r['fname'],
            "lastname" => $r['lname'],
            "phone" => $r['phone'],
            "email" => $r['email'],
            "pass" => $r['pass'],
            "active" => 1,
            "updated_from" => $_SERVER['REMOTE_ADDR'],
        ];
        if (count($db->select("client", "*", "where email='{$data['email']}'")) != 0) {
            echo "Email registered";
        } elseif (count($db->select("client", "*", "where phone='{$data['phone']}'")) != 0) {
            echo "Phone number registered";
        } else {
            $db->insert("client", $data);
        }
        header("Location: /");
        die;
        break;
    case "login":
        $info = $db->select("client", "*", "where email like '{$r['user']}' or phone like '{$r['user']}' and pass=md5('{$r['password']}')");
        $_SESSION['login'] = $info[0];
        break;
}
