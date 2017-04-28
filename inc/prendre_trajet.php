<?php
require 'Database.php';
$db     = new Database();

$id_trajet = addslashes($_POST['id_trajet']);
$res       = $db->UpdatePlaces($id_trajet);

$response_array['status'] = $res;
header('Content-type: application/json');
echo json_encode($response_array);