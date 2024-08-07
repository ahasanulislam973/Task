<?php
class man {

    public $name;
    public $age;
    public $address;

    function Info(){

        return 'This is function';
    }

}


$obj=new man();
$obj->name="Leon";
echo $obj->name."<br>";

$obj1=new man();
$obj1->name="Ahasanul";
echo $obj1->name;
?>