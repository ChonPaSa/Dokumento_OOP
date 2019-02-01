<?php

if(isset($_POST["bearbeiten"]))
{
	$this->headline = "Bearbeiten";
	$doc = new Document(array("docID" => $_POST["docID"]));
	$doc->find($doc);
	$this->content = replaceValues($doc,"views/suchen_bearbeitung.html","");
}

elseif(isset($_POST["loeschen"]))
{
	$this->headline = "Löschen";
	$doc = new Document(array("docID" => $_POST["docID"]));
	$doc->find($doc);
	$this->content = replaceValues($doc,"views/suchen_loeschen.html","disabled");
}

elseif (isset($_POST["bearbeitung_speichern"]))
{	
	$this->headline = "Suchen";
		$docID = cleanString($_POST["docID"]);
		$docname = cleanString($_POST["docname"]);
		$contact  = cleanString($_POST["contact"]);
		$location =  cleanString($_POST["location"]);	
		$timestamp = cleanString($_POST["timestamp"]);
		$parameters = array("docID" => $docID,
							"name" => $docname, 
							"contact" => $contact, 
							"location" => $location,
							"timestamp" => $timestamp);
		if (!empty($_POST["labels"]))
		{
			for($i=0; $i< count($_POST["labels"]); $i++)
			{
				$labels[$i] = new Label($_POST["labels"][$i]);	
			}
			$parameters["labels"] = $labels;
		}
		if (!empty($_POST["category"]))
		{
			$cat = new Category($_POST["category"]);
			$parameters["category"] = $cat;
		}
		$doc = new Document($parameters);
		$doc->findUrl($doc);

	if(cleanString($_POST["docname"] ==""))
	{
		$this->content = replaceValues($doc,"views/suchen_bearbeitung.html","");
		$_SESSION["notification"] = array("type" => "warning",
					"intro" => "Achtung: ",
					"text" => "Sie müssen einen Name angeben");
	}
	else
	{
		$doc->updateDoc();  
		$doc->linkLabel();
		$this->content = replaceValues($doc,"views/confirm.html","disabled");
		$_SESSION["notification"] = array("type" => "success",
					"intro" => "Info: ",
					"text" => "Ein Dokument wurde geändert");
	}
}
elseif (isset($_POST["dokument_loeschen"]))
	{
		$this->headline = "Suchen";
		$doc = new Document(array( "docID" => cleanString($_POST["docID"])));
		$doc->find($doc);
		$this->content = replaceValues($doc,"views/confirm.html","disabled");
		unlink($doc->getUrl());  //delete the document from FS
		$doc->deleteDoc();
		$_SESSION["notification"] = array("type" => "info",
						"intro" => "Info: ",
						"text" => "Ein Dokument wurde gelöscht");
	}
else
{
	
	
//create query
 	if(empty($_POST["labels"]))
	{
		$sql = 'SELECT DISTINCT documents.docID, documents.name, url, category, contact, location, timestamp
			FROM documents 	LEFT JOIN categories ON categories.catID = documents.category
				WHERE  documents.name LIKE "%'.cleanString(@$_POST["docname"]).'%" ';
	}
	else
	{
		$checked = implode(",",$_POST["labels"]); //select documents with an schlagwort in the list $checked
		$sql = 'SELECT DISTINCT documents.docID, documents.name,  url, category, contact, location, timestamp
			FROM documents INNER JOIN mapping_labels ON mapping_labels.docID = documents.docID
			INNER JOIN labels ON mapping_labels.labID = labels.labID 
			LEFT JOIN categories ON categories.catID = documents.category
			WHERE documents.name LIKE "%'.cleanString(@$_POST["docname"]).'%" AND labels.labID IN ('.$checked.')';
	}
	
	if (isset($_POST["timestamp"]) && $_POST["timestamp"] != "")  //Jahr
	{
		$sql.= ' AND YEAR(documents.timestamp) = '.cleanString($_POST["timestamp"]);

	}
	if (isset($_POST["category"]) && $_POST["category"] != 0)  //Kategorie
	{
		$sql.= ' AND documents.category = '.$_POST["category"];		
	}	
	if (isset($_POST["contact"]) && $_POST["contact"] != "")	//absender /empfänger
	{
		$sql.= ' AND documents.contact LIKE "%'.cleanString($_POST["contact"]).'%"';		
	}
	if (isset($_POST["location"]) && $_POST["location"] != "")	//Ablageort
	{
		$sql.= ' AND documents.location LIKE "%'.cleanString($_POST["location"]).'%"';		
	}	

//create array of document objects
	$db = new Database();
	$data = $db->sqlSelect($sql);
	
     $_SESSION["notification"] = array("type" => "info",
						"intro" => "Info: ",
						"text" => count($data)." Dokumente wurden gefunden");	
	$docs = array();
	foreach ($data as $doc)
	{
		$sqlLabels = "SELECT labID FROM mapping_labels 
						WHERE mapping_labels.docID = ".$doc["docID"];
		$labelsData = $db->sqlSelect($sqlLabels);
		$labels = array();
		foreach ($labelsData as $label)
		{
			$labelObject = new Label($label["labID"]);
			array_push($labels, $labelObject);
		}
		$catObject = New Category($doc["category"]);
		$docObject = New Document(array("name" => $doc["name"], 
								"url" => $doc["url"], 
								"contact" => $doc["contact"],
								"location" =>  $doc["location"],
								"category" => $catObject,
								"labels" =>  $labels));
		$docObject->setID($doc["docID"]);
		$docObject->setTimestamp($doc["timestamp"]);
		array_push($docs,$docObject);
	}
	$html = file_get_contents("views/suchen.html");
	$html = readCategories($html);
	$html = readLabels($html, "");
	if(isset($docs))
	{
		$html = tableResult($html, $docs);
	}
	$this->content = $html;

}
?>
