<?php
class man {

    public $name;
    public $age;
    public $address;

    function Info($fname){

        $this->name=$fname;
        return $this->name;
    }

}


$obj=new man();
echo $obj->Info('Leon');

?>
