<?php
$json='[
	{
	"name" : "Raqibul Hasan",
	"age"  : "33",
	"school" : "ABCD Public school"
	},
	{
	"name" : "Armaan Hossain Chaklader",
	"age"  : "27",
	"school" : "St. Marie school"
	},
	{
	"name" : "Sudipto Saha",
	"age"  : "27",
	"school" : "St. Columba school"
	}
]';
$jsonData=json_decode($json);
foreach($jsonData as $value){
    /*print "<pre>";
    print_r($value->name);
    print "</pre>";
    exit;*/
   print_r($value);
}