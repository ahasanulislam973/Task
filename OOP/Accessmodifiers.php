<?php
class car
{
    public $name;
    protected $color;
    private $brand;

    public function set_name($name)
    {
        $this->name=$name;
    }

    protected function set_color($color){
        $this->color=$color;
    }


    private function set_brand($brand)
    {
        $this->brand=$brand;
    }

}

$obj=new car();

$obj->name="CRV";


echo$obj->name;


