<?php
session_start();
require 'Database.php';
$db      = new Database();
$userid  = $_SESSION['userid'];
$depart  = addslashes($_POST['start']);
$arrive  = addslashes($_POST['destination']);
$ar      = addslashes($_POST['ar']);
$places  = addslashes($_POST['places']);
$trajet  = addslashes($_POST['trajet']);
$time    = addslashes($_POST['time']);
$price   = addslashes($_POST['price']);
if ($_POST['date']!=''){
    $date = $_POST['date'];
}else{
    $date = '0000-00-00';
}

$res    = $db->SaveTrajet($userid,$depart,$ar,$places,$date,$arrive,$trajet,$time,$price);

if ($_POST['way_1']!=''){
    $q = $db->SelectTrajet($userid,$depart,$ar,$places,$date,$arrive,$trajet,$time,$price);
    foreach ($q as $r){
        $id_traj = $r['idtrajet'];
    }
    for ($i=1;$i<=100;$i++){
        if ((isset($_POST['way_'.$i]))&&($_POST['way_'.$i]!='')){
            $step = addslashes($_POST['way_'.$i]);
            $db->SaveStep($id_traj,$depart,$step);
        }
    }
}

$response_array['status'] = $res;
header('Content-type: application/json');
echo json_encode($response_array);