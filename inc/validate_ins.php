<?php
require 'Database.php';
$db        = new Database();
$fname     = addslashes($_POST['fname']);
$lname     = addslashes($_POST['lname']);
$mail      = addslashes($_POST['mail']);
$password  = addslashes($_POST['password']);
$birthdate = addslashes($_POST['birthdate']);
$gender    = addslashes($_POST['gender']);
$tel       = addslashes($_POST['tel']);

$res       = $db->RegisterUser($fname,$lname,$mail,$password,$birthdate,$gender,$tel);

$response_array['status'] = $res;
header('Content-type: application/json');
echo json_encode($response_array);
