<?php
/*error_reporting(E_ALL);
ini_set('display_errors', true);*/

if (!class_exists('DateTime'))
    require_once('DateTime.class.php');
include 'class.bugzillaxml.php';
include "config.php";

//Copies the posted array of fields
$paramArr = $_POST;

//TODO Sanitize the method as well
//
//Finds the method parameter 
$method = $paramArr['method'];

//Here we instantiate a new BugzillaXML object with the passed in method
$bugzilla = new BugzillaXML($method);

//Now we destroy the method part of the array because there is no Bugzilla method field in the parameters section:
unset($paramArr['method']);

//Now the members are added dynamically so as to remove repetition
foreach ($paramArr as $k => $v) {
    if ($k == 'ids' || $k == 'limit') {
        $type = 'int';
    } else {
        $type = 'string';
    }
    //Now we add the parameters and specify their type, note that this setup requires the exact bugzilla field name
    $bugzilla->addMember($k, $v, $type);
}

//Then submit
echo $bugzilla->submit();
?>
