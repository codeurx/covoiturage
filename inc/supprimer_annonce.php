<?php
session_start();
require 'Database.php';
$db     = new Database();

$res = $db->DeleteAnnonce($_GET['id']);

$response_array['status'] = $res;
header('Content-type: application/json');
echo json_encode($response_array);