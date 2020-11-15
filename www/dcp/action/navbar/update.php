<?php
foreach ($r as $key => $value) {
    $id=explode("_",$key);
    if(count($id)==2)
        $db->update("navbar",["name"=>$value],"where id ={$id[1]}");
}
