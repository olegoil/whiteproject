<?php

header("Access-Control-Allow-Origin: *");

include '../conns/whiteauth.php';
$sql = new sql();

if (!empty($_FILES)) {

    function findexts($filename) {
		$filename = strtolower($filename);
		$exts = split("[/\\.]", $filename);
		$n = count($exts)-1;
		$exts = $exts[$n];
		return $exts;
	}

	if($sql->getUser()) {

		$when = time();
		$hash = $sql->getUser()['user_id'] . '_' . md5($when);
		$uplfile = $_FILES["file"]["name"];
		$ext = findexts($uplfile);
		$upllocation = $hash.'.'.$ext;
		$targetFile = "../uploads/".$upllocation;

		if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {

			$sql->uploadFile($upllocation, $_GET['t']);

			$str = array('success' => 1);
			echo json_encode($str);

		}

	}
	else {
		$str = array('success' => 0);
		echo json_encode($str);
	}

}

?>
