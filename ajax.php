<?php
$toilet = isset($_GET['toilet']) ? $_GET['toilet'] : null;
$all = isset($_GET['all']);

include('fetch.php');
if ($all) {
    echo json_encode(selectAllLogs($toilet));
} else {
   $arrReponseM = selectLastLog(1);
   $reponseM_datetime = new DateTime($arrReponseM['timestamp']);
   $arrReponseM['timestamp'] = $reponseM_datetime->format("H:i");
   $arrReponseF = selectLastLog(0);
   $reponseF_datetime = new DateTime($arrReponseF['timestamp']);
   $arrReponseF['timestamp'] = $reponseF_datetime->format("H:i");
   echo json_encode(array('0'=>$arrReponseF,'1'=>$arrReponseM));
}
?>
