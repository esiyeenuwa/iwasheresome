<?php
	//Add Device Atlas to the php block:
include "DA_12/Mobi/Mtld/DA/Api.php";
//fetch the database of properties
$tree = Mobi_Mtld_DA_Api::getTreeFromFile("DA_12/sample/json/DeviceAtlas.json");
//Get the User Agent Header sent by Device
$ua = $_SERVER['HTTP_USER_AGENT'];
//Which vendor? Get the ‘vendor’ property
try{
    $vendor = Mobi_Mtld_DA_Api::getProperties($tree, $ua, 'vendor');
} catch (Mobi_Mtld_Da_Exception_InvalidPropertyException $e) {
    $vendor = "Unknown";
}
//print_r ($vendor);


 //$tree = Mobi_Mtld_DA_Api::getTreeFromFile("DA_12/sample/Sample.json");
 $prps = Mobi_Mtld_DA_Api::getProperties($tree, $ua);
 $prop = Mobi_Mtld_DA_Api::getProperty($tree, $ua, "displayWidth");
print_r ($prop);
?>


 
	
	
	
	
	
	