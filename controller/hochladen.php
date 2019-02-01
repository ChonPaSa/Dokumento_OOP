<?php	
if (!$_FILES["docdatei"]["error"] == UPLOAD_ERR_NO_FILE)
{
	$datei_original = $_FILES["docdatei"]["name"];  //name of the file
	$datei_tempname = $_FILES["docdatei"]["tmp_name"];  // file name in the server
	$ext = pathinfo($datei_original, PATHINFO_EXTENSION);
	$neuer_dateiname = uniqid("doc_").".".$ext; 
	move_uploaded_file($datei_tempname, "data/uploads/".$neuer_dateiname);
	$_SESSION["url"] = "data/uploads/$neuer_dateiname";
	$url = "data/uploads/$neuer_dateiname";
	header("location: index.php?action=hochladen2");
}
else
{
	$_SESSION["notification"] = array("type" => "danger",
									"intro" => "Fehler: ",
									"text" => "Sie müssen eine Datei auswählen");
}

?>	






















	