<?php
session_start();
require 'Database.php';
$db  = new Database();

$userid     = $_SESSION['userid'];
$pic        = $_FILES['profilepic'];
$profession = addslashes($_POST['profession']);
$mark       = addslashes($_POST['mark']);
$color      = addslashes($_POST['color']);
$air        = addslashes($_POST['air']);
$tabac      = addslashes($_POST['tabac']);

$res = $db->UpdateProfile($userid,$pic,$profession,$mark,$color,$air,$tabac);

$response_array['status'] = $res;
header('Content-type: application/json');
echo json_encode($response_array);