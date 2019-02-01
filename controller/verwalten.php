<?php
//########################CATEGORIES
if (isset($_POST["loeschen"]) && isset($_POST["catID"]))
{
	$cat = new Category(0);		
	$cat->delete($_POST["catID"]);
	$_SESSION["notification"] = array("type" => "info",
						"intro" => "Info: ",
						"text" => "Kategorie wurde gelöscht");
}
if (isset($_POST["add_cat"]))
{
	if($_POST["new_cat"]=="")
	{
		$_SESSION["notification"] = array("type" => "warning",
										"intro" => "Achtung: ",
										"text" => "Die Kategorie muss einen Name haben");	
	}
	else
	{
		$cat = new Category(0);
		$cat->insert(cleanString($_POST["new_cat"]));
		$_SESSION["notification"] = array("type" => "success",
							"intro" => "Info: ",
							"text" => "Kategorie wurde hinzugefügt");					
	}
}
if (isset($_POST["edit_catID"]))
{
	
	if ($_POST["edit_cat"]=="")
	{
		$_SESSION["notification"] = array("type" => "warning",
										"intro" => "Achtung: ",
										"text" => "Die Kategorie muss einen Name haben");			
	}
	else
	{
	$cat = new Category(cleanString($_POST["edit_catID"]));	
	$cat->update(cleanString($_POST["edit_cat"]));
	$_SESSION["notification"] = array("type" => "success",
						"intro" => "Info: ",
						"text" => "Kategorie wurde geändert");
	}
}
$categories = new Category(0);
$result = $categories->findAll();
$printCategory = "";
foreach ($result as $cat)
{
	if (isset($_POST["bearbeiten"]) && isset($_POST["catID"]) && $_POST["catID"] == $cat->getID())
	{
		$printCategory.= file_get_contents("views/verwalten_edit_cat.html");
		$printCategory = str_replace("{{CATID}}", $cat->getID(), $printCategory);
		$printCategory = str_replace("{{CATNAME}}", $cat->getName(), $printCategory);

	}
	else
	{	
		$printCategory.= file_get_contents("views/verwalten_categories.html");
		$printCategory = str_replace("{{CATID}}", $cat->getID(), $printCategory);
		$printCategory = str_replace("{{CATNAME}}", $cat->getName(), $printCategory);
	}

}
//########################LABELS
if (isset($_POST["loeschen"]) && isset($_POST["labID"]))
{
	$lab = new Label(0);		
	$lab->delete($_POST["labID"]);
	$_SESSION["notification"] = array("type" => "info",
						"intro" => "Info: ",
						"text" => "Schlagwort wurde gelöscht");	
}
if (isset($_POST["add_lab"]))
{
	if($_POST["new_lab"]=="")
	{
		$_SESSION["notification"] = array("type" => "warning",
										"intro" => "Achtung: ",
										"text" => "Das Schlagwort muss einen Name haben");	
	}
	else
	{				
		$lab = new Label(0);
		$lab->insert(cleanString($_POST["new_lab"]));	
		$_SESSION["notification"] = array("type" => "success",
							"intro" => "Info: ",
							"text" => "Schlagwort wurde hinzugefügt");
	}
}
if (isset($_POST["edit_labID"]))
{
	if($_POST["edit_lab"]=="")
	{
		$_SESSION["notification"] = array("type" => "warning",
										"intro" => "Achtung: ",
										"text" => "Das Schlagwort muss einen Name haben");			
	}
	else
	{
		$lab = new Label(cleanString($_POST["edit_labID"]));
		$lab->update(cleanString($_POST["edit_lab"]));		
		$_SESSION["notification"] = array("type" => "success",
							"intro" => "Info: ",
							"text" => "Schlagwort wurde geändert");					
	}
}
$labels = new Label(0);
$result = $labels->findAll();
$printLabel = "";
foreach ($result as $lab)
{
	if (isset($_POST["bearbeiten"]) && isset($_POST["labID"]) && $_POST["labID"] == $lab->getID())
	{
		$printLabel.= file_get_contents("views/verwalten_edit_lab.html");
		$printLabel = str_replace("{{LABID}}", $lab->getID(), $printLabel);
		$printLabel = str_replace("{{LABELNAME}}", $lab->getName(), $printLabel);
	}
	else
	{
		$printLabel.= file_get_contents("views/verwalten_labels.html");
		$printLabel = str_replace("{{LABID}}", $lab->getID(), $printLabel);
		$printLabel = str_replace("{{LABELNAME}}", $lab->getName(), $printLabel);
	}
}

?>
