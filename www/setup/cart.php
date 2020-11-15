<?php
class Cart
{
    private $cart = [];
    public function __Construct()
    {
        if (isset($_SESSION['cart'])) {
            $this->cart = $_SESSION['cart'];
        }
    }
    public function add($item){
        $update=true;
        foreach ($this->cart as $key => $value) {
            if(($value['product']==$item['product'])&& $update){
                $value['quant']+=$item['quant'];
                $this->cart[$key]=$value;
                $update=false;
            }
        }
        if($update){
            $this->cart[]=$item;
        }
        $this->update();
    }
    public function remove($item){
        foreach ($this->cart as $key => $value) {
            if($value['product']==$item['product']){
                unset($this->cart[$key]);
            }
        }
        $this->update();
    }
    private function update(){
        $_SESSION['cart']=$this->cart;
    }
    public function getCart(){
        return $this->cart;
    }
    public function count(){
        return array_reduce(
            $this->cart,
            function ($a,$b){
                return $a+$b['quant'];
            },
            0);
    }
    public function change($item){
        $update=true;
        foreach ($this->cart as $key => $value) {
            if(($value['product']==$item['product'])&& $update){
                $value['quant']=$item['quant'];
                $this->cart[$key]=$value;
                $update=false;
            }
        }
        if($update){
            $this->cart[]=$item;
        }
        $this->update();
    }
}