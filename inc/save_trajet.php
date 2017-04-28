<?php
session_start();
require 'Database.php';
$db     = new Database();

$userid = $_SESSION['userid'];
$depart = addslashes($_POST['depart']);
$ar     = addslashes($_POST['ar']);
$places = addslashes($_POST['places']);
$date   = addslashes($_POST['date']);
$arrive = addslashes($_POST['arrive']);
$trajet = addslashes($_POST['trajet']);
$time   = addslashes($_POST['time']);
$price  = addslashes($_POST['price']);

$res    = $db->SaveTrajet($userid,$depart,$ar,$places,$date,$arrive,$trajet,$time,$price);

$response_array['status'] = $res;
header('Content-type: application/json');
echo json_encode($response_array);