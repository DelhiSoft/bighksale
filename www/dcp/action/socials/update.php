<?php
$db->update("social",['link'=>$r['Facebook']],"where id = 1");
$db->update("social",['link'=>$r['Twitter']],"where id = 2");
$db->update("social",['link'=>$r['Linkedin']],"where id = 3");
header("Location: /dcp/social");
die;
