<?php
function cleanString($data)
{
	$data = trim($data);
	$data = strip_tags($data);
	$data = htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
	return $data;
}

function replaceValues($doc, $file, $disabled)
{
	$html = file_get_contents($file);
	$html = str_replace("{{DOCNAME}}", $doc->getName(), $html);
	if ($doc->getLabels())
	{
		$html = markLabels("{{LABELS}}", $doc->getLabels(), $html, $disabled);
	}
	else
	{
		$html = readLabels($html, $disabled);
	}
	$html = markCategories("{{CATEGORIES}}", $doc->getCategory(), $html);
	$html = str_replace("{{LOCATION}}", $doc->getLocation(), $html);
	$html = str_replace("{{CONTACT}}", $doc->getContact(), $html);
	$html = str_replace("{{DOCID}}", $doc->getID(), $html);
	$html = str_replace("{{DOCUMENT}}", $doc->getUrl(), $html);
	$html = str_replace("{{TIMESTAMP}}",date("Y-m-d", strtotime($doc->getTimestamp()) ), $html);
	return $html;
}


function markLabels($tag, $labelObjects ,$html, $disabled)
{
	$db = new Database();
	$data = $db->sqlSelect("SELECT * FROM labels ORDER BY name");
	$labels = "";
	
 	$marked = array();
	foreach ($labelObjects as $key => $value)
	{
		$marked[]= $labelObjects[$key]->getID();
	} 
	foreach ($data as $key => $value)
	{
		$labels.= '<input type="checkbox" value="'.$data[$key]["labID"].'" name="labels[]" ';
	    
		 if (in_array($data[$key]["labID"],$marked))
		{
			$labels .= ' checked ';
		} 
		$labels.=$disabled.'/> '.$data[$key]["name"].'<br />';
	}
	$html = str_replace($tag, $labels, $html);
	return $html; 
}

function markCategories($tag, $catID, $html)
{
	$db = new Database();
	$data = $db->sqlSelect("SELECT * FROM categories ORDER BY name;");
	$categories = '<option value="0" >--</option>';		
	foreach ($data as $key => $value)
	{
		$categories.= '<option value="'.$data[$key]["catID"].'"';
		if ($data[$key]["catID"] == $catID)
		{
			$categories.= ' selected ';
		}
		$categories.= '>'.$data[$key]["name"].'</option>';		
	}

	$html = str_replace($tag, $categories, $html);	
	return $html;
}


function readLabels($html, $disabled)
{
	$db = new Database();
	$data = $db->sqlSelect("SELECT * FROM labels ORDER BY name");
	$labels = "";
	foreach ($data as $key => $value)
	{
		$labels.= '<input type="checkbox" value="'.$data[$key]["labID"].'" name="labels[]" ';
		$labels.= $disabled.' /> '.$data[$key]["name"].'<br />';
	}
	$html = str_replace("{{LABELS}}", $labels, $html);
	return $html; 
}
function readCategories($html)
{
	$db = new Database();
	$data = $db->sqlSelect("SELECT catID, name FROM categories ORDER by name");
	$categories = "";
	foreach ($data as $key => $value)
	{
		$categories.= '<option value="'.$data[$key]["catID"].'">'.$data[$key]["name"].'</option>';
	}
	$html = str_replace("{{CATEGORIES}}", $categories, $html);	
	return $html;
}

function tableResult($html, $docs)
{
	$tableResult ="";
   
	foreach ($docs as $key => $doc)
	{
		$tableResult.= file_get_contents("views/table_result.html");
		$tableResult = str_replace("{{DOCNAME}}", $doc->getName(), $tableResult);
		$labels="";
		foreach ($doc->getLabels() as $label)
		{
			$labels.= $label->getName().'<br />';
		}
		$tableResult = str_replace("{{LABELS}}", $labels, $tableResult);
		$tableResult = str_replace("{{CATEGORIES}}", $doc->category->getName(), $tableResult);
		$tableResult = str_replace("{{LOCATION}}", $doc->getLocation(), $tableResult);
		$tableResult = str_replace("{{CONTACT}}", nl2br($doc->getContact()), $tableResult);
		$tableResult = str_replace("{{DOCID}}", $doc->getID(), $tableResult);
		$tableResult = str_replace("{{URL}}", $doc->getUrl(), $tableResult);
		$tableResult = str_replace("{{TIMESTAMP}}",date("Y-m-d", strtotime($doc->getTimestamp())), $tableResult);
	}
	$html = str_replace("{{TABLE_RESULT}}", $tableResult, $html);
	return $html;
}


function notifications()
{
	$printNotifications="";
	if (isset($_SESSION["notification"]))
	{
		
		$printNotifications= file_get_contents("views/notification.html");
		$printNotifications = str_replace("{{TYPE}}",$_SESSION["notification"]["type"], $printNotifications);
		$printNotifications = str_replace("{{INTRO}}", $_SESSION["notification"]["intro"], $printNotifications);
		$printNotifications = str_replace("{{NOTIFICATIONTEXT}}", $_SESSION["notification"]["text"], $printNotifications);
		unset($_SESSION["notification"]);
 	} 	
	return $printNotifications;
}

?>
