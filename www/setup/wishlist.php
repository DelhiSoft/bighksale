<?php
class Wishlist{
    private $wishlist=[];
    public function __Construct(){
        if (isset($_SESSION['wishlist'])) {
            $this->wishlist=$_SESSION['wishlist'];
        }
    }
    public function add($item){
        $update=true;
        foreach ($this->wishlist as $key => $value) {
            if($update && ($item['product']==$value['product'])){
                $update=false;
            }
        }
        if($update){
            $this->wishlist[]=$item;
        }
        $this->update();
    }
    public function remove($item){
        $update=true;

        foreach ($this->wishlist as $key => $value) {
            if($update && ($item['product']==$value['product'])){
                $update=false;
                unset($this->wishlist[$key]);
            }
        }
        $this->update();
    }
    public function toggle($item){
        if ($this->has($item)) {
            $this->remove($item);
        } else {
            $this->add($item);
        }
        
    }
    public function count(){
        return count($this->wishlist);
    }
    public function clear(){
        $this->wishlist=[];
        $this->update();
    }
    public function getWishlist(){
        return $this->wishlist;
    }
    private function update(){
        $list=[];
        foreach($this->wishlist as $value){
            $list[]=$value;
        }
        $this->wishlist=$list;
        $_SESSION['wishlist']=$this->wishlist;
    }
    public function has($item){
        foreach ($this->wishlist as $key => $value) {
            if($item['product']==$value['product']){
                return true;
            }
        }
        
        return false;
    }
}