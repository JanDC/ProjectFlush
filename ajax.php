<?php
$toilet = isset($_GET['toilet']) ? $_GET['toilet'] : null;
$all = isset($_GET['all']);

include('fetch.php');
if ($all) {
	echo json_encode(selectAllLogs($toilet));
} else {
	$arrReponseM = selectLastLog(1);
	$reponseM_datetime = new DateTime($arrReponseM['timestamp']);
	$dueM= new DateTime($arrReponseM['timestamp']+ selectAverageDurationByToilet(1));
	$arrReponseM['timestamp'] = $reponseM_datetime->format("H:i");
	$arrReponseM['due']=$dueM->format("H:i");


	$arrReponseF = selectLastLog(0);
	$reponseF_datetime = new DateTime($arrReponseF['timestamp']);
	$dueF= new DateTime($arrReponseF['timestamp']+ selectAverageDurationByToilet(0));
	$arrReponseF['timestamp'] = $reponseF_datetime->format("H:i");
	$arrReponseF['due']=$dueF->format("H:i");
	
	echo json_encode(array('0'=>$arrReponseF,'1'=>$arrReponseM));
}
?>
