<?php
require 'Database.php';
$db           = new Database();
$mail         = addslashes($_POST['mail']);
$password     = md5(addslashes($_POST['password']));

$res       = $db->ConnectUser($mail,$password);

$response_array['status'] = $res;
header('Content-type: application/json');
echo json_encode($response_array);
