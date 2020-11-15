<?php
$address = [
    "link" => $r['address_link'],
    "text" => $r['address_text'],
];
$db->update("contact", $address, "where id =1");
$phone = [
    "link" => $r['phone_link'],
    "text" => $r['phone_text'],
];
$db->update("contact", $phone, "where id =2");
$email = [
    "link" => $r['email_link'],
    "text" => $r['email_text'],
];
$db->update("contact", $email, "where id =3");
$whatsapp = [
    "link" => $r['whatsapp_link'],
    "text" => $r['whatsapp_text'],
];
$db->update("contact", $whatsapp, "where id =4");
header("Location: /dcp/settings");
die;