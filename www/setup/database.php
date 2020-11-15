<?php
$server=explode(".",$_SERVER["SERVER_NAME"]);
$lastkey=count($server)-1;
// return  ($server[$lastkey]=="localhost")?
return [
    "host"=>"localhost",
    "user"=>"root",
    "pass"=>"",
    "name"=>"bighk"
];
// :[
//     "host"=>"localhost",
//     "user"=>"digitin_bighk",
//     "pass"=>"MAEfGpRe",
//     "name"=>"digitin_bighk"
// ];
