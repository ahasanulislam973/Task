<?php
class man {

    public $name='Leon';
    public $age='22';
    public $address='Dhaka';

    function Info(){

        return 'This is function';
    }

}


$obj=new man();

echo $obj->name."<br>";
echo $obj->age."<br>";
echo $obj->Info();

?>