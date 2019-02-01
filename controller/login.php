<?php
$db = new Database();
$parameters = array(cleanString($_POST["userName"]));
$user = $db->sqlSelect("SELECT * FROM users WHERE userName = ?",$parameters);
if(count($user) == 1)
{							
	$hash = $user[0]["password"]; 
	if(password_verify(cleanString($_POST["password"]), $hash))
	{
		$_SESSION["userName"] = $user[0]["userName"];
	}
	else
	{
		$_SESSION["notification"] = array("type" => "danger",
									"intro" => "Fehler: ",
									"text" => "Falsches Passwort");
	}
}
else
{
	$_SESSION["notification"] = array("type" => "danger",
									"intro" => "Fehler: ",
									"text" => "Benutzer nicht vorhanden");
}
?>