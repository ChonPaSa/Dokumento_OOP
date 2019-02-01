<?php

$contact = $location = "";
$cat = new Category(0);
$labels = array();

if(isset($_POST["docname"]))
{	
	if ($_POST["docname"]=="")
	{
		$_SESSION["notification"] = array("type" => "warning",
									"intro" => "Achtung: ",
									"text" => "Sie müssen einen Name angeben");
	}
	else
	{
		$docname = cleanString($_POST["docname"]);
		if (!empty($_POST["labels"]))
		{
			for($i=0; $i< count($_POST["labels"]); $i++)
			{
				$labels[$i] = new Label($_POST["labels"][$i]);	
			}
		}
		if (!empty($_POST["category"]))
		{
			$cat = new Category($_POST["category"]);
		}
		if (!empty($_POST["contact"]))
		{
			$contact  = cleanString($_POST["contact"]);
		}
		if (!empty($_POST["location"]))
		{	
			$location =  cleanString($_POST["location"]);
		}
		$url = $_SESSION["url"];
		unset($_SESSION["url"]);
		$doc = new Document(array("name" => $docname, 
									"url" => $url, 
									"contact" => $contact, 
									"location" => $location, 
									"category" => $cat, 
									"labels" => $labels));
		$doc->insertDoc();  //writes object in DB
		if(!empty($labels))
		{
			$doc->linkLabel();
		}
		$_SESSION["notification"] = array("type" => "success",
									"intro" => "Yuchuuu: ",
									"text" => "Ein Dokument wurde hochgelanden");
	}
}

?>	






















	